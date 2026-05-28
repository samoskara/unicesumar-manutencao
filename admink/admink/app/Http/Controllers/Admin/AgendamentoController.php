<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Requests\AgendamentoRequest;
use App\Http\Requests\AgendamentoEditRequest;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use PDF;

class AgendamentoController extends Controller
{
    public function index()
    {
        $estudio = \App\Estudio::find(session()->get('estudio'));

        $estacoes = $estudio->estacao;

        $agendamentos = collect();

        foreach ($estacoes as $e)
        {
            $aux_agendamentos = $e->agendamento;

            foreach($aux_agendamentos as $a)
            {
                $agendamentos->push($a);
            }
        }

        return view('admin.agendamentos.index', compact('agendamentos'));
    }

    public function create()
    {
        $estudio = \App\Estudio::find(session()->get('estudio'));

        $o_selected = $_GET['o_selected'];

        $orcamentos = $estudio->orcamento()->where('fk_orcamento_status_id_orcamento_status', '2')->orWhere('fk_orcamento_status_id_orcamento_status', '3')->orderBy('tatuagem_nome', 'asc')->get();

        $estacoes = $estudio->estacao()->where('ativa', '1')->orderBy('identificacao', 'asc')->get();

        return view('admin.agendamentos.create', compact('orcamentos', 'estacoes', 'o_selected'));
    }

    public function store(AgendamentoRequest $request)
    {
        $data = $request->all();

        $data['data_horario_inicio'] = new \DateTime($data['data_horario_inicio']);

        $data['data_horario_fim'] = new \DateTime($data['data_horario_fim']);

        $agendamento = new \App\Agendamento($data);

        $agendamento->orcamento()->associate($data['orcamento']);

        $agendamento->estacao()->associate($data['estacao']);

        $agendamento->agendamento_status()->associate('1');

        try {
            $agendamento->save();
        } catch (QueryException $exception) {
            if (Str::contains($exception->getMessage(), 'A estação de trabalho deve ser uma estação ativa do estúdio.')) $msg = 'A estação de trabalho deve ser uma estação ativa do estúdio.';
                elseif (Str::contains($exception->getMessage(), 'O status do agendamento deve ser um status de agendamento ativo do estúdio.')) $msg = 'O status do agendamento deve ser um status de agendamento ativo do estúdio.';
                    elseif (Str::contains($exception->getMessage(), 'A data e horário de fim deve ser maior que a data e horário de início.')) $msg = 'A data e horário de fim deve ser maior que a data e horário de início.';
                        elseif (Str::contains($exception->getMessage(), 'O início e fim do agendamento devem ser na mesma data.')) $msg = 'O início e fim do agendamento devem ser na mesma data.';
                            elseif (Str::contains($exception->getMessage(), 'Horário indisponível na data informada.')) $msg = 'Horário indisponível na data informada.';
                                else $msg = $exception->getMessage();
            $request->flash();
            return redirect()->back()->with("warning_toastr", $msg);
        }

        $orcamento = \App\Orcamento::findOrFail($data['orcamento']);

        $orcamento->orcamento_status()->associate('3');

        $orcamento->save();

        return redirect()->route('admin.agendamentos.index')->with("success_toastr", "O agendamento foi cadastrado com sucesso!");
    }

    public function show($id)
    {
        abort(400, "A requisição chamou o método @show, porém ele está desabilitado no sistema.");
    }

    public function edit($agendamento)
    {
        $agendamento = \App\Agendamento::findOrFail($agendamento);

        $estudio = \App\Estudio::find(session()->get('estudio'));

        $orcamentos = $estudio->orcamento()->where('fk_orcamento_status_id_orcamento_status', '2')->orderBy('tatuagem_nome', 'asc')->get();

        $estacoes = $estudio->estacao()->where('ativa', '1')->orderBy('identificacao', 'asc')->get();

        return view('admin.agendamentos.edit', compact('agendamento', 'orcamentos', 'estacoes'));
    }

