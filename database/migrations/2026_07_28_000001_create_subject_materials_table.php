<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Study materials (currently PDFs) attached to a SUBJECT within a CLASS.
 *
 * These are distinct from `lesson_resources` — a lesson resource belongs to
 * one specific lesson, while a subject material belongs to the class+subject
 * as a whole (e.g. a revision pack, syllabus, or reference PDF for "Fiqh"
 * in class "P4-A"), and is shown to every student enrolled in that class,
 * gated the same way lessons are: the student must have an active
 * enrollment in the class with `payment_status = paid`.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subject_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('teacher_id')->nullable()->constrained('users')->onDelete('set null');

            $table->string('title');
            $table->text('description')->nullable();

            $table->string('type', 20)->default('pdf');
            $table->string('file_path');
            $table->bigInteger('file_size')->nullable();

            $table->integer('sort_order')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();

            $table->index(['class_id', 'subject_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subject_materials');
    }
};
