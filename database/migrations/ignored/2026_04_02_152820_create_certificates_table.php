<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificatesTable extends Migration
{
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('level_id')->nullable()->constrained('levels')->onDelete('set null');
            $table->string('certificate_number')->unique();
            $table->string('honors')->nullable();
            $table->decimal('score', 5, 2)->nullable();
            $table->timestamp('issued_date')->nullable();
            $table->string('file_url')->nullable();
            $table->boolean('is_downloaded')->default(false);
            $table->timestamps();
            
            // Additional indexes for better performance
            $table->index(['user_id', 'course_id']);
            $table->index('certificate_number');
            $table->index('issued_date');
            $table->index('level_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('certificates');
    }
}