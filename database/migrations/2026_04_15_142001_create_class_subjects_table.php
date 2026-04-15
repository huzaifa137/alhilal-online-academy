// database/migrations/2024_01_01_000006_create_class_subjects_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('class_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('teacher_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('academic_year_id')->constrained()->onDelete('cascade');
            $table->integer('periods_per_week')->default(1);
            $table->boolean('is_compulsory')->default(true);
            $table->integer('passing_marks')->default(50);
            $table->integer('full_marks')->default(100);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            
            $table->unique(['class_id', 'subject_id', 'academic_year_id'], 'unique_class_subject_year');
        });
    }

    public function down()
    {
        Schema::dropIfExists('class_subjects');
    }
};