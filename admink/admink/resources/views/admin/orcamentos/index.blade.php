@extends('layouts.admin')

@section('styles')

<!-- Datatables Styles -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/datatables.mark.js/2.0.0/datatables.mark.min.css" rel="stylesheet">

@endsection

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Orçamentos</h1>

        <a href="{{ route('admin.orcamentos.create') }}" class="d-none d-inline-block btn btn-primary shadow-sm">
            Novo orçamento
        </a>
    </div>

    <!-- DataTables -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-sm" id="dataTableOrcamentos" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Opções</th>
                            <th>Status</th>
                            <th>Tatuagem</th>
                            <th>Cliente</th>
                            <th>Artista</th>
                            <th>Cadastrado em</th>
                            <th>Atualizado em</th>
                            <th>Código</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($orcamentos as $o)
                        <tr>
                            <td>
                                <!-- Botão de opções -->
                                <div class="dropdown">
                                    <a class="btn" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v align-middle"></i>
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                        @if ($o->orcamento_status->id_orcamento_status == '2' || $o->orcamento_status->id_orcamento_status == '3')
                                        <!-- Botão Agendar -->
                                        <a class="dropdown-item"
                                            href="{{ route('admin.agendamentos.create', ['o_selected' => $o->id_orcamento]) }}"
                                            role="button">
                                            <i class="fa fa-calendar text-primary" aria-hidden="true"></i>
                                            <span class="text-primary">Agendar</span>
                                        </a>
                                        @endif

                                        <!-- Botão Visualizar -->
                                        <a class="dropdown-item" href="#" role="button" data-toggle="modal"
                                            data-target="#orcamentoShowModal"
                                            data-tatuagem_nome="{{ $o->tatuagem_nome }}"
                                            data-tatuagem_local="{{ $o->tatuagem_local }}"
                                            data-tatuagem_comprimento="{{ $o->tatuagem_comprimento }}"
                                            data-tatuagem_largura="{{ $o->tatuagem_largura }}"
                                            data-tatuagem_descricao="{{ $o->tatuagem_descricao }}"
                                            data-tatuagem_referencias="{{ $o->tatuagem_colorida }}"
                                            data-tatuagem_autoral="{{ $o->tatuagem_autoral }}"
                                            data-valor="{{ $o->valor }}" data-tempo_estimado="{{ $o->tempo_estimado }}"
                                            data-canal_contato="{{ $o->canal_contato }}"
                                            data-observacao="{{ $o->observacao }}"
                                            data-cliente="{{ $o->cliente->nome }}"
                                            data-artista="{{ $o->artista->nome }}"
                                            data-uso_materiais="{{ $o->uso_materiais['nivel'] }}"
                                            data-complexidade="{{ $o->complexidade['nivel'] }}"
                                            data-orcamento_status="{{ $o->orcamento_status->status }}">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                            <span>Visualizar</span>
                                        </a>


                                        @if ($o->orcamento_status->id_orcamento_status != '4')
                                        <!-- Botão Editar -->
                                        <a class="dropdown-item"
                                            href="{{ route('admin.orcamentos.edit', ['orcamento' => $o->id_orcamento]) }}"
                                            role="button">
                                            <i class="fas fa-edit"></i>
                                            <span>Editar</span>
                                        </a>
                                        @endif

                                        @if ($o->orcamento_status->id_orcamento_status != '4')
                                            <!-- Botão Cancelar -->
                                            <a class="dropdown-item"
                                                href="{{ route('admin.orcamentos.cancelar', ['orcamento' => $o->id_orcamento]) }}"
                                                role="button">
                                                <i class="fa fa-thumbs-down" aria-hidden="true"></i>
                                                <span>Cancelar</span>
                                            </a>
                                        @endif

                                        @if ($o->orcamento_status->id_orcamento_status == '4')
                                            <!-- Botão Cancelar -->
                                            <a class="dropdown-item"
                                                href="{{ route('admin.orcamentos.recuperar', ['orcamento' => $o->id_orcamento]) }}"
                                                role="button">
                                                <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                                <span>Recuperar</span>
                                            </a>
                                        @endif

                                        <!-- Botão Excluir -->
                                        <a class="dropdown-item" href="#" role="button" data-toggle="modal"
                                            data-target="#orcamentoDeleteModal"
                                            data-url="{{ route('admin.orcamentos.destroy', $o->id_orcamento) }}"
                                            data-tatuagem_nome="{{ $o->tatuagem_nome }}"
                                            data-cliente="{{ $o->cliente->nome }}"
                                            data-artista="{{ $o->artista->apelido }}">
                                            <i class="fa fa-trash text-danger" aria-hidden="true"></i>
                                            <span class="text-danger">Excluir</span>
                                        </a>
                                    </div>
                                </div>
                            </td>

                            <!-- Dados do Orçamento -->
                            <td class="align-middle 
                                @switch($o->orcamento_status->id_orcamento_status)
                                        @case(1)
                                        text-warning
                                            @break
                                        @case(2)
                                        text-info
                                            @break
                                        @case(3)
                                        text-success
                                            @break
                                        @case(4)
                                        text-danger
                                            @break
                                        @default
                                @endswitch">{{ $o->orcamento_status->status }}</td>
                            <td class="align-middle">{{ $o->tatuagem_nome }}</td>
                            <td class="align-middle">{{ $o->cliente->nome }}</td>
                            <td class="align-middle">{{ $o->artista->apelido }}</td>
                            @if ($o->created_at)
                            <td class="align-middle">{{ date_format($o->created_at, 'd/m/Y H:i') }}</td>
                            @else
                            <td class="align-middle"></td>
                            @endif
                            @if ($o->updated_at)
                            <td class="align-middle">{{ date_format($o->updated_at, 'd/m/Y H:i') }}</td>
                            @else
                            <td class="align-middle"></td>
                            @endif
                            <td class="align-middle">#{{ str_pad($o->id_orcamento, 5, '0', STR_PAD_LEFT) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Orçamento Show Modal -->
