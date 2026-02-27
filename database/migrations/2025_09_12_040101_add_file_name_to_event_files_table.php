<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('event_files', function (Blueprint $table) {
            $table->string('file_name')->after('file_path');
        });
    }

    public function down()
    {
        Schema::table('event_files', function (Blueprint $table) {
            $table->dropColumn('file_name');
        });
    }
};
