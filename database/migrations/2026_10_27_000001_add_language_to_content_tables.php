<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Teaching language of learning content.
 *
 * Every lesson, study material and quiz now belongs to exactly one language
 * (en / ar / sw / lg). Students only see the content that matches the
 * language they have selected, so each language is its own learning track.
 *
 * Existing rows are back-filled with the site's default language (English
 * unless DEFAULT_LOCALE says otherwise). Re-label anything that was really
 * taught in another language with:  php artisan content:set-language
 */
return new class extends Migration
{
    /** table => column the new column is placed after */
    private array $tables = [
        'lessons'          => 'teacher_id',
        'subject_materials' => 'subject_id',
        'exams'            => 'subject_id',
    ];

    public function up(): void
    {
        $default = config('languages.default', 'en');

        foreach ($this->tables as $table => $after) {
            if (!Schema::hasTable($table) || Schema::hasColumn($table, 'language')) {
                continue;
            }

            Schema::table($table, function (Blueprint $t) use ($after, $default) {
                $t->string('language', 5)->default($default)->after($after);
                $t->index('language');
            });
        }
    }

    public function down(): void
    {
        foreach (array_keys($this->tables) as $table) {
            if (!Schema::hasTable($table) || !Schema::hasColumn($table, 'language')) {
                continue;
            }

            Schema::table($table, function (Blueprint $t) use ($table) {
                $t->dropIndex($table . '_language_index');
                $t->dropColumn('language');
            });
        }
    }
};
