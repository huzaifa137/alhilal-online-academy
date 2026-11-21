<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Optional "questions per student" limit.
     *
     * NULL  => feature off, every student answers every question (legacy behaviour).
     * N > 0 => each attempt gets N questions drawn at random from the quiz's pool.
     */
    public function up(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->unsignedInteger('questions_per_student')
                ->nullable()
                ->after('shuffle_questions');
        });
    }

    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->dropColumn('questions_per_student');
        });
    }
};
