@extends('layouts.admin')

@section('styles')

<!-- Datatables Styles -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/datatables.mark.js/2.0.0/datatables.mark.min.css" rel="stylesheet">

@endsection

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Artistas</h1>

        <a href="{{ route('admin.artistas.create') }}" class="d-none d-inline-block btn btn-primary shadow-sm">
            Novo artista
        </a>
    </div>

    <!-- DataTables -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-sm" id="dataTableArtistas" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Opções</th>
                            <th>Nome</th>
                            <th>Apelido</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Data de Nascimento</th>
                            <th>Status</th>
                            <th>Visitante</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Laço para exibir os artistas -->
                        @foreach ($artistas as $a)
                        @php
                        $e = $a->estudio->find(session()->get('estudio'));
                        @endphp
                        <tr>
                            <td>
                                <!-- Botão Opções -->
                                <div class="dropdown">
                                    <a class="btn" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v align-middle"></i>
                                    </a>

                                    <!-- Botão Visualizar -->
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#" role="button" data-toggle="modal"
                                            data-target="#artistaShowModal" data-nome="{{ $a->nome }}"
                                            data-apelido="{{ $a->apelido }}" data-email="{{ $a->email }}"
                                            data-telefone="{{ $a->telefone }}" @if ($a->data_nascimento)
                                            data-data_nascimento="{{ date_format($a->data_nascimento, 'd/m/Y') }}"
                                            @else data-data_nascimento="" @endif
                                            @if ($e->pivot->data_inicio)
                                            data-data_inicio="{{ date_format($e->pivot->data_inicio, 'd/m/Y') }}"
                                            @else data-data_inicio="" @endif
                                            @if ($e->pivot->data_fim)
                                            data-data_fim="{{ date_format($e->pivot->data_fim, 'd/m/Y') }}"
                                            @else data-data_fim="" @endif
                                            data-ativo="{{ $e->pivot->ativo }}"
                                            data-visitante="{{ $e->pivot->visitante }}">

                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                            <span>Visualizar</span>
                                        </a>

                                        <!-- Botão Editar -->
                                        <a class="dropdown-item"
                                            href="{{ route('admin.artistas.edit', ['artista' => $a->id_artista]) }}"
                                            role="button">

                                            <i class="fas fa-edit"></i>
                                            <span>Editar</span>
                                        </a>

                                        <!-- Botão Excluir -->
                                        <a class="dropdown-item" href="#" role="button" data-toggle="modal"
                                            data-target="#artistaDeleteModal" data-nome="{{ $a->nome }}"
                                            data-url="{{ route('admin.artistas.destroy', $a->id_artista) }}">

                                            <i class="fa fa-trash text-danger" aria-hidden="true"></i>
                                            <span class="text-danger">Excluir</span>
                                        </a>
                                    </div>
                                </div>
                            </td>

                            <!-- Dados do artista -->
                            <td class="align-middle">{{ $a->nome }}</td>
                            <td class="align-middle">{{ $a->apelido }}</td>
                            <td class="align-middle">{{ $a->email }}</td>
                            <td class="align-middle">{{ $a->telefone }}</td>
                            @if ($a->data_nascimento)
                            <td class="align-middle">{{ date_format($a->data_nascimento, 'd/m/Y') }}</td>
                            @else
                            <td class="align-middle"></td>
                            @endif
                            <td class="align-middle">@if($e->pivot->ativo) Ativo @else Inativo @endif</td>
                            <td class="align-middle">@if($e->pivot->visitante) Sim @else Não @endif</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Artista Show Modal -->
<div class="modal fade" id="artistaShowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Visualizar artista</h5>
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

<!-- Artista Delete Modal -->
<div class="modal fade" id="artistaDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="artistaDeleteModal">Excluir artista</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Mensagem de alerta -->
            <div class="modal-body">
                <span>Tem certeza que deseja <strong class="text-danger">excluir</strong> o artista abaixo?</span>
                <input id="nome" class="form-control mt-3 mb-3" type="text" disabled>
                <span><strong class="text-danger">Todos os orçamentos e agendamentos desse artista também serão excluídos.</strong> Para não utilizar um artista e manter seus orçamentos e agendamentos basta desmarcar a opção "Ativo" na edição do artista.</span>
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
    $('#artistaDeleteModal').on('show.bs.modal', function(e) {
        var link = $(e.relatedTarget)
        var nome = link.data('nome')
        var url = link.data('url')
        var modal = $(this)

        modal.find(".modal-body #nome").val(nome);

        $('#artistaDeleteForm').attr("action", url)
    });
</script>

@endsection