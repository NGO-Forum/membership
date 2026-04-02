<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('village')->nullable()->after('org_location');
            $table->string('commune')->nullable()->after('village');
            $table->string('district')->nullable()->after('commune');
            $table->enum('residence_type', ['phnom_penh', 'community'])->nullable()->after('district');
            $table->enum('dsa_covered_by', ['own', 'ngof'])->nullable()->after('residence_type');
        });
    }

    public function down()
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn([
                'village',
                'commune',
                'district',
                'residence_type',
                'dsa_covered_by',
            ]);
        });
    }
};
