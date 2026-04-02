<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('level_id')->nullable();
            $table->string('subject');
            $table->integer('duration')->default(30); // in minutes
            $table->integer('total_questions')->default(0);
            $table->integer('passing_score')->default(50); // percentage
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('level_id')->references('id')->on('levels')->onDelete('set null');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('set null');
            
            // Indexes
            $table->index(['level_id', 'subject']);
            $table->index('is_active');
        });
    }

    public function down()
    {
        Schema::dropIfExists('exams');
    }
}