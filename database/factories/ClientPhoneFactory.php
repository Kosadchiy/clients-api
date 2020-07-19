<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use App\ClientPhone;
use Faker\Generator as Faker;

$factory->define(ClientPhone::class, function (Faker $faker) {
    return [
        'phone' => $faker->phoneNumber,
        'client_id' => function () {
            return factory(Client::class)->create()->id;
        },
    ];
});
