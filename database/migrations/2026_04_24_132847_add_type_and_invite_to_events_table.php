<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->enum('event_type', ['ngof', 'invite'])->default('ngof')->after('program');
            $table->string('organization_invite')->nullable()->after('event_type');
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['event_type', 'organization_invite']);
        });
    }
};
