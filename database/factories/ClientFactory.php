<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use App\ClientEmail;
use App\ClientPhone;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'surname' => $faker->lastName
    ];
});

$factory->afterCreating(Client::class, function ($client) {
    for ($i = 0; $i < rand(0, 10); $i++) { 
        $client->phones()->save(factory(ClientPhone::class)->make([
            'client_id' => $client->id
        ]));
    }

    for ($i = 0; $i < rand(0, 10); $i++) { 
        $client->emails()->save(factory(ClientEmail::class)->make([
            'client_id' => $client->id
        ]));
    }
});
