// database/migrations/2024_01_01_000011_create_questions_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            $table->integer('question_number');
            $table->text('question');
            $table->text('question_arabic')->nullable();
            $table->enum('type', ['mcq', 'true_false', 'short_answer', 'essay', 'oral', 'upload']);
            $table->integer('marks')->default(1);
            $table->json('options')->nullable(); // For MCQ: {"A":"Option1","B":"Option2"}
            $table->text('answer')->nullable(); // Correct answer for auto-grading
            $table->text('hint')->nullable();
            $table->text('explanation')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
};