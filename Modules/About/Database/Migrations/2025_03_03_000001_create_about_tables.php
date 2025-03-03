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

        // About Sections Table
        Schema::create('about_sections', function (Blueprint $table) {
            $table->id();
            $table->string('icon_path');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // About Section Translations Table
        Schema::create('about_section_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_section_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title');
            $table->text('description');
            $table->unique(['about_section_id', 'locale']);
            $table->timestamps();
        });

        // About Team Settings Table
        Schema::create('about_team_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('visible')->default(true);
            $table->timestamps();
        });

        // About Team Members Table
        Schema::create('about_team_members', function (Blueprint $table) {
            $table->id();
            $table->string('image_path');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // About Team Member Translations Table
        Schema::create('about_team_member_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_team_member_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name');
            $table->string('position');
            $table->unique(['about_team_member_id', 'locale']);
            $table->timestamps();
        });

        // About Partners Table
        Schema::create('about_partners', function (Blueprint $table) {
            $table->id();
            $table->string('icon_path');
            $table->string('link');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // About Partner Translations Table
        Schema::create('about_partner_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_partner_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['about_partner_id', 'locale']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_partner_translations');
        Schema::dropIfExists('about_partners');
        Schema::dropIfExists('about_team_member_translations');
        Schema::dropIfExists('about_team_members');
        Schema::dropIfExists('about_team_settings');
        Schema::dropIfExists('about_section_translations');
        Schema::dropIfExists('about_sections');
        Schema::dropIfExists('about_intro_translations');
        Schema::dropIfExists('about_intros');
    }
};
