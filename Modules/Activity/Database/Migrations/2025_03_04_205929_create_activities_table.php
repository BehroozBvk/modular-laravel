<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         // Activities table
         Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('main_image_path');
            $table->string('cover_image_path');
            $table->string('video_path')->nullable();
            $table->timestamp('activity_time')->nullable();
            $table->string('alt_image_path');
            $table->integer('points')->default(0);
            $table->timestamps();
        });

        // Activities translations table
        Schema::create('activity_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('title');
            $table->text('short_description');
            $table->string('category');
            $table->text('description');
            $table->string('activity_type');
            $table->string('meta_title');
            $table->text('meta_description');
            $table->string('meta_tags');

            $table->unique(['activity_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
