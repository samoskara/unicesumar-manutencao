<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ClienteRequest;
use App\Http\Requests\ClienteEditRequest;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

class ClienteController extends Controller
{
    public function index()
    {
        $estudio = \App\Estudio::find(session()->get('estudio'));  // Buscando o estúdio do usuário logado
        $clientes = $estudio->cliente;                             // Criando uma collection dos clientes desse estúdio
        return view('admin.clientes.index', compact('clientes'));  // Retornando a view de lista com a collection de clientes
    }

    public function create()
    {
        return view('admin.clientes.create');                      // Exibindo view de formulário de cadastro de cliente
    }

    public function store(ClienteRequest $request)
    {
        $data = $request->all();                                   // Salva os dados recebidos do formulário na collection $data
        $estudio = \App\Estudio::find(session()->get('estudio'));
        
        try {
            $estudio->cliente()->create($data);                    // Acessa o método cliente() do estudio para criar um novo cliente para esse estúdio
        } catch (QueryException $exception) {
            if (Str::contains($exception->getMessage(), 'Data de nascimento inválida')) $msg = 'Data de nascimento inválida: Idade deve ser maior que 16 anos.';
                else if(Str::contains($exception->getMessage(), 'E-mail inválido')) $msg = 'Email inválido.';
                    else $msg = $exception->getMessage();
            $request->flash();
            return redirect()->back()->with("warning_toastr", $msg);
        }
        
        return redirect()->route('admin.clientes.index')->with("success_toastr", "O cliente foi cadastrado com sucesso!");
    }

    public function show($id)
    {
        abort(400, "A requisição chamou o método @show, porém ele está desabilitado no sistema.");
    }

    public function edit($cliente)
    {
        $cliente = \App\Cliente::findOrFail($cliente);                             // Busca no banco o cliente com o id recebido na request

        $estudio_cliente = $cliente->estudio->find(session()->get('estudio'));     // Seleciona apenas aquele que está salvo na sessão do usuário
        $cliente_estudio = $estudio_cliente->pivot;               

        return view('admin.clientes.edit', compact('cliente', 'cliente_estudio')); // Exibe view com formulário para edição de cliente com os dados do cliente
    }

    public function update(ClienteEditRequest $request, $cliente)
    {
        $data = $request->all();                                                   // Salva os dados recebidos do formulário na collection $data
        $cliente = \App\Cliente::findOrFail($cliente);                             // Salva na variável $cliente o cliente do banco correspondente ao id da request

        try {
            $cliente->update($data);                                               // Executa o método update passando os dados da request
        } catch (QueryException $exception) {
            if (Str::contains($exception->getMessage(), 'Data de nascimento inválida')) $msg = 'Data de nascimento inválida: Idade deve ser maior que 16 anos.';
                else if(Str::contains($exception->getMessage(), 'E-mail inválido')) $msg = 'Email inválido.';
                    else $msg = $exception->getMessage();
            $request->flash();
            return redirect()->back()->with("warning_toastr", $msg);
        }

        $estudio_cliente = $cliente->estudio->find(session()->get('estudio'));   
        $cliente_estudio = $estudio_cliente->pivot;
        $cliente_estudio->update($data);   

        return redirect()->route('admin.clientes.index')->with("success_toastr", "O cliente foi atualizado com sucesso!");
    }

    public function destroy($cliente)
    {
        $cliente = \App\Cliente::findOrFail($cliente);                             // Salva na variável $cliente o cliente do banco correspondente ao id da request    
        
        $orcamentos = \App\Orcamento::all();
        
        foreach($orcamentos as $o) {
            if($o->cliente == $cliente) {
                $o->delete();
            }
        }

        $cliente->delete();                                                        // Executa o método destroy passando os dados da request
        
        return redirect('admin/clientes')->with("success_toastr", "O cliente foi excluído com sucesso!");
    }
}