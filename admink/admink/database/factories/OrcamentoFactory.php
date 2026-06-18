<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Orcamento;

$fakerPT_BR = Faker\Factory::create('pt_BR');

$factory->define(Orcamento::class, function (Faker\Generator $faker) use ($fakerPT_BR) {
    return [
        'tatuagem_nome'        => $fakerPT_BR->randomElement(['Dragão', 'Cobra', 'Rosa', 'Leão', 'Relógio']),
        'tatuagem_local'       => $fakerPT_BR->randomElement(['Mão', 'Pescoço', 'Rosto', 'Perna', 'Braço']),
        'tatuagem_comprimento' => $fakerPT_BR->randomFloat(2, 2, 30),
        'tatuagem_largura'     => $fakerPT_BR->randomFloat(2, 2, 30),
        'tatuagem_descricao'   => $fakerPT_BR->paragraph(2),
        'tatuagem_referencias' => $fakerPT_BR->url(),
        'tatuagem_colorida'    => $fakerPT_BR->boolean(),
        'tatuagem_autoral'     => $fakerPT_BR->boolean(),
        'valor'                => $fakerPT_BR->randomFloat(2, 80, 1000),
        'tempo_estimado'       => $fakerPT_BR->time(),
        'canal_contato'        => $fakerPT_BR->randomElement(['WhatsApp', 'Instagram', 'Facebook', 'Ligação']),
        'observacao'           => $fakerPT_BR->text(),
        'aceite_termo'         => $fakerPT_BR->boolean(),
    ];
});