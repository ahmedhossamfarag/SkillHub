<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->integer('budget');
            $table->dateTime('deadline');
            $table->foreignId('category_id')->constrained();
            $table->foreignId('client_id')->constrained('users');
            $table->timestamps();
        });

        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('location');
            $table->string('experience');
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });

        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('profile_id')->constrained();
            $table->timestamps();
        });

        Schema::create('profile_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained();
            $table->foreignId('tag_id')->constrained();
            $table->timestamps();
        });

        Schema::create('project_freelancers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained();
            $table->foreignId('freelancer_id')->constrained('users');
            $table->timestamps();
        });

        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->integer('paid_amount');
            $table->string('estimated_time');
            $table->foreignId('freelancer_id')->constrained('users');
            $table->foreignId('project_id')->constrained();
            $table->timestamps();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('rating')->default(0)->max(10)->min(0);
            $table->string('comment');
            $table->string('review_type'); // freelancer or client
            $table->foreignId('freelancer_id')->constrained('users');
            $table->foreignId('client_id')->constrained('users');
            $table->foreignId('project_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('proposals');
        Schema::dropIfExists('project_freelancers');
        Schema::dropIfExists('profile_tags');
        Schema::dropIfExists('skills');
        Schema::dropIfExists('profiles');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('catogories');
    }
};
