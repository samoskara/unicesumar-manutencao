@extends('layouts.admin')

@section('styles')

<!-- Datatables Styles -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/datatables.mark.js/2.0.0/datatables.mark.min.css" rel="stylesheet">

@endsection

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Estações</h1>

        <a href="{{ route('admin.estacoes.create') }}" class="d-none d-inline-block btn btn-primary shadow-sm">
            Nova estação
        </a>
    </div>

    <!-- DataTables -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-sm" id="dataTableEstacoes" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Opções</th>
                            <th>Identificação</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Laço para exibir as estações -->
                        @foreach ($estacoes as $e)
                        <tr>
                            <td>
                                <!-- Botão de opções-->
                                <div class="dropdown">
                                    <a class="btn" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v align-middle"></i>
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        
                                        <!-- Botão Editar -->
                                        <a class="dropdown-item"
                                            href="{{ route('admin.estacoes.edit', ['estacao' => $e->id_estacao]) }}"
                                            role="button">
                                            <i class="fas fa-edit"></i>
                                            <span>Editar</span>
                                        </a>

                                        <!-- Botão Excluir -->
                                        <a class="dropdown-item" href="#" role="button" data-toggle="modal"
                                            data-target="#estacaoDeleteModal" 
                                            data-identificacao="{{ $e->identificacao }}"
                                            data-url="{{ route('admin.estacoes.destroy', $e->id_estacao) }}">
                                            <i class="fa fa-trash text-danger" aria-hidden="true"></i>
                                            <span class="text-danger">Excluir</span>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Dados da estação -->
                            <td class="align-middle">{{ $e->identificacao }}</td>
                            <td class="align-middle">@if($e->ativa) Ativa @else Inativa @endif</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Estacao Delete Modal -->
<div class="modal fade" id="estacaoDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="estacaoDeleteModal">Excluir estação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Mensagem de alerta -->
            <div class="modal-body">
                <span>Tem certeza que deseja <strong class="text-danger">excluir</strong> a estação abaixo?</span>
                <input id="identificacao" class="form-control mt-2" type="text" readonly>
            </div>

            <!-- Footer do modal -->
            <div class="modal-footer">
                <form id="estacaoDeleteForm" action="" method="POST">
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

<script>
    $('#estacaoDeleteModal').on('show.bs.modal', function(e) {
        var link = $(e.relatedTarget)
        var identificacao = link.data('identificacao')
        var url = link.data('url')
        
        var modal = $(this)

        modal.find(".modal-body #identificacao").val(identificacao);

        $('#estacaoDeleteForm').attr("action", url)
    });
</script>

@endsection