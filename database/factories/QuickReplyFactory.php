<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model\QuickResponse::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'body' => $faker->sentence,
    ];
});
