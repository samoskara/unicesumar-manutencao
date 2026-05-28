<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $estudio = \App\Estudio::find(session()->get('estudio'));

        $clientes_count = $estudio->cliente->count();
        
        $orcamentos_artista_count = $estudio->orcamento->where('fk_orcamento_status_id_orcamento_status', '1')->count();
        
        $orcamentos_cliente_count = $estudio->orcamento->where('fk_orcamento_status_id_orcamento_status', '2')->count();

        $total_orcamento = $estudio->orcamento->where('fk_orcamento_status_id_orcamento_status', '<>', '4')->sum('valor');

        return view('admin.home', compact('clientes_count', 'orcamentos_artista_count', 'orcamentos_cliente_count', 'total_orcamento'));
    }

    public function estudio($id_estudio)
    {
        $user = auth()->user();                                   // Seleciona o usuário logado

        $user->estudio()->findOrFail($id_estudio);                // Verifica se o estúdio é vinculado ao usuário
    
        session()->put('estudio', $id_estudio);                   // Recebe o id do estúdio selecionado e armazena na session
        
        return redirect()->back()->with("success_toastr", "O estúdio foi selecionado com sucesso!");
    }
}