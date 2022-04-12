<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Article::class->count('90')->create();
//        return factory(\App\Article::class,100)->create();

        Article::factory()->count(90)->create();

    }
}
