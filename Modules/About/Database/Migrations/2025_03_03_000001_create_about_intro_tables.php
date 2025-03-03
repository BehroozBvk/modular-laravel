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
        // About Intro Table
        Schema::create('about_intros', function (Blueprint $table) {
            $table->id();
            $table->string('image_path');
            $table->string('background_path');
            $table->timestamps();
        });

        // About Intro Translations Table
        Schema::create('about_intro_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_intro_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title');
            $table->text('description');
            $table->unique(['about_intro_id', 'locale']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_intro_translations');
        Schema::dropIfExists('about_intros');
    }
};
