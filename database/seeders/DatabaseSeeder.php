<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Skill;
use App\Models\Profile;
use App\Models\Project;
use Meilisearch\Client;
use App\Models\Category;
use App\Models\Proposal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $category = Category::create([
            'name' => 'Category 1',
            'description' => 'Description 1',
        ]);

        Tag::create([
            'name' => 'Tag 1',
            'description' => 'Description 1',
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $client = User::create([
            'name' => 'Client',
            'email' => 'client@example.com',
            'password' => Hash::make('password'),
            'role' => 'client',
        ]);

        $freelancer = User::create([
            'name' => 'Freelancer',
            'email' => 'freelancer@example.com',
            'password' => Hash::make('password'),
            'role' => 'freelancer',
        ]);

        $profile = Profile::create([
            'user_id' => $freelancer->id,
            'experience' => '1 year',
            'location' => 'New York',
            'description' => 'I am a freelancer',
        ]);

        Skill::create([
            'profile_id' => $profile->id,
            'name' => 'Skill 1',
        ]);

        $project = Project::create([
            'client_id' => $client->id,
            'title' => 'Project 1',
            'description' => 'This is a project 1',
            'category_id' => $category->id,
            'budget' => 1000,
            'deadline' => now()->addDays(7),
        ]);

        DB::table('project_freelancers')->insert([
            [
                'project_id' => $project->id,
                'freelancer_id' => $freelancer->id,
            ],
        ]);

        Proposal::create([
            'project_id' => $project->id,
            'freelancer_id' => $freelancer->id,
            'paid_amount' => 500,
            'estimated_time' => '1 week',
        ]);

        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));
        $index = $client->index('projects_index');

        // Make 'category_id' filterable
        $index->updateFilterableAttributes(['category_id']);
    }
}
