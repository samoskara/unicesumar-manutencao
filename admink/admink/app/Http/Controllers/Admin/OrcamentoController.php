<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\OrcamentoRequest;
use App\Http\Requests\OrcamentoEditRequest;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OrcamentoController extends Controller
{
    public function index()
    {
        $estudio = \App\Estudio::find(session()->get('estudio'));

        $orcamentos = $estudio->orcamento;

        return view('admin.orcamentos.index', compact('orcamentos'));
    }

    public function create()
    {
        $estudio = \App\Estudio::find(session()->get('estudio'));

        $clientes = $estudio->cliente()->where('ativo', true)->orderBy('nome', 'asc')->get();

        $artistas = $estudio->artista()->where('ativo', true)->orderBy('nome', 'asc')->get();

        $uso_materiais = \App\UsoMateriais::all();

        $complexidade = \App\Complexidade::all();

        return view('admin.orcamentos.create', compact('clientes', 'artistas', 'uso_materiais', 'complexidade'));
    }

    public function store(OrcamentoRequest $request)
    {
        $data = $request->all();

        if($data['valor']) {
            $data['valor'] = formatarValor($data['valor']);
        }

        $orcamento = new \App\Orcamento($data);

        $estudio = \App\Estudio::findOrFail(session()->get('estudio'));

        $orcamento->estudio()->associate($estudio);

        $orcamento->cliente()->associate($data['cliente']);

        $orcamento->artista()->associate($data['artista']);

        $orcamento->complexidade()->associate($data['complexidade']);

        $orcamento->uso_materiais()->associate($data['uso_materiais']);

        if($orcamento->valor && $orcamento->tempo_estimado)
        {
            $orcamento->orcamento_status()->associate('2');
        }
        else
        {
            $orcamento->orcamento_status()->associate('1');
        }

        try {
            $orcamento->save();
        } catch (QueryException $exception) {
            if (Str::contains($exception->getMessage(), 'O cliente deve ser cliente ativo do estúdio.')) $msg = 'O cliente deve ser cliente ativo do estúdio.';
                elseif (Str::contains($exception->getMessage(), 'O artista deve ser artista ativo do estúdio.')) $msg = 'O artista deve ser artista ativo do estúdio.';
                    elseif (Str::contains($exception->getMessage(), 'O uso de materiais deve ser uso ativo do estúdio.')) $msg = 'O uso de materiais deve ser uso ativo do estúdio.';
                        elseif (Str::contains($exception->getMessage(), 'A complexidade deve ser complexidade ativa do estúdio.')) $msg = 'A complexidade deve ser complexidade ativa do estúdio.';
                            elseif (Str::contains($exception->getMessage(), 'O status do orcamento deve ser status ativo do estúdio.')) $msg = 'O status do orcamento deve ser status ativo do estúdio.';
                                elseif (Str::contains($exception->getMessage(), 'Não é possível cancelar um orçamento que possui agendamentos finalizados.')) $msg = 'Não é possível cancelar um orçamento que possui agendamentos finalizados.';
                                    else $msg = $exception->getMessage();
            $request->flash();
            return redirect()->back()->with("warning_toastr", $msg);
        }

        return redirect()->route('admin.orcamentos.index')->with("success_toastr", "O orçamento foi cadastrado com sucesso!");
    }

    public function show($id)
    {
        abort(400, "A requisição chamou o método @show, porém ele está desabilitado no sistema.");
    }

    public function edit($orcamento)
    {

        $estudio = \App\Estudio::findOrFail(session()->get('estudio'));

        $orcamento = \App\Orcamento::findOrFail($orcamento);

        $orcamento->estudio->find(session()->get('estudio'));

        $clientes = $estudio->cliente()->orderBy('nome', 'asc')->get();

        $artistas = $estudio->artista()->orderBy('nome', 'asc')->get();

        $uso_materiais = \App\UsoMateriais::all();

        $complexidade = \App\Complexidade::all();

        return view('admin.orcamentos.edit', compact('orcamento', 'clientes', 'artistas', 'uso_materiais', 'complexidade'));
    }

    public function update(OrcamentoEditRequest $request, $orcamento)
    {
        $orcamento = \App\Orcamento::findOrFail($orcamento);

        $messages = [
          'tempo_estimado.required' => 'O campo tempo estimado não pode ser nulo para orçamento agendado.',
        ];

        $validator = Validator::make($request->all(), [
            'tempo_estimado' => Rule::requiredIf($orcamento->orcamento_status->id_orcamento_status == '3'),
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = $request->all();

        if($data['valor']) {
            $data['valor'] = formatarValor($data['valor']);
        }

        $estudio = \App\Estudio::findOrFail(session()->get('estudio'));

        $orcamento->estudio()->associate($estudio);

        $orcamento->cliente()->associate($data['cliente']);

        $orcamento->artista()->associate($data['artista']);

        $orcamento->complexidade()->associate($data['complexidade']);

        $orcamento->uso_materiais()->associate($data['uso_materiais']);

        if($orcamento->orcamento_status != '3')
        {
            if($data['tempo_estimado'])
            {
                $orcamento->orcamento_status()->associate('2');
            }
            else
            {
                $orcamento->orcamento_status()->associate('1');
            }
        }

        try {
            $orcamento->update($data);
        } catch (QueryException $exception) {
            if (Str::contains($exception->getMessage(), 'O cliente deve ser cliente ativo do estúdio.')) $msg = 'O cliente deve ser cliente ativo do estúdio.';
                elseif (Str::contains($exception->getMessage(), 'O artista deve ser artista ativo do estúdio.')) $msg = 'O artista deve ser artista ativo do estúdio.';
                    elseif (Str::contains($exception->getMessage(), 'O uso de materiais deve ser uso ativo do estúdio.')) $msg = 'O uso de materiais deve ser uso ativo do estúdio.';
                        elseif (Str::contains($exception->getMessage(), 'A complexidade deve ser complexidade ativa do estúdio.')) $msg = 'A complexidade deve ser complexidade ativa do estúdio.';
                            elseif (Str::contains($exception->getMessage(), 'O status do orcamento deve ser status ativo do estúdio.')) $msg = 'O status do orcamento deve ser status ativo do estúdio.';
                                elseif (Str::contains($exception->getMessage(), 'O campo tempo estimado não pode ser nulo para orçamento agendado.')) $msg = 'O campo tempo estimado não pode ser nulo para orçamento agendado.';
                                    else $msg = $exception->getMessage();
            $request->flash();
            return redirect()->back()->with("warning_toastr", $msg);
        }

        return redirect()->route('admin.orcamentos.index')->with("success_toastr", "O orçamento foi atualizado com sucesso!");
    }

    public function destroy($orcamento)
    {
        $orcamento = \App\Orcamento::findOrFail($orcamento);

        $agendamentos = \App\Agendamento::where('fk_orcamento_id_orcamento', $orcamento->id_orcamento)->get();

        foreach($agendamentos as $a) {
            $a->delete();
        }

        $orcamento->delete();

        return redirect('admin/orcamentos')->with("success_toastr", "O orçamento foi excluído com sucesso!");
    }

    public function cancelar($orcamento)
    {
        $orcamento = \App\Orcamento::findOrFail($orcamento);

        $agendamentos = $orcamento->agendamento;

        foreach($agendamentos as $a) {
            $a->agendamento_status()->associate('3');
            $a->save();
        }

        if($orcamento->orcamento_status->id_orcamento_status == '4')
        {
            return redirect()->back()->with("warning_toastr", 'O orçamento já está cancelado.');
        }
        else
        {
            $orcamento->orcamento_status()->associate('4');

        }

        try {
            $orcamento->save();
        } catch (QueryException $exception) {
            if (Str::contains($exception->getMessage(), 'O cliente deve ser cliente ativo do estúdio.')) $msg = 'O cliente deve ser cliente ativo do estúdio.';
                elseif (Str::contains($exception->getMessage(), 'O artista deve ser artista ativo do estúdio.')) $msg = 'O artista deve ser artista ativo do estúdio.';
                    elseif (Str::contains($exception->getMessage(), 'O uso de materiais deve ser uso ativo do estúdio.')) $msg = 'O uso de materiais deve ser uso ativo do estúdio.';
                        elseif (Str::contains($exception->getMessage(), 'A complexidade deve ser complexidade ativa do estúdio.')) $msg = 'A complexidade deve ser complexidade ativa do estúdio.';
                            elseif (Str::contains($exception->getMessage(), 'O status do orcamento deve ser status ativo do estúdio.')) $msg = 'O status do orcamento deve ser status ativo do estúdio.';
                                else $msg = $exception->getMessage();
            $request->flash();
            return redirect()->back()->with("warning_toastr", $msg);
        }

        return redirect('admin/orcamentos')->with("success_toastr", "O orçamento foi cancelado com sucesso!");
    }

    public function recuperar($orcamento)
    {
        $orcamento = \App\Orcamento::findOrFail($orcamento);

        if($orcamento->valor && $orcamento->tempo_estimado)
        {
            $orcamento->orcamento_status()->associate('2');
        }
        else
        {
            $orcamento->orcamento_status()->associate('1');
        }

        try {
            $orcamento->save();
        } catch (QueryException $exception) {
            if (Str::contains($exception->getMessage(), 'O cliente deve ser cliente ativo do estúdio.')) $msg = 'O cliente deve ser cliente ativo do estúdio.';
                elseif (Str::contains($exception->getMessage(), 'O artista deve ser artista ativo do estúdio.')) $msg = 'O artista deve ser artista ativo do estúdio.';
                    elseif (Str::contains($exception->getMessage(), 'O uso de materiais deve ser uso ativo do estúdio.')) $msg = 'O uso de materiais deve ser uso ativo do estúdio.';
                        elseif (Str::contains($exception->getMessage(), 'A complexidade deve ser complexidade ativa do estúdio.')) $msg = 'A complexidade deve ser complexidade ativa do estúdio.';
                            elseif (Str::contains($exception->getMessage(), 'O status do orcamento deve ser status ativo do estúdio.')) $msg = 'O status do orcamento deve ser status ativo do estúdio.';
                                else $msg = $exception->getMessage();
            $request->flash();
            return redirect()->back()->with("warning_toastr", $msg);
        }

        return redirect('admin/orcamentos')->with("success_toastr", "O orçamento foi recuperado com sucesso!");
    }
}
