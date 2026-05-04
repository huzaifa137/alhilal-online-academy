<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('class_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->date('enrollment_date')->nullable();
            $table->enum('status', ['active', 'completed', 'suspended', 'expelled'])->default('active');
            $table->enum('payment_status', ['paid', 'partial', 'pending'])->default('pending');
            $table->decimal('amount_paid', 10, 2)->default(0);
            $table->timestamps();
            
            $table->unique(['class_id', 'student_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('class_enrollments');
    }
};