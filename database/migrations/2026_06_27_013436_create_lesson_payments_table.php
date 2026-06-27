<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Tracks per-lesson payment PER STUDENT.
     *
     * Previously, paying for a lesson updated a single `lesson_payment_status`
     * column directly on the `lessons` table — which is global, so the moment
     * ANY student paid for a lesson, it appeared "Paid" for every student.
     *
     * This table fixes that: one row = one student has paid for one lesson.
     * A student can only access a lesson if a row exists here for them
     * (or the lesson is free).
     */
    public function up(): void
    {
        Schema::create('lesson_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');

            // Link back to the MarzPay transaction that paid for this, if any
            // (nullable so manual/teacher-granted access is also possible).
            $table->foreignId('payment_transaction_id')
                ->nullable()
                ->constrained('payment_transactions')
                ->nullOnDelete();

            $table->string('amount_paid')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            // A student can only have ONE paid record per lesson.
            $table->unique(['lesson_id', 'student_id']);
        });

        // ── Backfill ─────────────────────────────────────────────────────
        // Recreate real per-student payment history from the actual completed
        // MarzPay transactions (payment_transactions.payment_type = 'lesson').
        // We deliberately do NOT look at lessons.lesson_payment_status here —
        // that column only tells us *a* student paid, never *which* one, so it
        // cannot be trusted to grant access to anyone.
        $rows = \Illuminate\Support\Facades\DB::table('payment_transactions')
            ->where('payment_type', 'lesson')
            ->where('status', 'completed')
            ->get();

        foreach ($rows as $row) {
            \Illuminate\Support\Facades\DB::table('lesson_payments')->insertOrIgnore([
                'lesson_id' => $row->payable_id,
                'student_id' => $row->student_id,
                'payment_transaction_id' => $row->id,
                'amount_paid' => $row->amount,
                'paid_at' => $row->updated_at,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson_payments');
    }
};