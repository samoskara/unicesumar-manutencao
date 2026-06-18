<?php

/** @var Factory $factory */

use App\Cliente;
use Illuminate\Database\Eloquent\Factory;

$fakerPT_BR = Faker\Factory::create('pt_BR');

$factory->define(Cliente::class, function (Faker\Generator $faker) use ($fakerPT_BR) {
    return [
        'nome'            => $fakerPT_BR->firstName,
        'email'           => $fakerPT_BR->unique()->safeEmail,
        'apelido'         => $fakerPT_BR->lastName,
        'telefone'        => $fakerPT_BR->cellphoneNumber,
        'data_nascimento' => $fakerPT_BR->date('Y_m_d', $max = '2002-01-01'),
        'observacao'      => $fakerPT_BR->sentence(10),
    ];
});