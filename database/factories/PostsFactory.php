<?php

use Faker\Generator as Faker;

$factory->define(App\Posts::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(3),
        'subtitle' => $faker->sentence(5),
        'content' => $faker->text(1500),
        'user_id' => App\User::all()->random(1)->first()->id,
    ];
});
