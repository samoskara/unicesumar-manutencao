<?php

use Illuminate\Database\Seeder;

class AgendamentoTableSeeder extends Seeder
{
    public function run()
    {
        for ($i=0; $i < 10; $i++)
        {                                                                           // Laço pra criar vários agendamentos
            $agendamento = factory(\App\Agendamento::class)->make();
    
            $estudio = \App\Estudio::inRandomOrder()->first();                      
            
            $estacao = $estudio->estacao->random();
            $agendamento->estacao()->associate($estacao);

            $orcamento = $estudio->orcamento->random();
            $agendamento->orcamento()->associate($orcamento);
    
            $agendamento_status = \App\AgendamentoStatus::inRandomOrder()->first(); 
            $agendamento->agendamento_status()->associate($agendamento_status);
    
            $agendamento->save();
        }
    }
}
