<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * A "free quiz" can be taken by any student enrolled in the class without
     * paying for the class or the lesson first (handy for testing and for
     * sample / trial quizzes). Defaults to false, so nothing changes for
     * existing quizzes.
     */
    public function up(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->boolean('is_free')->default(false)->after('questions_per_student');
        });
    }

    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->dropColumn('is_free');
        });
    }
};
