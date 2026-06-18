<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Artista;

$fakerPT_BR = Faker\Factory::create('pt_BR');

$factory->define(Artista::class, function (Faker\Generator $faker) use ($fakerPT_BR) {
    return [
        'nome'            => $fakerPT_BR->firstName,
        'apelido'         => $fakerPT_BR->lastName,
        'email'           => $fakerPT_BR->unique()->safeEmail,
        'telefone'        => $fakerPT_BR->cellphoneNumber,
        'data_nascimento' => $fakerPT_BR->date('Y_m_d', $max = '2002-01-01'),
    ];
});