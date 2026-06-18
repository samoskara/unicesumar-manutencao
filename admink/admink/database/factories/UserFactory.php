<?php

/** @var Factory $factory */

use App\User;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$fakerPT_BR = Faker\Factory::create('pt_BR');

$factory->define(User::class, function (Faker\Generator $faker) use ($fakerPT_BR) {
    return [
        'name'              => $fakerPT_BR->name,
        'email'             => $fakerPT_BR->unique()->safeEmail,
        'email_verified_at' => now(),
        'password'          => Hash::make('teste@123'),
        'remember_token'    => Str::random(10),
    ];
    // return [
    //     'name'              => 'Bruno Prestes',
    //     'email'             => 'bruno@admink.com',
    //     'email_verified_at' => now(),
    //     'password'          => Hash::make('senha123'),
    //     'remember_token'    => Str::random(10),
    // ];
    
    // return [
    //     'name'              => $fakerPT_BR->firstName,
    //     'email'             => $fakerPT_BR->unique()->safeEmail,
    //     'email_verified_at' => now(),
    //     'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
    //     'remember_token'    => Str::random(10),
    // ];
});
