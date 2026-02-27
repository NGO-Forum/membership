<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('basic_organizational_informations', function (Blueprint $table) {
            $table->id();

            // 🔗 Relationship with new_memberships
            $table->foreignId('new_membership_id')
                ->constrained()
                ->cascadeOnDelete();

            // Organization Type
            $table->enum('ngo_type', [
                'Local Organization',
                'International Organization'
            ]);

            // Basic Details
            $table->date('established_date')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();

            // Multiple key actions stored as JSON
            $table->json('key_actions')->nullable();
            $table->json('key_program_focuses')->nullable();

            // Staff Information
            $table->integer('staff_total')->nullable();
            $table->integer('staff_female')->nullable();
            $table->integer('staff_pwd')->nullable();

            // Annual Budget
            $table->year('budget_year')->nullable();
            $table->decimal('annual_budget', 12, 2)->nullable();

            // Target Location
            $table->integer('province')->nullable();
            $table->integer('district')->nullable();
            $table->integer('commune')->nullable();
            $table->integer('village')->nullable();
            $table->string('file')->nullable();

            // Target Group (multiple selection)
            $table->json('target_groups')->nullable();

            $table->json('ministries_partners')->nullable();
            $table->json('development_partners')->nullable();
            $table->json('private_sector_partners')->nullable();


            // Financial Info
            $table->decimal('membership_fee', 8, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('basic_organizational_informations');
    }
};
