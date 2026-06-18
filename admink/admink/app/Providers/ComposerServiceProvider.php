<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {     
        view()->composer('admin*', 'App\Http\Views\EstudioViewComposer@compose'); // Chama o EstudioViewComposer para todas as views de admin
    }
}