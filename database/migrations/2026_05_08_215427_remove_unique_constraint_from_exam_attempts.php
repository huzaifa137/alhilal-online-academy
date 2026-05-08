<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // First, drop the foreign key constraint (find the actual name)
        Schema::table('exam_attempts', function (Blueprint $table) {
            // Try to drop foreign key with common names
            try {
                $table->dropForeign(['exam_id']);
            } catch (\Exception $e) {
                // If that fails, try other common names
                try {
                    $table->dropForeign('exam_attempts_exam_id_foreign');
                } catch (\Exception $e) {
                    // Continue - foreign key might not exist or has different name
                }
            }
        });
        
        // Then modify the indexes
        Schema::table('exam_attempts', function (Blueprint $table) {
            // Check and drop the unique constraint with possible names
            try {
                $table->dropUnique('exam_attempts_exam_id_student_id_unique');
            } catch (\Exception $e) {
                try {
                    $table->dropUnique('exam_attempts_exam_id_student_id_unique');
                } catch (\Exception $e) {
                    // Try alternative name
                    try {
                        $table->dropUnique('exam_attempts_exam_id_student_id_unique');
                    } catch (\Exception $e) {
                        // Index might not exist
                    }
                }
            }
            
            // Drop any other unique index
            $table->dropUnique(['exam_id', 'student_id']);
        });
        
        // Add regular index
        Schema::table('exam_attempts', function (Blueprint $table) {
            $table->index(['exam_id', 'student_id'], 'idx_exam_attempts_exam_student');
        });
        
        // Re-add the foreign key constraint
        Schema::table('exam_attempts', function (Blueprint $table) {
            $table->foreign('exam_id')
                  ->references('id')
                  ->on('exams')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('exam_attempts', function (Blueprint $table) {
            $table->dropForeign(['exam_id']);
            $table->dropIndex('idx_exam_attempts_exam_student');
            $table->unique(['exam_id', 'student_id']);
            $table->foreign('exam_id')
                  ->references('id')
                  ->on('exams')
                  ->onDelete('cascade');
        });
    }
};