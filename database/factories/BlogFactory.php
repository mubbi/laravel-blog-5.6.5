<?php

use Faker\Generator as Faker;

$factory->define(App\Blog::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(5),
        'image' => $faker->image('public/storage/images', 700, 450, null, false),
        'excerpt' => $faker->text,
        'description' => $faker->paragraphs,
        'views' => 0
    ];
});
