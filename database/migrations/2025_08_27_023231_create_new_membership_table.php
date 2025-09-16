<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_memberships', function (Blueprint $table) {
            $table->id();
            $table->string('org_name_en');
            $table->string('org_name_kh');
            $table->enum('membership_type', ['Full member', 'Associate member']);
            $table->string('director_name');
            $table->string('director_email');
            $table->string('director_phone');
            $table->string('alt_phone')->nullable();
            $table->string('website')->nullable();
            $table->string('social_media')->nullable();
            $table->string('representative_name');
            $table->string('representative_email');
            $table->string('representative_phone');
            $table->string('representative_position');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('new_membership');
    }
};
