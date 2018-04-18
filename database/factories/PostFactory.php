<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'slug'  => str_slug($faker->word),
        'body'  => '<p>' . $faker->text . '</p>',
        'image_file' => $faker->file(storage_path('/samples'), public_path('img'), false),
        'image_alt'  => $faker->word
    ];
});
