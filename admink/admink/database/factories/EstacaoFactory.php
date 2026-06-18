<?php

/** @var Factory $factory */

use App\Estacao;
use Illuminate\Database\Eloquent\Factory;

$fakerPT_BR = Faker\Factory::create('pt_BR');

$factory->define(Estacao::class, function (Faker\Generator $faker) use ($fakerPT_BR) {
    return [
        'identificacao' => $fakerPT_BR->state,
        'ativa'         => 1,
    ];
});