    public function update(AgendamentoRequest $request, $agendamento)
    {
        $data = $request->all();

        $data['data_horario_inicio'] = new \DateTime($data['data_horario_inicio']);

        $data['data_horario_fim'] = new \DateTime($data['data_horario_fim']);

        $agendamento = \App\Agendamento::findOrFail($agendamento);

        $agendamento->orcamento()->associate($data['orcamento']);

        $agendamento->estacao()->associate($data['estacao']);



        try {
            $agendamento->update($data);
        } catch (QueryException $exception) {
            if (Str::contains($exception->getMessage(), 'A estação de trabalho deve ser uma estação ativa do estúdio.')) $msg = 'A estação de trabalho deve ser uma estação ativa do estúdio.';
                elseif (Str::contains($exception->getMessage(), 'O status do agendamento deve ser um status de agendamento ativo do estúdio.')) $msg = 'O status do agendamento deve ser um status de agendamento ativo do estúdio.';
                    elseif (Str::contains($exception->getMessage(), 'A data e horário de fim deve ser maior que a data e horário de início.')) $msg = 'A data e horário de fim deve ser maior que a data e horário de início.';
                        elseif (Str::contains($exception->getMessage(), 'O início e fim do agendamento devem ser na mesma data.')) $msg = 'O início e fim do agendamento devem ser na mesma data.';
                            elseif (Str::contains($exception->getMessage(), 'Horário indisponível na data informada.')) $msg = 'Horário indisponível na data informada.';
                                else $msg = $exception->getMessage();
            $request->flash();
            return redirect()->back()->with("warning_toastr", $msg);
        }

        return redirect()->route('admin.agendamentos.index')->with("success_toastr", "O agendamento foi atualizado com sucesso!");
    }

    public function destroy($agendamento)
    {
        $agendamento = \App\Agendamento::findOrFail($agendamento);
        $agendamento->delete();

        return redirect('admin/agendamentos')->with("success_toastr", "O agendamento foi excluído com sucesso!");
    }

    public function finalizar($agendamento)
    {
        $agendamento = \App\Agendamento::findOrFail($agendamento);

        $agendamento->agendamento_status()->associate('2');

        try {
            $agendamento->save();
        } catch (QueryException $exception) {
            if (Str::contains($exception->getMessage(), 'A estação de trabalho deve ser uma estação ativa do estúdio.')) $msg = 'A estação de trabalho deve ser uma estação ativa do estúdio.';
                elseif (Str::contains($exception->getMessage(), 'O status do agendamento deve ser um status de agendamento ativo do estúdio.')) $msg = 'O status do agendamento deve ser um status de agendamento ativo do estúdio.';
                    elseif (Str::contains($exception->getMessage(), 'A data e horário de fim deve ser maior que a data e horário de início.')) $msg = 'A data e horário de fim deve ser maior que a data e horário de início.';
                        elseif (Str::contains($exception->getMessage(), 'O início e fim do agendamento devem ser na mesma data.')) $msg = 'O início e fim do agendamento devem ser na mesma data.';
                            elseif (Str::contains($exception->getMessage(), 'Horário indisponível na data informada.')) $msg = 'Horário indisponível na data informada.';
                                elseif (Str::contains($exception->getMessage(), 'Não é possível editar o status de um agendamento cancelado ou finalizado.')) $msg = 'Não é possível editar o status de um agendamento cancelado ou finalizado.';
                                    else $msg = $exception->getMessage();
            $request->flash();
            return redirect()->back()->with("warning_toastr", $msg);
        }

        return redirect('admin/agendamentos')->with("success_toastr", "O agendamento foi finalizado com sucesso!");
    }

    public function cancelar($agendamento)
    {
        $agendamento = \App\Agendamento::findOrFail($agendamento);

        $agendamento->agendamento_status()->associate('3');

        try {
            $agendamento->save();
        } catch (QueryException $exception) {
            if (Str::contains($exception->getMessage(), 'A estação de trabalho deve ser uma estação ativa do estúdio.')) $msg = 'A estação de trabalho deve ser uma estação ativa do estúdio.';
                elseif (Str::contains($exception->getMessage(), 'O status do agendamento deve ser um status de agendamento ativo do estúdio.')) $msg = 'O status do agendamento deve ser um status de agendamento ativo do estúdio.';
                    elseif (Str::contains($exception->getMessage(), 'A data e horário de fim deve ser maior que a data e horário de início.')) $msg = 'A data e horário de fim deve ser maior que a data e horário de início.';
                        elseif (Str::contains($exception->getMessage(), 'O início e fim do agendamento devem ser na mesma data.')) $msg = 'O início e fim do agendamento devem ser na mesma data.';
                            elseif (Str::contains($exception->getMessage(), 'Horário indisponível na data informada.')) $msg = 'Horário indisponível na data informada.';
                                else $msg = $exception->getMessage();
            $request->flash();
            return redirect()->back()->with("warning_toastr", $msg);
        }

        return redirect('admin/agendamentos')->with("success_toastr", "O agendamento foi cancelado com sucesso!");
    }

    public function downloadPDF($id)
    {
        $agendamento = \App\Agendamento::find($id);

        $pdf = PDF::loadView('pdf', compact('agendamento'));

        $orcamento = $agendamento->orcamento;
        $orcamento->aceite_termo = true;
        $orcamento->save();

        return $pdf->download('termo.pdf');

    }

}
