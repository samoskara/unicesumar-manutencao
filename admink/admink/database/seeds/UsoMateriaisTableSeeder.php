<?php

use Illuminate\Database\Seeder;

class UsoMateriaisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\UsoMateriais::class)->create(['nivel' =>'Baixo']);
        factory(\App\UsoMateriais::class)->create(['nivel' =>'Médio']);
        factory(\App\UsoMateriais::class)->create(['nivel' =>'Alto']);
    }
}