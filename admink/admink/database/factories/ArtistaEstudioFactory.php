<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ArtistaEstudio;
use App\Artista;
use App\Estudio;
use Illuminate\Database\Eloquent\Factory;
$fakerPT_BR = Faker\Factory::create('pt_BR');

$factory->define(ArtistaEstudio::class, function (Faker\Generator $faker) use ($fakerPT_BR){
    return [
    ];
});
