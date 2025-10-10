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
        Schema::create('membership_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('letter')->nullable();                // Letter explaining why your organization wishes to join NGOF
            $table->string('mission_vision')->nullable();       // Organization's Mission and/or Vision Statement
            $table->string('constitution')->nullable();         // Organization's Constitution and/or By-Laws
            $table->string('activities')->nullable();           // List or summary of current activities in Cambodia
            $table->string('funding')->nullable();              // Funding sources and Board Members
            $table->string('authorization')->nullable();        // Official authorization/Registration with MoI
            $table->string('strategic_plan')->nullable();       // Organization strategic plan
            $table->string('fundraising_strategy')->nullable(); // Fundraising strategy (optional)
            $table->string('audit_report')->nullable();         // Global audit report / Financial Report
            $table->longText('signature')->nullable(); // base64 string or file path
            $table->foreignId('new_membership_id')->constrained('new_memberships')->onDelete('cascade');
            $table->timestamps();
        });

        // membership_networks table
        Schema::create('networks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_upload_id')->constrained()->onDelete('cascade');
            $table->string('network_name');
            $table->timestamps();
        });

        // membership_focal_points table
        Schema::create('focal_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_upload_id')->constrained()->onDelete('cascade');
            $table->string('network_name');
            $table->string('name');
            $table->string('sex');
            $table->string('position');
            $table->string('email');
            $table->string('phone');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('focal_points');
        Schema::dropIfExists('networks');
        Schema::dropIfExists('membership_uploads');
    }
};
