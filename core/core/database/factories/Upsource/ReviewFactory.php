<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Illuminate\Support\Str;

$factory->define(Model\Upsource\Review::class, function () {
    return [
        'id'                       => Str::random(),
        'creator_upsource_user_id' => factory(Model\User::class)->create()->id,
        'branch'                   => Str::random(),
    ];
});
