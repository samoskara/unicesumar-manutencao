<?php

use Illuminate\Database\Seeder;

class ArtistaTableSeeder extends Seeder
{
    public function run()
    {
        $estudios = \App\Estudio::all();                         // Busca todos os estudios e salva em $estudios

        foreach ($estudios as $estudio) 
        {                                                        // Pra cada estudio salva 5 artistas
            $artistas = factory(\App\Artista::class, 4)->make(); // Cria 5 artistas na collection $artistas

            foreach ($artistas as $artista) 
            {                                                    // Salva os 5 artistas criados no estudio atual
                $estudio->artista()->save($artista);
            }
        }
    }
}
