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
            $table->unique('name');
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->timestamps();
            $table->unique('name');
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->integer('budget');
            $table->dateTime('deadline');
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['title', 'client_id']);
        });

        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('location');
            $table->string('experience');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->unique(['name', 'profile_id']);
        });

        Schema::create('profile_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->unique(['profile_id', 'tag_id']);
        });

        Schema::create('project_freelancers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('freelancer_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['project_id', 'freelancer_id']);
        });

        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->integer('paid_amount');
            $table->string('estimated_time');
            $table->string('status')->default('pending');
            $table->foreignId('freelancer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->unique(['freelancer_id', 'project_id']);
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('rating')->default(0)->max(10)->min(0);
            $table->string('comment');
            $table->string('review_type'); // freelancer or client
            $table->foreignId('freelancer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->unique(['freelancer_id', 'client_id', 'project_id', 'review_type']);
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
        Schema::dropIfExists('categories');
    }
};
