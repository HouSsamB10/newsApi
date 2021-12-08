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
        \App\Models\User::factory(50)->create();
       \App\Models\Category::factory(15)->create();
       \App\Models\Post::factory(200)->create();
      \App\Models\Comment::factory(1500)->create();
    }
}
