// database/migrations/2024_01_01_000005_create_subjects_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name'); // Fiqh, Aqeedah, Tawheed, Hifdh, Tajweed
            $table->string('name_arabic')->nullable();
            $table->string('code', 20)->unique();
            $table->enum('category', ['islamic', 'language', 'secular', 'other'])->default('islamic');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('color', 20)->nullable();
            $table->integer('sort_order')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subjects');
    }
};