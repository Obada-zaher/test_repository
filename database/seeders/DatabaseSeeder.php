<?php

namespace Database\Seeders;

use App\Models\Like;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CategorySeeder::class);
        Article::factory(30)->create()->each(function ($article) {
            Comment::factory(random_int(1, 5))->create([
                'article_id' => $article->id,
            ]);
            Like::factory(random_int(1, 5))->create([
                'article_id' => $article->id,
            ]);
        });
    }
}
