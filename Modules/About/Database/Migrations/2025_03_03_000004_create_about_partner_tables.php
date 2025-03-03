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
    }
};
