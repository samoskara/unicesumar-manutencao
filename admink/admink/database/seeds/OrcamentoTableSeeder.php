<?php

use Illuminate\Database\Seeder;

class OrcamentoTableSeeder extends Seeder
{
    public function run()
    {
        for ($i=0; $i < 10; $i++) 
        {                                                                       // Laço para criar vários orcamentos aleatorios
            $orcamento = factory(\App\Orcamento::class)->make();                // Cria um orcamento e salva em $orcamento
    
            $estudio = \App\Estudio::inRandomOrder()->first();                  // Salva estudio aleatorio
            $orcamento->estudio()->associate($estudio);

            $cliente = $estudio->cliente->random();                             // Salva um cliente aleatorio do estúdio
            $orcamento->cliente()->associate($cliente);
    
            $artista = $estudio->artista->random();                             // Salva um artista aleatorio do estúdio
            $orcamento->artista()->associate($artista);
            
            $complexidade = \App\Complexidade::inRandomOrder()->first();        // Salva uma complexidade aleatoria
            $orcamento->complexidade()->associate($complexidade);
            
            $uso_materiais = \App\UsoMateriais::inRandomOrder()->first();       // Salva uso de material aleatorio
            $orcamento->uso_materiais()->associate($uso_materiais);
            
            $orcamento_status = \App\OrcamentoStatus::inRandomOrder()->first(); // Salva status de orcamento aleatorio
            $orcamento->orcamento_status()->associate($orcamento_status);
            
            $orcamento->save();
        }
    }
}
