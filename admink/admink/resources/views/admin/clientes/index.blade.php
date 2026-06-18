@extends('layouts.admin')

@section('styles')

<!-- Datatables Styles -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="https://cdn.datatables.net/plug-ins/1.10.13/features/mark.js/datatables.mark.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/datatables.mark.js/2.0.0/datatables.mark.min.css" rel="stylesheet">

@endsection

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Clientes</h1>

        <a href="{{ route('admin.clientes.create') }}" class="d-none d-inline-block btn btn-primary shadow-sm">
            Novo cliente
        </a>
    </div>

    <!-- DataTales -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-sm" id="dataTableClientes" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Opções</th>
                            <th>Nome</th>
                            <th>Apelido</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Data de Nascimento</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Laço para exibir os clientes -->
                        @foreach ($clientes as $c)
                        @php
                        $e = $c->estudio->find(session()->get('estudio'));
                        @endphp
                        <tr>
                            <td>
                                <!-- Botão de opções -->
                                <div class="dropdown">
                                    <a class="btn" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v align-middle"></i>
                                    </a>

                                    <!-- Botão Visualizar -->
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#" role="button" data-toggle="modal"
                                            data-target="#clienteShowModal" data-nome="{{ $c->nome }}"
                                            data-apelido="{{ $c->apelido }}" data-email="{{ $c->email }}"
                                            data-telefone="{{ $c->telefone }}" @if($c->data_nascimento)
                                            data-data_nascimento="{{ date_format($c->data_nascimento, 'd/m/Y') }}"
                                            @else
                                            data-data_nascimento=""
                                            @endif
                                            data-observacao="{{ $c->observacao }}"
                                            data-ativo="{{ $e->pivot->ativo }}">

                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                            <span>Visualizar</span>

                                        </a>

                                        <!-- Botão Editar -->
                                        <a class="dropdown-item"
                                            href="{{ route('admin.clientes.edit', ['cliente'=>$c->id_cliente]) }}"
                                            role="button">

                                            <i class="fas fa-edit"></i>
                                            <span>Editar</span>

                                        </a>

                                        <!-- Botão Excluir -->
                                        <a class="dropdown-item" href="#" role="button" data-toggle="modal"
                                            data-target="#clienteDeleteModal" data-nome="{{ $c->nome }}"
                                            data-url="{{ route('admin.clientes.destroy', $c->id_cliente) }}">

                                            <i class="fa fa-trash text-danger" aria-hidden="true"></i>
                                            <span class="text-danger">Excluir</span>

                                        </a>
                                    </div>
                                </div>
                            </td>

                            <!-- Dados do cliente -->
                            <td class="align-middle">{{ $c->nome }}</td>
                            <td class="align-middle">{{ $c->apelido }}</td>
                            <td class="align-middle">{{ $c->email }}</td>
                            <td class="align-middle">{{ $c->telefone }}</td>
                            @if ($c->data_nascimento)
                            <td class="align-middle">{{ date_format($c->data_nascimento, 'd/m/Y') }}</td>
                            @else
                            <td class="align-middle"></td>
                            @endif
                            <td class="align-middle">@if($e->pivot->ativo) Ativo @else Inativo @endif</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Cliente Show Modal -->
<div class="modal fade" id="clienteShowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Visualizar cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Formulário -->
            <div class="modal-body">
                <form action="" method="GET">

                    <!-- Campo Nome -->
                    <div class="form-group row">
                        <label class="col-form-label col-sm-5"><strong>Nome:</strong></label>
                        <div class="col-sm-7">
                            <input id="nome" type="text" name="nome" class="form-control-plaintext" readonly>
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

                    <!-- Campo Apelido -->
                    <div class="form-group row">
                        <label class="col-form-label col-sm-5"><strong>Apelido:</strong></label>
                        <div class="col-sm-7">
                            <input id="apelido" type="text" name="apelido" class="form-control-plaintext" readonly>
                        </div>
                    </div>

                    <!-- Campo Observação -->
                    <div class="form-group row">
                        <label class="col-form-label col-sm-5"><strong>Observação:</strong></label>
                        <div class="col-sm-7">
                            <textarea id="observacao" name="tatuagem_referencias" cols="30" rows="3"
                                class="form-control form-control-user" readonly></textarea>
                        </div>
                    </div>

                    <!-- Campo Status -->
                    <div class="form-group row">
                        <label class="col-form-label col-sm-5"><strong>Status:</strong></label>
                        <div class="col-sm-7">
                            <input id="ativo" type="text" name="ativo" class="form-control-plaintext" readonly>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Footer do Modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
            </div>

        </div>
    </div>
</div>

<!-- Cliente Delete Modal -->
<div class="modal fade" id="clienteDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="clienteDeleteModal">Excluir cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Mensagem de alerta-->
            <div class="modal-body">
                <span>Tem certeza que deseja <strong class="text-danger">excluir</strong> o cliente abaixo?</span>
                <input id="nome" class="form-control mt-3 mb-3" type="text" disabled>
                <span><strong class="text-danger">Todos os orçamentos e agendamentos desse cliente também serão excluídos.</strong> Para não utilizar um cliente e manter seus orçamentos e agendamentos basta desmarcar a opção "Ativo" na edição do cliente.</span>
            </div>

            <!-- Footer do Modal -->
            <div class="modal-footer">
                <form id="clienteDeleteForm" action="" method="POST">
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

<!-- Script Cliente Show Modal -->
<script>
    $('#clienteShowModal').on('show.bs.modal', function(e) {
        var link = $(e.relatedTarget)
        var nome = link.data('nome')
        var apelido = link.data('apelido')
        var email = link.data('email')
        var telefone = link.data('telefone')
        var data_nascimento = link.data('data_nascimento')
        var observacao = link.data('observacao')
        var ativo = link.data('ativo')

        var modal = $(this)
        
        modal.find(".modal-body #nome").val(nome);
        modal.find(".modal-body #apelido").val(apelido);
        modal.find(".modal-body #email").val(email);
        modal.find(".modal-body #telefone").val(telefone);
        modal.find(".modal-body #data_nascimento").val(data_nascimento);
        modal.find(".modal-body #observacao").val(observacao);
        
        if(ativo == '1')
        {
            modal.find(".modal-body #ativo").val("Ativo");
        } 
        else 
        {
            modal.find(".modal-body #ativo").val("Inativo");
        }
    });
</script>

<!-- Script Cliente Delete Modal -->
<script>
    $('#clienteDeleteModal').on('show.bs.modal', function(e) {
        var link = $(e.relatedTarget)
        var nome = link.data('nome')
        var url = link.data('url')
        var modal = $(this)

        modal.find(".modal-body #nome").val(nome);

        $('#clienteDeleteForm').attr("action", url)
    });
</script>

@endsection