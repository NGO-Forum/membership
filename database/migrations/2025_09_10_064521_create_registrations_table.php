<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('gender')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('organization')->nullable();
            $table->string('position')->nullable();
            $table->foreignId('ngo_id')->nullable()->constrained('ngos')->onDelete('set null');
            $table->foreignId('new_membership_id')->nullable()->constrained('new_memberships')->onDelete('set null');
            $table->foreignId('membership_id')->nullable()->constrained('memberships')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('registrations');
    }
};
