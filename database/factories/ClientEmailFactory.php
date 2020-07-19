<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use App\ClientEmail;
use Faker\Generator as Faker;

$factory->define(ClientEmail::class, function (Faker $faker) {
    return [
        'email' => $faker->email,
        'client_id' => function () {
            return factory(Client::class)->create()->id;
        },
    ];
});
