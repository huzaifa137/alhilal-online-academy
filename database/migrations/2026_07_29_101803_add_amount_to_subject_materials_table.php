<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add amount column for paid materials.
     */
    public function up(): void
    {
        Schema::table('subject_materials', function (Blueprint $table) {
            $table->decimal('amount', 10, 2)
                ->default(0)
                ->after('file_size');
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Schema::table('subject_materials', function (Blueprint $table) {
            $table->dropColumn('amount');
        });
    }
};