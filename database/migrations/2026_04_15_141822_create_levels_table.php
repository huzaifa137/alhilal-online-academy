// database/migrations/2024_01_01_000002_create_levels_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Primary 1, Primary 2, Idaad 1, Thanawi 1
            $table->string('code', 20)->unique(); // P1, P2, I1, T1
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            
            $table->unique(['section_id', 'name']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('levels');
    }
};