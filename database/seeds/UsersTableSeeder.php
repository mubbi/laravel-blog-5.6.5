<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Users, Blogs, and Categories
        factory(App\User::class, 10)->create()->each(function ($u) {
            $u->blog()->save(factory(App\Blog::class)->make());
            $u->category()->save(factory(App\Category::class)->make());
        });


        // Get all the Categories attaching up to 3 random category to each blog
        $categories = App\Category::all();

        // Populate the pivot table
        App\Blog::all()->each(function ($blog) use ($categories) {
            $blog->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
