<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->text('instructor_id');
            $table->string('title');
            $table->text('description');
            $table->string('language')->nullable();
            $table->enum('difficulty', ['beginner', 'intermediate', 'advanced']);
            $table->json('tags')->nullable();
            $table->string('thumbnail')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->integer('is_published')->default(0);
            $table->text('selling_price')->default(0);
            $table->text('old_price')->default(0);
            $table->integer('pricing_category')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
