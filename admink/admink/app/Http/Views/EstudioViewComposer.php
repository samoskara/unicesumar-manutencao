<?php

namespace App\Http\Views;

class EstudioViewComposer
{
    public function compose($view)
    {
        $user = auth()->user();                    // Salva na variável $user o usuário logado
        $estudios = $user->estudio;                // Busca no banco a collection de estudios do usuário logado
        return $view->with('estudios', $estudios); // Envia a collection de estúdios do usuário para as views
    }
}