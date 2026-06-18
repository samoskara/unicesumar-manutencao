<?php

/** @var Factory $factory */

use App\Estudio;
use Illuminate\Database\Eloquent\Factory;

$fakerPT_BR = Faker\Factory::create('pt_BR');

$factory->define(Estudio::class, function (Faker\Generator $faker) use ($fakerPT_BR) {
    return [
        'nome'     => $fakerPT_BR->company,
        'endereco' => $fakerPT_BR->address,
    ];
});