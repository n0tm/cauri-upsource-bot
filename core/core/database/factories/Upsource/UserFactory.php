<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Model\Upsource\User::class, function (Faker $faker) {
    return [
        'id'         => Str::random(),
        'name'       => $faker->name,
        'project_id' => Str::random(),
        'user_id'    => factory(Model\User::class)->create()->id,
    ];
});
