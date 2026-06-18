<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ArtistaRequest;
use App\Http\Requests\ArtistaEditRequest;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

class ArtistaController extends Controller
{
    public function index()
    {
        $estudio = \App\Estudio::find(session()->get('estudio')); // Busca no banco o estúdio da sessão, selecionado pelo usuário
        $artistas = $estudio->artista;                            // Busca a collection de artistas vinculados ao estúdio 
        return view('admin.artistas.index', compact('artistas')); // Exibe a view de lista de aristas
    }

    public function create()
    {
        return view('admin.artistas.create');
    }

    public function store(ArtistaRequest $request)
    {
        $data = $request->all();
        $estudio = \App\Estudio::findOrFail(session()->get('estudio')); // Busca no banco o estúdio da sessão, selecionado pelo usuário
        
        try {
            $estudio->artista()->create($data);                         // Cria o artista vinculando ao estúdio
        } catch (QueryException $exception) {
            if (Str::contains($exception->getMessage(), 'Data de nascimento inválida')) $msg = 'Data de nascimento inválida: Idade deve ser maior que 16 anos.';
                else if(Str::contains($exception->getMessage(), 'E-mail inválido')) $msg = 'Email inválido.';
                    else $msg = $exception->getMessage();
            $request->flash();
            return redirect()->back()->with("warning_toastr", $msg);
        }
        
        return redirect()->route('admin.artistas.index')->with("success_toastr", "O artista foi cadastrado com sucesso!");
    }

    public function show($id)
    {
        abort(400, "A requisição chamou o método @show, porém ele está desabilitado no sistema.");
    }

    public function edit($artista)
    {
        $artista = \App\Artista::find($artista);

        $estudio_artista = $artista->estudio->find(session()->get('estudio'));   // Seleciona apenas aquele que está salvo na sessão do usuário
        
        $artista_estudio = $estudio_artista->pivot;                              // Salva em $artista_estudio o vínculo entre artista e estúdio

        return view('admin.artistas.edit', compact('artista', 'artista_estudio'));        
    }

    public function update(ArtistaEditRequest $request, $artista)
    {
        $data = $request->all();
        
        $artista = \App\Artista::findOrFail($artista);
        
        try {
            $artista->update($data);
        } catch (QueryException $exception) {
            if (Str::contains($exception->getMessage(), 'Data de nascimento inválida')) $msg = 'Data de nascimento inválida: Idade deve ser maior que 16 anos.';
                else if(Str::contains($exception->getMessage(), 'E-mail inválido')) $msg = 'Email inválido.';
                    else $msg = $exception->getMessage();
            $request->flash();
            return redirect()->back()->with("warning_toastr", $msg);
        }

        $estudio_artista = $artista->estudio->find(session()->get('estudio'));   // Seleciona apenas aquele que está salvo na sessão do usuário
        $artista_estudio = $estudio_artista->pivot;                              // Salva em $artista_estudio o vínculo entre artista e estúdio
        
        $artista_estudio->update($data);                                         // Faz update de acordo com os dados recebidos

        return redirect()->route('admin.artistas.index')->with("success_toastr", "O artista foi atualizado com sucesso!");
    }

    public function destroy($artista)
    {
        $artista = \App\Artista::findOrFail($artista);

        $orcamentos = \App\Orcamento::all();
        
        foreach($orcamentos as $o) {
            if($o->artista == $artista) {
                $o->delete();
            }
        }

        $artista->delete();
        return redirect('admin/artistas')->with("success_toastr", "O artista foi excluído com sucesso!");
    }
}