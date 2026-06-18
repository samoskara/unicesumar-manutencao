<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // $path = 'app/database/create_scripts/DDL_admink.sql';
        // DB::unprepared(file_get_contents($path));
        // $pathFunctions = 'app/database/create_scripts/FUNCTIONS_admink.sql';
        // DB::unprepared(file_get_contents($pathFunctions));
        // $pathProcedures = 'app/database/create_scripts/PROCEDURES_admink.sql';
        // DB::unprepared(file_get_contents($pathProcedures));
        // $pathTriggers = 'app/database/create_scripts/PROCEDURES_admink.sql';
        // DB::unprepared(file_get_contents($pathTriggers));
        
        $this->call(UsersTableSeeder::class);
        $this->call(EstudioTableSeeder::class);
        $this->call(EstacaoTableSeeder::class);
        $this->call(ClienteTableSeeder::class);
        $this->call(ArtistaTableSeeder::class);
        //$this->call(OrcamentoTableSeeder::class);
        //$this->call(AgendamentoTableSeeder::class);
    }
}
