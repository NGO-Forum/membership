<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ngos', function (Blueprint $table) {
            $table->id();
            $table->string('ngo_name');
            $table->string('abbreviation'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ngos');
    }
};
