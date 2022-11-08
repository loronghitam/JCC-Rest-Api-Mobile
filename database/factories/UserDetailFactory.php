<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\UserDetail;
use Faker\Generator as Faker;

$factory->define(UserDetail::class, function (Faker $faker) {
    return [
        'user_id' => User::factory(),
    ];
});
