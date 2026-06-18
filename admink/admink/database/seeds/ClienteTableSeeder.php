<?php

use App\Cliente;

use Illuminate\Database\Seeder;

class ClienteTableSeeder extends Seeder
{
    public function run()
    {
        $estudios = \App\Estudio::all();                          // Busca todos os estudios e salva em $estudios

        foreach ($estudios as $estudio) 
        {                                                         // Pra cada estudio salva 10 clientes
            $clientes = factory(\App\Cliente::class, 6)->make(); // Cria 10 cliente e salva em $clientes

            foreach ($clientes as $cliente) 
            {
                $estudio->cliente()->save($cliente);              // Salva os 10 clientes no estudio atual
            }
        }
    }
}
