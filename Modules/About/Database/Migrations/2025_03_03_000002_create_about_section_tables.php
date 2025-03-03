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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_section_translations');
        Schema::dropIfExists('about_sections');
    }
};
