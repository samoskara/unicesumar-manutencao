<?php

use Illuminate\Database\Seeder;

class ComplexidadeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Complexidade::class)->create(['nivel' =>'Baixo']);
        factory(\App\Complexidade::class)->create(['nivel' =>'Médio']);
        factory(\App\Complexidade::class)->create(['nivel' =>'Alto']);
    }
}
