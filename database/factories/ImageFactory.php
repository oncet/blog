<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Image::class, function (Faker $faker) {
    return [
        'file' => $faker->file(storage_path('samples'), public_path('img'), false)
    ];
});
