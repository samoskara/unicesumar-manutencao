<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        factory(\App\User::class, 1)->create();
    }
}
// Exemplo usando helper each()
// factory(\App\User::class, 10)->create()->each(function ($user){
//     $user->estudio()->save(factory(\App\Estudio::class)->make)
// });