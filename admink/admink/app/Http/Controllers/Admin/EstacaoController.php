<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\EstacaoEditRequest;
use App\Http\Requests\EstacaoRequest;

class EstacaoController extends Controller
{
    public function index()
    {
        $estudio = \App\Estudio::findOrFail(session()->get('estudio'));
        $estacoes = $estudio->estacao;
        return view('admin.estacoes.index', compact('estacoes'));
    }

    public function create()
    {
        return view('admin.estacoes.create');
    }

    public function store(EstacaoRequest $request)
    {
        $data = $request->all();

        $estudio = \App\Estudio::findOrFail(session()->get('estudio'));

        $estudio->estacao()->create($data);

        return redirect()->route('admin.estacoes.index')->with("success_toastr", "A estação foi cadastrada com sucesso!");
    }

    public function show($id)
    {
        abort(400, "A requisição chamou o método @show, porém ele está desabilitado no sistema.");
    }

    public function edit($estacao)
    {
        $estacao = \App\Estacao::findOrFail($estacao);

        $estacao->estudio->findOrFail(session()->get('estudio'));

        return view('admin.estacoes.edit', compact('estacao'));
    }

    public function update(EstacaoEditRequest $request, $estacao)
    {
        $data = $request->all();

        $estacao = \App\Estacao::findOrFail($estacao);

        $estacao->update($data);

        return redirect()->route('admin.estacoes.index')->with("success_toastr", "A estação foi atualizada com sucesso!");
    }

    public function destroy($estacao)
    {
        $estacao = \App\Estacao::findOrFail($estacao);
        $agendamento = $estacao->agendamento()->get();
        foreach($agendamento as $a){
            $a->delete();
        }

        $estacao->delete();
        return redirect('admin/estacoes')->with("success_toastr", "A estação foi excluída com sucesso!");
    }
}
