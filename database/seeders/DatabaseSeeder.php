<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\Category::factory(5)->create();
        // \App\Models\JobType::factory(5)->create();
        \App\Models\Job::factory(20)->create();
    }
}
