<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'body'  => '<p>' . $faker->text . '</p>'
    ];
});
