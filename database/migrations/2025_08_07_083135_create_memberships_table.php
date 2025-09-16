<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipsTable extends Migration
{
    public function up()
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->string('ngo_name')->nullable();          // Make nullable
            $table->string('director_name')->nullable();     // Make nullable
            $table->string('director_phone')->nullable();    // Make nullable
            $table->string('director_email')->nullable();    // Make nullable
            $table->string('alt_name')->nullable();
            $table->string('alt_phone')->nullable();
            $table->string('alt_email')->nullable();
            $table->boolean('membership_status'); // true for yes, false for no
            $table->boolean('more_info')->nullable();  // Make nullable, if not always required
            $table->unsignedBigInteger('user_id'); // Add user_id to link membership to user
            $table->enum('status', ['pending', 'completed'])->default('pending');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('membership_networks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_id')->constrained()->onDelete('cascade');
            $table->string('network_name');
            $table->timestamps();
        });

        Schema::create('membership_focal_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_id')->constrained()->onDelete('cascade');
            $table->string('network_name');
            $table->string('name');
            $table->string('sex');
            $table->string('position');
            $table->string('email');
            $table->string('phone');
            $table->timestamps();
        });

        Schema::create('membership_applications', function (Blueprint $table) {
            $table->id();

            $table->string('mailing_address')->nullable();
            $table->string('physical_address')->nullable();
            $table->string('facebook')->nullable();
            $table->string('website')->nullable();

            // Preferred communication channels stored as JSON
            $table->json('comm_channels')->nullable();

            // Phone numbers stored as JSON (keyed by channel)
            $table->json('comm_phones')->nullable();

            // File paths for uploads (store filenames or URLs)
            $table->string('letter')->nullable();
            $table->string('constitution')->nullable();
            $table->string('activities')->nullable();
            $table->string('funding')->nullable();
            $table->string('registration')->nullable();
            $table->string('strategic_plan')->nullable();
            $table->string('fundraising_strategy')->nullable();
            $table->string('audit_report')->nullable();
            $table->string('signature')->nullable();

            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->text('goal')->nullable();
            $table->text('objectives')->nullable();

            $table->string('director_name')->nullable();
            $table->string('title')->nullable();
            $table->date('date')->nullable();

            $table->foreignId('membership_id')->nullable()->constrained('memberships')->onDelete('cascade');


            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('membership_applications');
        Schema::dropIfExists('membership_focal_points');
        Schema::dropIfExists('membership_networks');
        Schema::dropIfExists('memberships');
    }
}
