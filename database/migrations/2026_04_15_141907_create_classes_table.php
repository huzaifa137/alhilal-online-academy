// database/migrations/2024_01_01_000004_create_classes_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('level_id')->constrained()->onDelete('cascade');
            $table->foreignId('academic_year_id')->constrained()->onDelete('cascade');
            $table->string('name'); // P1-A, P1-B, P1-Girls, P1-Boys
            $table->string('code', 30)->unique();
            $table->foreignId('class_teacher_id')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('capacity')->default(900);
            $table->string('room_number')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive', 'archived'])->default('active');
            $table->timestamps();
            
            $table->unique(['academic_year_id', 'name']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('classes');
    }
};