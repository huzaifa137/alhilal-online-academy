<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Adds 'material' as an allowed payment_type on payment_transactions so
 * subject material (PDF) payments can flow through the same MarzPay
 * initiate → webhook → handleSuccessfulPayment pipeline used for
 * class and lesson payments.
 */
return new class extends Migration {
    public function up(): void
    {
        // Raw ALTER because changing an ENUM's allowed values isn't
        // supported through Schema::table() without doctrine/dbal.
        DB::statement("ALTER TABLE payment_transactions MODIFY COLUMN payment_type ENUM('class', 'lesson', 'material') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE payment_transactions MODIFY COLUMN payment_type ENUM('class', 'lesson') NOT NULL");
    }
};