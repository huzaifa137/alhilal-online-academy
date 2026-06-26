<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('certificates', function (Blueprint $table) {
            // Short public-facing code printed on the certificate for verification
            // (separate from the internal certificate_no which can be more formal/sequential).
            $table->string('verification_code', 20)->nullable()->unique()->after('certificate_no');
        });
    }

    public function down()
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn('verification_code');
        });
    }
};