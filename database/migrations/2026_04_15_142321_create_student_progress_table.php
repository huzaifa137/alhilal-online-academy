// database/migrations/2024_01_01_000014_create_student_progress_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('student_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['not_started', 'in_progress', 'completed', 'passed', 'failed'])
                  ->default('not_started');
            $table->integer('score')->nullable();
            $table->integer('time_spent_seconds')->default(0);
            $table->integer('last_position_seconds')->default(0)->comment('For video/audio resume');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->unique(['student_id', 'lesson_id']);
            $table->index(['student_id', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_progress');
    }
};