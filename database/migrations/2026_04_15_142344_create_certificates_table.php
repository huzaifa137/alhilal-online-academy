// database/migrations/2024_01_01_000015_create_certificates_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('class_id')->constrained()->onDelete('cascade');
            $table->foreignId('section_id')->nullable()->constrained()->onDelete('set null');
            $table->string('certificate_no')->unique();
            $table->enum('type', ['section_completion', 'class_completion', 'course_completion', 'exam_pass', 'achievement']);
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('issued_date');
            $table->string('grade')->nullable();
            $table->decimal('percentage', 5, 2)->nullable();
            $table->string('pdf_path');
            $table->string('template_used')->nullable();
            $table->enum('status', ['draft', 'issued', 'revoked'])->default('draft');
            $table->timestamp('issued_at')->nullable();
            $table->text('revoked_reason')->nullable();
            $table->timestamps();
            
            $table->index(['student_id', 'type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('certificates');
    }
};