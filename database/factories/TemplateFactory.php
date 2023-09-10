<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model\Template::class, function (Faker $faker) {
    return [
        'category_id' => 1,
        'title'=> $this->faker->name(),
        'body'=> $this->faker->sentence(),
    ];
});
