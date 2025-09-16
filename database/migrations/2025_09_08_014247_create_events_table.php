<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time')->nullable();  // Start time
            $table->time('end_time')->nullable();    // End time
            $table->string('location')->nullable();
            $table->string('organizer')->nullable();
            $table->string('organizer_email')->nullable();
            $table->timestamps();
        });

        Schema::create('event_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('file_path');
            $table->string('file_type');
            $table->timestamps();
        });

        Schema::create('event_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_images');
        Schema::dropIfExists('event_files');
        Schema::dropIfExists('events');
    }
};
