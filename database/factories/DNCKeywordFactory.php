<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model\DNC::class, function (Faker $faker) {
    return [
        'keyword' => $faker->word,
    ];
});
