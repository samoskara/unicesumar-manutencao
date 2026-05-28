<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;

use Closure;

class CheckEstudio
{
    /**
     * Verifica se há estúdio na sessão e salva o primeiro estúdio do usuário se não tiver
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (request()->is('admin*')){                                    // Verifica se a rota acessada faz parte do diretório admin
            if (!session()->has('estudio')) {                            // Se não tiver nenhum estudio na session, salva o primeiro estudio do usuário
                $user = auth()->user();                                  // Seleciona o usuário logado
                $estudio_usuario = $user->estudio()->first();            // Busca o primeiro estúdio da lista de estúdios do usuáio
                session()->put('estudio', $estudio_usuario->id_estudio); // Salva na key estudio da sessão o id do primeiro estúdio do usuário
            }
        }
        return $next($request);
    }
}
