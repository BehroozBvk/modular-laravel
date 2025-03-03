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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_team_member_translations');
        Schema::dropIfExists('about_team_members');
        Schema::dropIfExists('about_team_settings');
    }
};
