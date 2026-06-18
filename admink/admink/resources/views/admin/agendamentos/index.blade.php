@extends('layouts.admin')

@section('styles')

<!-- Datatables Styles -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/datatables.mark.js/2.0.0/datatables.mark.min.css" rel="stylesheet">

@endsection

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Agendamentos</h1>

        <a href="{{ route('admin.agendamentos.create', ['o_selected' => '0']) }}"
            class="d-none d-inline-block btn btn-primary shadow-sm">
            Novo agendamento
        </a>
    </div>

    <!-- DataTables -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-sm" id="dataTableAgendamentos" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Opções</th>
                            <th>Status</th>
                            <th>Tatuagem</th>
                            <th>Cliente</th>
                            <th>Artista</th>
                            <th>Data e Hora Inicial</th>
                            <th>Hora Final</th>
                            <th>Estação</th>
                            <th>Orçamento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Laço para exibir os agendamentos -->
                        @foreach ($agendamentos as $a)
                        <tr>
                            <td>
                                <!-- Botão Opções -->
                                <div class="dropdown">
                                    <a class="btn" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v align-middle"></i>
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                        @if($a->agendamento_status->id_agendamento_status == '1')
                                        <!-- Botão Exportar Termo -->
                                        <a class="dropdown-item"
                                            href="{{ route('admin.downloadPDF', ['id' => $a->id_agendamento]) }}"
                                            role="button">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                            <span>Exportar termo</span>
                                        </a>
                                        @endif

                                        @if($a->agendamento_status->id_agendamento_status == '1')
                                        <!-- Botão Editar -->
                                        <a class="dropdown-item"
                                            href="{{ route('admin.agendamentos.edit', ['agendamento' => $a->id_agendamento]) }}"
                                            role="button">

                                            <i class="fas fa-edit"></i>
                                            <span>Editar</span>
                                        </a>
                                        @endif


                                        @if($a->agendamento_status->id_agendamento_status == '1')
                                        <!-- Botão Finalizar -->
                                        <a class="dropdown-item"
                                            href="{{ route('admin.agendamentos.finalizar', ['agendamento' => $a->id_agendamento]) }}"
                                            role="button">

                                            <i class="fa fa-check" aria-hidden="true"></i>
                                            <span>Finalizar</span>
                                        </a>
                                        @endif

                                        @if($a->agendamento_status->id_agendamento_status == '1')
                                        <!-- Botão Cancelar -->
                                        <a class="dropdown-item"
                                            href="{{ route('admin.agendamentos.cancelar', ['agendamento' => $a->id_agendamento]) }}"
                                            role="button">

                                            <i class="fa fa-thumbs-down" aria-hidden="true"></i>
                                            <span>Cancelar</span>
                                        </a>
                                        @endif

                                        <!-- Botão Excluir -->
                                        <a class="dropdown-item" href="#" role="button" data-toggle="modal"
                                            data-target="#agendamentoDeleteModal"
                                            data-data_horario_inicio="{{ date_format($a->data_horario_inicio, 'd/m/Y H:i') }}"
                                            data-cliente="{{ $a->orcamento->cliente->nome }}"
                                            data-artista="{{ $a->orcamento->artista->apelido }}"
                                            data-url="{{ route('admin.agendamentos.destroy', $a->id_agendamento) }}">

                                            <i class="fa fa-trash text-danger" aria-hidden="true"></i>
                                            <span class="text-danger">Excluir</span>
                                        </a>
                                    </div>
                                </div>
                            </td>

                            <!-- Dados do agendamento -->
                            <td class="align-middle
                            @switch($a->agendamento_status->id_agendamento_status)
                                @case(1)
                                text-warning
                                    @break
                                @case(2)
                                text-success
                                    @break
                                @case(3)
                                text-danger
                                    @break
                                @default
                            @endswitch">{{ $a->agendamento_status->status }}</td>
                            <td class="align-middle">{{ $a->orcamento->tatuagem_nome }}</td>
                            <td class="align-middle">{{ $a->orcamento->cliente->nome }}</td>
                            <td class="align-middle">{{ $a->orcamento->artista->nome }}</td>
                            @if ($a->data_horario_inicio)
                            <td class="align-middle">{{ date_format($a->data_horario_inicio, 'd/m/Y H:i') }}</td>
                            @else
                            <td class="align-middle"></td>
                            @endif
                            @if ($a->data_horario_fim)
                            <td class="align-middle">{{ date_format($a->data_horario_fim, 'H:i') }}</td>
                            @else
                            <td class="align-middle"></td>
                            @endif
                            <td class="align-middle">{{ $a->estacao->identificacao }}</td>
                            <td class="align-middle">#{{ str_pad($a->orcamento->id_orcamento, 5, '0', STR_PAD_LEFT) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Agendamento Show Modal -->
