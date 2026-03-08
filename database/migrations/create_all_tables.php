<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration untuk membuat semua tabel utama database.
 * Tabel-tabel yang dibuat: profiles, projects, contact_messages
 */
return new class extends Migration
{
    public function up(): void
    {
        // Tabel Profiles — menyimpan data profil pengguna
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('bio');
            $table->string('experience_years')->nullable();
            $table->string('education')->nullable();
            $table->string('location')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('github_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->json('learning_roadmap')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('website_url')->nullable();
            $table->string('resume_url')->nullable();
            $table->string('avatar')->nullable();
            $table->string('hero_image')->nullable();
            $table->json('interests')->nullable();
            $table->boolean('is_open_to_work')->default(false);
            $table->timestamps();
        });

        // Tabel Projects — menyimpan data proyek portofolio
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->json('tech_stack')->nullable();
            $table->string('demo_url')->nullable();
            $table->string('github_url')->nullable();
            $table->string('category')->nullable();
            $table->string('thumbnail')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->date('built_at')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });

        // Tabel Contact Messages — menyimpan pesan masuk dari form kontak
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('subject')->nullable();
            $table->text('message');
            $table->string('ip_address')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('profiles');
    }
};

