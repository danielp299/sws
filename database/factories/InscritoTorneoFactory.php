<?php

use Faker\Generator as Faker;


$factory->defineAs(App\InscritosTorneo::class, 'rtyu', function (Faker $faker) {
    return [
        'uid_torneo' => 'rtyu',
        'uid_user' => $faker->firstName,
        'uid_avatar' => $faker->lastName,
        'exp' => $faker->numberBetween(10,100),
    ];
});
