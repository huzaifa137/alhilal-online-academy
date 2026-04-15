// database/migrations/2024_01_01_000010_create_exams_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('lesson_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('topic_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->enum('exam_type', ['quiz', 'assignment', 'midterm', 'final', 'oral', 'practical']);
            $table->integer('total_marks')->default(100);
            $table->integer('pass_mark')->default(50);
            $table->integer('duration_minutes')->nullable();
            $table->timestamp('available_from')->nullable();
            $table->timestamp('available_to')->nullable();
            $table->text('instructions')->nullable();
            $table->boolean('allow_late_submission')->default(false);
            $table->boolean('shuffle_questions')->default(false);
            $table->enum('status', ['draft', 'published', 'closed', 'archived'])->default('draft');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exams');
    }
};