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
        Schema::create('generate_links', function (Blueprint $table) {
            $table->id();
            $table->text('gl_links');
            $table->text('gl_device_ip')->nullable();
            $table->integer('gl_status')->default(0);
            $table->integer('gl_active_status')->default(0);
            $table->text('gl_tracker_counter')->default(0);
            $table->text('gl_latitude')->nullable();;
            $table->text('gl_longitude')->nullable();
            $table->text('gl_added_by')->nullable();
            $table->text('gl_date_added')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generate_links');
    }
};
