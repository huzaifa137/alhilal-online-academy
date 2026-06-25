<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Stores every MarzPay payment transaction so we can track status
     * via webhooks and reconcile with enrollments / lessons.
     */
    public function up(): void
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();

            // Our internal UUID reference sent to MarzPay
            $table->uuid('reference')->unique();

            // MarzPay's own transaction UUID (returned after initiation)
            $table->string('marzpay_uuid')->nullable()->index();

            // Who initiated the payment
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');

            // What is being paid for
            $table->enum('payment_type', ['class', 'lesson']);
            $table->unsignedBigInteger('payable_id');   // class_id or lesson_id

            // Payment details
            $table->unsignedInteger('amount');           // in UGX
            $table->enum('method', ['mtn', 'airtel', 'card'])->nullable();
            $table->string('phone_number')->nullable();  // null for card payments

            // Status lifecycle: pending → processing → completed / failed / cancelled
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'cancelled', 'sandbox'])
                  ->default('pending');

            // For card payments — the URL the student must be redirected to
            $table->string('redirect_url', 512)->nullable();

            // Raw webhook payload received from MarzPay
            $table->json('webhook_payload')->nullable();

            // Provider transaction ID from MTN/Airtel/Card gateway
            $table->string('provider_transaction_id')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
