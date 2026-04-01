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
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('level_id')->nullable();
            $table->string('certificate_number')->unique();
            $table->string('honors')->nullable();
            $table->decimal('score', 5, 2)->nullable();
            $table->timestamp('issued_date')->nullable();
            $table->string('file_url')->nullable();
            $table->boolean('is_downloaded')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('set null');
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('set null');
            
            // Indexes
            $table->index(['user_id', 'course_id']);
            $table->index('certificate_number');
            $table->index('issued_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('certificates');
    }
}