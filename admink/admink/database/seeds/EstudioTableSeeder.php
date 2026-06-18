<?php

use Illuminate\Database\Seeder;

class EstudioTableSeeder extends Seeder
{
    public function run()
    {
        $users = \App\User::all();                                     

        foreach ($users as $u) {
            $u->estudio()->save(factory(\App\Estudio::class)->make()); 
            $u->estudio()->save(factory(\App\Estudio::class)->make()); 
        }
    }
}

// Exemplo usando o helper each()
// factory(\App\Estudio::class)->each(function ($estudio){
//     $estudio->estacao_trabalho()->save(factory(\App\EstacaoTrabalho::class)->make());
// });