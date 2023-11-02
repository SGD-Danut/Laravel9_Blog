<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Category;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::truncate();
        Post::factory(70)->create();
        
        $categories = Category::all();
        Post::all()->each(function ($post) use($categories) {
            $post->categories()->sync($categories->random(rand(1, 3))->pluck('id')->toArray());
        });
    }
}
