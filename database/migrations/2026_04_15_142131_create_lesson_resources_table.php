// database/migrations/2024_01_01_000009_create_lesson_resources_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lesson_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['video', 'audio', 'pdf', 'document', 'image', 'external_link']);
            $table->string('title')->nullable();
            $table->string('file_path')->nullable();
            $table->string('external_url')->nullable();
            $table->bigInteger('file_size')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_required')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lesson_resources');
    }
};