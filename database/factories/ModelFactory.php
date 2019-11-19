<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Motor\Backend\Models\User;

$factory->define(Motor\Backend\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => Str::random(10),
    ];
});


$factory->define(Partymeister\Core\Models\Callback::class, function (Faker\Generator $faker) {

    $actions = [
        'notification',
        'live',
        'live_with_notification'
    ];
    $destinations = [
        'orga',
        'nowplaying',
        'general',
        'competitions',
        'seminars',
        'deadlines',
        'events',
        'nightshuttle',
        'location',
        'ios',
        'android',
        'testing'
    ];

    return [
        'name'          => $faker->name,
        'action'        => $actions[ rand(0, count($actions) - 1) ],
        'destination'   => $destinations[ rand(0, count($destinations) - 1) ],
        'payload'       => '{}',
        'title'         => $faker->title,
        'body'          => $faker->paragraph(1),
        'link'          => $faker->url,
        'hash'          => Str::random(30),
        'is_timed'      => (bool) rand(0, 1),
        'has_fired'     => (bool) rand(0, 1),
        'fired_at'      => $faker->dateTime(),
        'embargo_until' => $faker->dateTime(),
        'created_at'    => Carbon::now(),
        'updated_at'    => Carbon::now(),
        'created_by'    => User::first(),
        'updated_by'    => User::first(),
        'deleted_by'    => null
    ];
});

