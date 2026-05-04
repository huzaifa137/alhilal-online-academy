// database/migrations/2024_01_01_000008_create_lessons_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained()->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->string('title'); // Wudhu, Ghusl, Tayammum
            $table->string('title_arabic')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->enum('lesson_type', ['video', 'audio', 'pdf', 'live', 'text', 'mixed'])->default('mixed');
            $table->string('video_url')->nullable();
            $table->string('audio_url')->nullable();
            $table->string('pdf_file')->nullable();
            $table->integer('duration')->nullable()->comment('in minutes');
            $table->integer('lesson_order')->default(0);
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->string('lesson_amount')->nullable()->after('published_at');
            $table->enum('lesson_payment_status', ['Not Paid', 'Paid'])
                ->default('Not Paid')
                ->after('lesson_amount');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lessons');
    }
};