<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('membership_uploads', function (Blueprint $table) {
            $table->string('logo')->nullable(); // store file path for logo
        });
    }

    public function down(): void
    {
        Schema::table('membership_uploads', function (Blueprint $table) {
            $table->dropColumn('logo');
        });
    }
};
