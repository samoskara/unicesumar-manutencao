<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Agendamento;

$fakerPT_BR = Faker\Factory::create('pt_BR');

$factory->define(Agendamento::class, function (Faker\Generator $faker) use ($fakerPT_BR) {
    return [
        'data_horario_inicio' => $fakerPT_BR->dateTimeBetween($startDate = '2023-01-29 09:00:00', $endDate = '2023-01-29 13:00:00', $timezone = 'America/Sao_Paulo'),
        'data_horario_fim'    => $fakerPT_BR->dateTimeBetween($startDate = '2023-01-29 13:00:00', $endDate = '2023-01-29 23:59:00', $timezone = 'America/Sao_Paulo'),
        'observacao'          => $fakerPT_BR->sentence(10),
    ];
});