<div class="modal fade" id="orcamentoShowModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Visualizar orçamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Formulário -->
            <div class="modal-body">
                <form action="" method="GET">

                    <!-- Campo Status -->
                    <div class="form-group row">
                        <label class="col-form-label col-sm-5"><strong>Status:</strong></label>
                        <div class="col-sm-7">
                            <input id="orcamento_status" name="orcamento_status" class="form-control-plaintext"
                                readonly>
                        </div>
                    </div>

                    <!-- Campo Cliente -->
                    <div class="form-group row">
                        <label class="col-form-label col-sm-5"><strong>Cliente:</strong></label>
                        <div class="col-sm-7">
                            <input id="cliente" name="cliente" class="form-control-plaintext" readonly>
                        </div>
                    </div>

                    <!-- Campo Artista -->
                    <div class="form-group row">
                        <label class="col-form-label col-sm-5"><strong>Artista:</strong></label>
                        <div class="col-sm-7">
                            <input id="artista" name="artista" class="form-control-plaintext" readonly>
                        </div>
                    </div>

                    <!-- Campo Nome da Tatuagem -->
                    <div class="form-group row">
                        <label class="col-form-label col-sm-5"><strong>Nome da tatuagem:</strong></label>
                        <div class="col-sm-7">
                            <input id="tatuagem_nome" name="tatuagem_nome" class="form-control-plaintext" readonly>
                        </div>
                    </div>

                    <!-- Campo Local da Tatuagem -->
                    <div class="form-group row">
                        <label class="col-form-label col-sm-5"><strong>Local no corpo:</strong></label>
                        <div class="col-sm-7">
                            <input id="tatuagem_local" name="tatuagem_local" class="form-control-plaintext" readonly>
                        </div>
                    </div>

                    <!-- Campo Comprimento -->
                    <div class="form-group row">
                        <label class="col-form-label col-sm-5"><strong>Comprimento (em cm):</strong></label>
                        <div class="col-sm-7">
                            <input id="tatuagem_comprimento" name="tatuagem_comprimento" class="form-control-plaintext"
                                readonly>
                        </div>
                    </div>

                    <!-- Campo Largura -->
                    <div class="form-group row">
                        <label class="col-form-label col-sm-5"><strong>Largura (em cm):</strong></label>
                        <div class="col-sm-7">
                            <input id="tatuagem_largura" name="tatuagem_largura" class="form-control-plaintext"
                                readonly>
                        </div>
                    </div>

                    <!-- Campo Descrição -->
                    <div class="form-group row">
                        <label class="col-form-label col-sm-5"><strong>Descrição:</strong></label>
                        <div class="col-sm-7">
                            <textarea id="tatuagem_descricao" name="tatuagem_descricao" cols="30" rows="3"
                                class="form-control form-control-user" readonly></textarea>
                        </div>
                    </div>

                    <!-- Campo Referências -->
                    <div class="form-group row">
                        <label class="col-form-label col-sm-5"><strong>Referências:</strong></label>
                        <div class="col-sm-7">
                            <textarea id="tatuagem_referencias" name="tatuagem_referencias" cols="30" rows="3"
                                class="form-control form-control-user" readonly></textarea>
                        </div>
                    </div>

                    <!-- Campo Colorida -->
                    <div class="form-group row">
                        <label class="col-form-label col-sm-5"><strong>Colorida:</strong></label>
                        <div class="col-sm-7">
                            <input id="tatuagem_colorida" name="tatuagem_colorida" class="form-control-plaintext"
                                readonly>
                        </div>
                    </div>

                    <!-- Campo Autoral -->
                    <div class="form-group row">
                        <label class="col-form-label col-sm-5"><strong>Autoral:</strong></label>
                        <div class="col-sm-7">
                            <input id="tatuagem_autoral" name="tatuagem_autoral" class="form-control-plaintext"
                                readonly>
                        </div>
                    </div>

                    <!-- Campo Canal de Contato -->
                    <div class="form-group row">
                        <label class="col-form-label col-sm-5"><strong>Canal de contato:</strong></label>
                        <div class="col-sm-7">
                            <input id="canal_contato" name="canal_contato" class="form-control-plaintext" readonly>
                        </div>
                    </div>

                    <hr>

                    <!-- Botão Exibir orçamento -->
                    <div class="mb-3">
                        <a class="btn btn-outline-secondary btn-sm" data-toggle="collapse" href="#multiCollapseVinculo"
                            role="button" aria-expanded="false">
                            Exibir dados do orçamento
                        </a>
                    </div>

                    <div class="collapse multi-collapse" id="multiCollapseVinculo">

                        <!-- Campo Tempo Estimado -->
                        <div class="form-group row">
                            <label class="col-form-label col-sm-5"><strong>Tempo estimado:</strong></label>
                            <div class="col-sm-7">
                                <input id="tempo_estimado" type="text" name="tempo_estimado"
                                    class="form-control-plaintext" readonly>
                            </div>
                        </div>

                        <!-- Campo Valor -->
                        <div class="form-group row">
                            <label class="col-form-label col-sm-5"><strong>Valor:</strong></label>
                            <div class="col-sm-7">
                                <input id="valor" type="text" name="valor" class="form-control-plaintext" readonly>
                            </div>
                        </div>

                        <!-- Campo Uso de Materiais -->
                        <div class="form-group row">
                            <label class="col-form-label col-sm-5"><strong>Nível de materiais:</strong></label>
                            <div class="col-sm-7">
                                <input id="uso_materiais" type="text" name="uso_materiais"
                                    class="form-control-plaintext" readonly>
                            </div>
                        </div>

                        <!-- Campo Complexidade -->
                        <div class="form-group row">
                            <label class="col-form-label col-sm-5"><strong>Nível de complexidade:</strong></label>
                            <div class="col-sm-7">
                                <input id="complexidade" type="text" name="complexidade" class="form-control-plaintext"
                                    readonly>
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

