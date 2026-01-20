<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessment_reports', function (Blueprint $table) {
            $table->id();

            $table->foreignId('new_membership_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('ngo_type', [
                'Local Organization',
                'International Organization'
            ]);

            $table->date('established_date')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->text('address')->nullable();
            $table->json('key_actions')->nullable();

            $table->decimal('membership_fee', 8, 2)->nullable();

            // AI OUTPUT
            $table->json('summary_html')->nullable();
            $table->json('checklist_json')->nullable();
            $table->json('conclusion_html')->nullable();

            // APPROVAL FLOW
            $table->enum('status', [
                'draft',
                'manager_approved',
                'ed_approved',
                'board_approved'
            ])->default('draft');

            $table->timestamp('manager_approved_at')->nullable();
            $table->timestamp('ed_approved_at')->nullable();
            $table->timestamp('board_approved_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_reports');
    }
};
