<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('exam_attempt_id')->constrained()->onDelete('cascade');
            $table->decimal('score', 5, 2);
            $table->decimal('percentage', 5, 2);
            $table->boolean('is_passed');
            $table->integer('attempt_number')->default(1);
            $table->json('answers')->nullable();
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->index(['exam_id', 'student_id', 'attempt_number']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('exam_results');
    }
};