<?php

use Faker\Generator as Faker;

$factory->define(App\Blog::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(5),
        'image' => 'http://placehold.it/700x450',
        // 'image' => url('storage/images/' . $faker->image(public_path('storage/images'), 700, 450, null, false)),
        'excerpt' => $faker->text,
        'description' => $faker->paragraph,
        'views' => 0,
        'is_active' => rand(0, 1),
        // 'user_id' => 1,
    ];
});
