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
        \App\Models\Article::factory(30)->create();
        \App\Models\Comment::factory(60)->create();

        $list = ["General", "Mobile", "News", "Tech", "Language"];
        foreach($list as $name) {
            \App\Models\Category::create([
                "name" => $name
            ]);
        }

        \App\Models\User::factory()->create([
            "name" => "Tom",
            "email" => "tom@gmail.com",
        ]);

        \App\Models\User::factory()->create([
            "name" => "Jerry",
            "email" => "jerry@gmail.com",
        ]);
    }
}
