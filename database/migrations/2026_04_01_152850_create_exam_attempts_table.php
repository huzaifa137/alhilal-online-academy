<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamAttemptsTable extends Migration
{
    public function up()
    {
        Schema::create('exam_attempts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('exam_id');
            $table->decimal('score', 5, 2)->default(0);
            $table->decimal('percentage', 5, 2)->default(0);
            $table->string('honors_classification')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->integer('duration_taken')->nullable(); // in minutes
            $table->boolean('is_passed')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
            
            // Indexes
            $table->index(['user_id', 'exam_id']);
            $table->index('completed_at');
            $table->index('is_passed');
        });
    }

    public function down()
    {
        Schema::dropIfExists('exam_attempts');
    }
}