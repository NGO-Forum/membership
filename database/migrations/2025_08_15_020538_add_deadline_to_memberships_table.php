<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('memberships', function (Blueprint $table) {
            $table->date('deadline')->nullable()->after('user_id');
        });
    }

    public function down()
    {
        Schema::table('memberships', function (Blueprint $table) {
            $table->dropColumn('deadline');
        });
    }

};
