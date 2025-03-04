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
        // Competitions table
        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('main_image')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('video')->nullable();
            $table->timestamp('competition_time')->nullable();
            $table->string('competition_type');
            $table->integer('category_id');
            $table->integer('points')->default(0);
            $table->timestamps();
        });

        // Competition translations table
        Schema::create('competition_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competition_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();

            $table->string('title');
            $table->text('short_description');
            $table->text('description');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_tags')->nullable();
            $table->string('alt_image')->nullable();
            $table->unique(['competition_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competition_translations');
        Schema::dropIfExists('competitions');
    }
};
