<?php

use Illuminate\Database\Seeder;

class EstacaoTableSeeder extends Seeder
{
    public function run()
    {
        $estudios = \App\Estudio::all();                         // Busca todos os estudios e salva em $estudios

        foreach ($estudios as $estudio) 
        {                                                        // Pra cada estudio salva 2 estacoes
            $estacoes = factory(\App\Estacao::class, 4)->make(); // Cria 2 estacoes e salva em $estacoes

            foreach ($estacoes as $estacao) 
            { 
                $estudio->estacao()->save($estacao);             // Salva as duas estacoes no estudio atual
            }
        }
    }
}
