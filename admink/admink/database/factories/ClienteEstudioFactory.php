<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ClienteEstudio;
use App\Cliente;
use App\Estudio;
use Illuminate\Database\Eloquent\Factory;
$fakerPT_BR = Faker\Factory::create('pt_BR');

$factory->define(ClienteEstudio::class, function (Faker\Generator $faker) use ($fakerPT_BR){
    return [
    ];
});

