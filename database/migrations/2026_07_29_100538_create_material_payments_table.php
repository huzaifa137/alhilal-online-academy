<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tracks per-material payment PER STUDENT — the same pattern used by
 * `lesson_payments`. A student can only access a paid subject material
 * if a row exists here for them (or the material is free).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('subject_material_id')->constrained('subject_materials')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');

            $table->foreignId('payment_transaction_id')
                ->nullable()
                ->constrained('payment_transactions')
                ->nullOnDelete();

            $table->string('amount_paid')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            $table->unique(['subject_material_id', 'student_id'], 'unique_material_student');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_payments');
    }
};