<div class="modal fade" id="agendamentoShowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Visualizar agendamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="" method="GET">

                    <!-- Campo Nome -->
                    <div class="form-group row">
                        <label class="col-form-label col-sm-5"><strong>Nome:</strong></label>
                        <div class="col-sm-7">
                            <input id="nome" type="text" name="nome" class="form-control-plaintext" readonly>
                        </div>
                    </div>

                    <!-- Campo Apelido -->
                    <div class="form-group row">
                        <label class="col-form-label col-sm-5"><strong>Apelido:</strong></label>
                        <div class="col-sm-7">
                            <input id="apelido" type="text" name="apelido" class="form-control-plaintext" readonly>
                        </div>
                    </div>

                    <!-- Campo Email -->
                    <div class="form-group row">
                        <label class="col-form-label col-sm-5"><strong>Email:</strong></label>
                        <div class="col-sm-7">
                            <input id="email" type="text" name="email" class="form-control-plaintext" readonly>
                        </div>
                    </div>

                    <!-- Campo Telefone -->
                    <div class="form-group row">
                        <label class="col-form-label col-sm-5"><strong>Telefone:</strong></label>
                        <div class="col-sm-7">
                            <input id="telefone" type="text" name="telefone" class="form-control-plaintext" readonly>
                        </div>
                    </div>

                    <!-- Campo Data de Nascimento -->
                    <div class="form-group row">
                        <label class="col-form-label col-sm-5"><strong>Data de Nascimento:</strong></label>
                        <div class="col-sm-7">
                            <input id="data_nascimento" type="text" name="data_nascimento"
                                class="form-control-plaintext" readonly>
                        </div>
                    </div>

                    <hr>

                    <!-- Botão Exibir Vínculo -->
                    <div class="mb-3">
                        <a class="btn btn-outline-secondary btn-sm" data-toggle="collapse" href="#multiCollapseVinculo"
                            role="button" aria-expanded="false">
                            Exibir vínculo com estúdio
                        </a>
                    </div>

                    <!-- Campo Data de Início -->
                    <div class="collapse multi-collapse" id="multiCollapseVinculo">
                        <div class="form-group row">
                            <label class="col-form-label col-sm-5"><strong>Data de Início:</strong></label>
                            <div class="col-sm-7">
                                <input id="data_inicio" type="text" name="data_inicio" class="form-control-plaintext"
                                    readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Campo Data de Fim -->
                    <div class="collapse multi-collapse" id="multiCollapseVinculo">
                        <div class="form-group row">
                            <label class="col-form-label col-sm-5"><strong>Data de Fim:</strong></label>
                            <div class="col-sm-7">
                                <input id="data_fim" type="text" name="data_fim" class="form-control-plaintext"
                                    readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Campo Status -->
                    <div class="collapse multi-collapse" id="multiCollapseVinculo">
                        <div class="form-group row">
                            <label class="col-form-label col-sm-5"><strong>Status:</strong></label>
                            <div class="col-sm-7">
                                <input id="ativo" type="text" name="ativo" class="form-control-plaintext" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Campo Visitante -->
                    <div class="collapse multi-collapse" id="multiCollapseVinculo">
                        <div class="form-group row">
                            <label class="col-form-label col-sm-5"><strong>Visitante:</strong></label>
                            <div class="col-sm-7">
                                <input id="visitante" type="text" name="visitante" class="form-control-plaintext"
                                    readonly>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Botão de Voltar -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
            </div>

        </div>
    </div>
</div>

<!-- Agendamento Delete Modal -->
<div class="modal fade" id="agendamentoDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="agendamentoDeleteModal">Excluir agendamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Mensagem de alerta -->
            <div class="modal-body">
                <span>Tem certeza que deseja <strong class="text-danger">excluir</strong> o agendamento abaixo?</span>
                <div class="form-group">
                    <label for="artista">Artista:</label>
                    <input id="artista" class="form-control mb-3" type="text" disabled>
                </div>
                <div class="form-group">
                    <label for="cliente">Cliente:</label>
                    <input id="cliente" class="form-control mb-3" type="text" disabled>
                </div>
                <div class="form-group">
                    <label for="data_horario_inicio">Data e Hora:</label>
                    <input id="data_horario_inicio" class="form-control mb-3" type="text" disabled>
                </div>
            </div>

            <!-- Footer do Modal -->
            <div class="modal-footer">
                <form id="artistaDeleteForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<!-- Datatables Plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/g/mark.js(jquery.mark.min.js)"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.13/features/mark.js/datatables.mark.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.22/filtering/type-based/accent-neutralise.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.22/sorting/date-eu.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.22/sorting/date-euro.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.22/sorting/chinese-string.js"></script>
<script src="{{ asset('js/demo/datatables-demo.js') }}"></script>

<!-- Script Artista Show Modal -->
<script>
    $('#artistaShowModal').on('show.bs.modal', function(e) {
        var link = $(e.relatedTarget)
        var nome = link.data('nome')
        var apelido = link.data('apelido')
        var email = link.data('email')
        var telefone = link.data('telefone')
        var data_nascimento = link.data('data_nascimento')
        var data_inicio = link.data('data_inicio')
        var data_fim = link.data('data_fim')
        var ativo = link.data('ativo')
        var visitante = link.data('visitante')

        var modal = $(this)

        modal.find(".modal-body #nome").val(nome);
        modal.find(".modal-body #apelido").val(apelido);
        modal.find(".modal-body #email").val(email);
        modal.find(".modal-body #telefone").val(telefone);
        modal.find(".modal-body #data_nascimento").val(data_nascimento);
        modal.find(".modal-body #data_inicio").val(data_inicio);
        modal.find(".modal-body #data_fim").val(data_fim);

        if(ativo == '1')
        {
            modal.find(".modal-body #ativo").val("Ativo");
        }
        else
        {
            modal.find(".modal-body #ativo").val("Inativo");
        }

        if(visitante == '1')
        {
            modal.find(".modal-body #visitante").val("Sim");
        }
        else
        {
            modal.find(".modal-body #visitante").val("Não");
        }
    });
</script>

<!-- Script Artista Delete Modal -->
<script>
    $('#agendamentoDeleteModal').on('show.bs.modal', function(e) {
        var link = $(e.relatedTarget)
        var data_horario_inicio = link.data('data_horario_inicio')
        var cliente = link.data('cliente')
        var artista = link.data('artista')
        var url = link.data('url')

        var modal = $(this)

        modal.find(".modal-body #data_horario_inicio").val(data_horario_inicio);
        modal.find(".modal-body #cliente").val(cliente);
        modal.find(".modal-body #artista").val(artista);

        $('#artistaDeleteForm').attr("action", url)
    });
</script>

@endsection
