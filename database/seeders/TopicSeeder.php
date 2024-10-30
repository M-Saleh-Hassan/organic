<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(Topic::exists()) return;
        // Create 10 topics, each with 10 questions
        Topic::factory()
            ->count(10)
            ->hasQuestions(10)  // This will create 10 related questions for each topic
            ->create();
    }
}