<!-- Orçamento Delete Modal -->
<div class="modal fade" id="orcamentoDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="orcamentoDeleteModal">Excluir orçamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Mensagem de alerta -->
            <div class="modal-body">
                <span>Tem certeza que deseja <strong class="text-danger">excluir</strong> o orçamento abaixo?</span>
                <br>
                <label for="tatuagem_nome" class="mt-2">Tatuagem:</label>
                <input id="tatuagem_nome" class="form-control mt-1" type="text" readonly>
                <label for="cliente" class="mt-2">Cliente:</label>
                <input id="cliente" class="form-control mt-1" type="text" readonly>
                <label for="artista" class="mt-2">Artista:</label>
                <input id="artista" class="form-control mt-1" type="text" readonly>

                <span class="text-danger"><strong>Todos os agendamentos desse orçamento serão excluídos</strong></span>
            </div>

            <!-- Footer do Modal -->
            <div class="modal-footer">
                <form id="orcamentoDeleteForm" action="" method="POST">
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

<script>
    $('#orcamentoShowModal').on('show.bs.modal', function(e) {
        var link = $(e.relatedTarget)
        var tatuagem_nome = link.data('tatuagem_nome')
        var tatuagem_local = link.data('tatuagem_local')
        var tatuagem_comprimento = link.data('tatuagem_comprimento')
        var tatuagem_largura = link.data('tatuagem_largura')
        var tatuagem_descricao = link.data('tatuagem_descricao')
        var tatuagem_referencias = link.data('tatuagem_referencias')
        var tatuagem_colorida = link.data('tatuagem_colorida')
        var tatuagem_autoral = link.data('tatuagem_autoral')
        var valor = link.data('valor')
        var tempo_estimado = link.data('tempo_estimado')
        var canal_contato = link.data('canal_contato')
        var observacao = link.data('observacao')
        var cliente = link.data('cliente')
        var artista = link.data('artista')
        var uso_materiais = link.data('uso_materiais')
        var complexidade = link.data('complexidade')
        var orcamento_status = link.data('orcamento_status')

        var modal = $(this)

        modal.find(".modal-body #tatuagem_nome").val(tatuagem_nome);
        modal.find(".modal-body #tatuagem_local").val(tatuagem_local);
        modal.find(".modal-body #tatuagem_comprimento").val(tatuagem_comprimento);
        modal.find(".modal-body #tatuagem_largura").val(tatuagem_largura);
        modal.find(".modal-body #tatuagem_descricao").val(tatuagem_descricao);
        modal.find(".modal-body #tatuagem_referencias").val(tatuagem_referencias);
        modal.find(".modal-body #valor").val(valor);
        modal.find(".modal-body #tempo_estimado").val(tempo_estimado);
        modal.find(".modal-body #canal_contato").val(canal_contato);
        modal.find(".modal-body #observacao").val(observacao);
        modal.find(".modal-body #cliente").val(cliente);
        modal.find(".modal-body #artista").val(artista);
        modal.find(".modal-body #uso_materiais").val(uso_materiais);
        modal.find(".modal-body #complexidade").val(complexidade);
        modal.find(".modal-body #orcamento_status").val(orcamento_status);

        if(tatuagem_colorida == '1') 
        {
            modal.find(".modal-body #tatuagem_colorida").val("Sim");
        } 
        else 
        {
            modal.find(".modal-body #tatuagem_colorida").val("Não");
        }

        if(tatuagem_autoral == '1')
        {
            modal.find(".modal-body #tatuagem_autoral").val("Sim");
        } 
        else 
        {
            modal.find(".modal-body #tatuagem_autoral").val("Não");
        }
    });
</script>

<script>
    $('#orcamentoDeleteModal').on('show.bs.modal', function(e) {
        var link = $(e.relatedTarget)
        var tatuagem_nome = link.data('tatuagem_nome')
        var cliente = link.data('cliente')
        var artista = link.data('artista')
        var url = link.data('url')

        var modal = $(this)

        modal.find(".modal-body #tatuagem_nome").val(tatuagem_nome);
        modal.find(".modal-body #cliente").val(cliente);
        modal.find(".modal-body #artista").val(artista);

        $('#orcamentoDeleteForm').attr("action", url)
    });
</script>

@endsection