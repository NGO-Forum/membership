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

            // Relations
            $table->foreignId('event_id')->constrained()->onDelete('cascade');

            // Personal info
            $table->string('name');
            $table->string('gender')->nullable();
            $table->unsignedTinyInteger('age')->nullable();
            $table->string('vulnerable')->nullable();

            // Work info
            $table->string('position')->nullable();
            $table->string('organization')->nullable();
            $table->string('org_location')->nullable(); // Province / District

            // Contact
            $table->string('phone')->nullable();
            $table->string('email');

            // Signature (image path or base64)
            $table->string('signature')->nullable();
            $table->boolean('allow_photos')->default(false);

            // Optional membership relations
            $table->foreignId('ngo_id')->nullable()
                ->constrained('ngos')->nullOnDelete();

            $table->foreignId('new_membership_id')->nullable()
                ->constrained('new_memberships')->nullOnDelete();

            $table->foreignId('membership_id')->nullable()
                ->constrained('memberships')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('registrations');
    }
};
