@extends('layouts.admin')

@section('styles')
<!-- Styles -->
@endsection

@section('content')
<div class="container-fluid">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.orcamentos.index') }}">Orçamentos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar Orçamento</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-xl-12 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-2">
                <div class="card-body p-0">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Edite os dados do orçamento abaixo</h1>
                                </div>

                                <!-- Formulário -->
                                <form method="POST" class="user"
                                    action="{{ route('admin.orcamentos.update', ['orcamento' => $orcamento->id_orcamento]) }}">
                                    @csrf
                                    @method('PUT')

                                    <!-- Campo Cliente -->
                                    @php $cliente_old = false; @endphp
                                    <div class="form-group">
                                        <label for="clienteNome">Cliente*</label>
                                        <select class="custom-select @error('cliente') is-invalid @enderror"
                                            name="cliente" required>
                                            <option value="">Selecione um cliente...</option>
                                            @foreach ($clientes as $c)
                                            <option value="{{ $c->id_cliente }}"
                                                @if(Request::old('cliente')==$c->id_cliente)
                                                {
                                                    selected
                                                    @php $cliente_old = true @endphp
                                                }
                                                @elseif($orcamento->cliente->id_cliente == $c->id_cliente &&
                                                !$cliente_old) selected
                                                @endif>
                                                {{ $c->nome }}
                                                @if($c->apelido)"{{ $c->apelido }}"@endif</option>
                                            @endforeach
                                        </select>
                                        @error('cliente')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Campo Artista -->
                                    @php $artista_old = false; @endphp
                                    <div class="form-group">
                                        <label for="artistaNome">Artista*</label>
                                        <select class="custom-select @error('artista') is-invalid @enderror"
                                            name="artista" required>
                                            <option value="">Selecione um artista...</option>
                                            @foreach ($artistas as $a)
                                            <option value="{{ $a->id_artista }}"
                                                @if(Request::old('artista')==$a->id_artista)
                                                {
                                                    selected
                                                    @php $artista_old = true @endphp
                                                }
                                                @elseif($orcamento->artista->id_artista == $a->id_artista && !$artista_old) selected
                                                @endif>
                                                {{ $a->nome }}
                                                "{{ $a->apelido }}"</option>
                                            @endforeach
                                        </select>
                                        @error('artista')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Campo Nome da Tatuagem -->
                                    <div class="form-group">
                                        <label for="tatuagemNome">Nome da tatuagem*</label>
                                        <input type="text" name="tatuagem_nome"
                                            class="form-control @error('tatuagem_nome') is-invalid @enderror"
                                            id="tatuagemNome" placeholder="Exemplo: Rosa dos ventos"
                                            @if(Request::old('tatuagem_nome')) value="{{ old('tatuagem_nome') }}" @else
                                            value="{{ $orcamento->tatuagem_nome }}" @endif
                                            maxlength="60" required>
                                        @error('tatuagem_nome')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Campo Local da Tatuagem -->
                                    <div class="form-group">
                                        <label for="tatuagemLocal">Local no corpo*</label>
                                        <input type="text" name="tatuagem_local"
                                            class="form-control @error('tatuagem_local') is-invalid @enderror"
                                            id="tatuagemLocal" placeholder="Exemplo: Antebraço esquerdo"
                                            @if(Request::old('tatuagem_local')) value="{{ old('tatuagem_local') }}"
                                            @else value="{{ $orcamento->tatuagem_local }}" @endif
                                            maxlength="60" required>
                                        @error('tatuagem_local')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <!-- Campo Comprimento -->
                                        <div class="form-group col">
                                            <label for="tatuagemComprimento">Comprimento (em cm)*</label>
                                            <input type="number" name="tatuagem_comprimento"
                                                class="form-control @error('tatuagem_comprimento') is-invalid @enderror"
                                                id="tatuagemComprimento"
                                                @if(Request::old('tatuagem_comprimento')) value="{{ old('tatuagem_comprimento') }}"
                                                @else value="{{ $orcamento->tatuagem_comprimento }}" @endif
                                                step=".01" min="0" max="200" required>
                                            @error('tatuagem_comprimento')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <!-- Campo Largura -->
                                        <div class="form-group col">
                                            <label for="tatuagemLargura">Largura (em cm)*</label>
                                            <input type="number" name="tatuagem_largura"
                                                class="form-control @error('tatuagem_largura') is-invalid @enderror"
                                                id="tatuagemLargura"
                                                @if(Request::old('tatuagem_largura')) value="{{ old('tatuagem_largura') }}"
                                                @else value="{{ $orcamento->tatuagem_largura }}" @endif step=".01"
                                                min="0" max="200" required>
                                            @error('tatuagem_largura')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Campo Descrição -->
                                    <div class="form-group">
                                        <label for="tatuagemDescricao">Descrição da tatuagem*</label>
                                        <textarea name="tatuagem_descricao" id="tatuagemDescricao"
                                            class="form-control @error('tatuagem_descricao') is-invalid @enderror"
                                            cols="30" rows="5"
                                            placeholder="Exemplo: Rosa dos ventos em blackwork com traço fino no antebraço esquerdo"
                                            maxlength="255" required>@if(Request::old('tatuagem_descricao')){{ old('tatuagem_descricao') }}@else{{ $orcamento->tatuagem_descricao }}@endif</textarea>
                                        @error('tatuagem_descricao')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Campo Referências -->
                                    <div class="form-group">
                                        <label for="tatuagemReferencias">Referências da tatuagem</label>
                                        <textarea name="tatuagem_referencias" id="tatuagemReferencias"
                                            class="form-control @error('tatuagem_referencias') is-invalid @enderror"
                                            cols="30" rows="5"
                                            placeholder="Exemplo: pinterest.com/rosa-dos-ventos-tattoo"
                                            maxlength="65535">@if(Request::old('tatuagem_referencias')){{ old('tatuagem_referencias') }}@else{{ $orcamento->tatuagem_referencias }}@endif</textarea>
                                        @error('tatuagem_referencias')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Campo Colorida -->
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input type="hidden" name="tatuagem_colorida" value="0">
                                            <input class="form-check-input" type="checkbox" name="tatuagem_colorida"
                                                id="tatuagemColorida" value="1"
                                                @if(Request::old('tatuagem_colorida')) checked
                                                @elseif($orcamento->tatuagem_colorida) checked
                                                @endif>
                                            <label class="form-check-label" for="tatuagemColorida">
                                                Colorida
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Campo Autoral -->
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input type="hidden" name="tatuagem_autoral" value="0">
                                            <input class="form-check-input" type="checkbox" name="tatuagem_autoral"
                                                id="tatuagemAutoral" value="1"
                                                @if(Request::old('tatuagem_autoral')) checked
                                                @elseif($orcamento->tatuagem_autoral) checked
                                                @endif>
                                            <label class="form-check-label" for="tatuagemAutoral">
                                                Autoral
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Campo Canal de Contato -->
                                    <div class="form-group">
                                        <label for="canalContato">Canal de contato</label>
                                        <input type="text" name="canal_contato"
                                            class="form-control @error('canal_contato') is-invalid @enderror"
                                            id="canalContato" placeholder="Exemplo: WhatsApp"
                                            @if(Request::old('canal_contato')) value="{{ old('canal_contato') }}"
                                                @else value="{{ $orcamento->canal_contato }}" @endif maxlength="20">
                                        @error('canal_contato')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Verificação de erros -->
                                    @if ($errors->has('valor') or $errors->has('tempo_estimado') or
                                    $errors->has('uso_materiais') or $errors->has('complexidade') or
                                    $errors->has('observacao'))
                                    <!-- Botão Exibir Orçamento (com erros) -->
                                    <div class="mb-3">
                                        <a class="btn btn-outline-danger btn-sm" data-toggle="collapse"
                                            href="#multiCollapseOrcamento" role="button" aria-expanded="false">
                                            Exibir campos do orçamento
                                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                    @else
                                    <!-- Botão Exibir Orçamento (sem erros) -->
                                    <div class="mb-3">
                                        <a class="btn btn-outline-secondary btn-sm" data-toggle="collapse"
                                            href="#multiCollapseOrcamento" role="button" aria-expanded="false">
                                            Exibir campos do orçamento
                                        </a>
                                    </div>
                                    @endif

                                    <div class="collapse multi-collapse" id="multiCollapseOrcamento">

                                        <hr class="mt-4">

                                        <div class="text-center mt-4">
                                            <h1 class="h4 text-gray-900 mb-4">Insira abaixo os dados do orçamento</h1>
                                        </div>

                                        <!-- Campo Tempo para Execução -->
                                        <div class="form-group">
                                            <label for="tempoEstimado">Tempo estimado para execução (hh:mm)</label>
                                            <input type="text" name="tempo_estimado" id="tempoEstimado"
                                                class="form-control @error('tempo_estimado') is-invalid @enderror"
                                                @if(Request::old('tempo_estimado')) value="{{ old('tempo_estimado') }}"
                                                @else value="{{ $orcamento->tempo_estimado }}" @endif>
                                            @error('tempo_estimado')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <!-- Campo Valor -->
                                        <div class="form-group">
                                            <label for="valor">Valor do orçamento</label>
                                            <input type="text" name="valor"
                                                class="form-control @error('valor') is-invalid @enderror" id="valor"
                                                @if(Request::old('valor')) value="{{ old('valor') }}"
                                                @elseif($orcamento->valor) value="{{ number_format($orcamento->valor, 2, ',', '.') }}"
                                                @else value=""
                                                @endif>
                                            @error('valor')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <!-- Campo Uso de Materiais -->
                                        @php $uso_materiais_old = false; @endphp
                                        <div class="form-group">
                                            <label for="usoMateriais">Nível de uso de materiais</label>
                                            <select class="custom-select @error('uso_materiais') is-invalid @enderror"
                                                name="uso_materiais">
                                                <option value="">Selecione um nível...</option>
                                                @foreach ($uso_materiais as $u)
                                                <option value="{{ $u->id_uso_materiais }}"
                                                    @if(Request::old('uso_materiais') == $u->id_uso_materiais)
                                                    {
                                                        selected
                                                        @php $uso_materiais_old = true; @endphp
                                                    }
                                                    @elseif($orcamento->uso_materiais) {
                                                        @if($orcamento->uso_materiais->id_uso_materiais == $u->id_uso_materiais && !$uso_materiais_old) selected @endif
                                                    }
                                                    @endif>
                                                    {{ $u->nivel }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('uso_materiais')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <!-- Campo Complexidade -->
                                        @php $complexidade_old = false; @endphp
                                        <div class="form-group">
                                            <label for="complexidade">Nível de complexidade</label>
                                            <select class="custom-select @error('complexidade') is-invalid @enderror"
                                                name="complexidade">
                                                <option value="">Selecione um nível...</option>
                                                @foreach ($complexidade as $c)
                                                <option value="{{ $c->id_complexidade }}"
                                                    @if(Request::old('complexidade') == $c->id_complexidade)
                                                    {
                                                        selected
                                                        @php $complexidade_old = true; @endphp
                                                    }
                                                    @elseif($orcamento->uso_materiais) {
                                                        @if($orcamento->complexidade->id_complexidade == $c->id_complexidade && !$complexidade_old) selected @endif
                                                    }
                                                    @endif>
                                                    {{ $c->nivel }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('complexidade')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <!-- Campo Observações -->
                                        <div class="form-group">
                                            <label for="observacao">Observações</label>
                                            <textarea name="observacao" id="observacao"
                                                class="form-control @error('observacao') is-invalid @enderror" cols="30"
                                                rows="5"
                                                placeholder="Exemplo: Custo extra por conta de área do corpo sensível à agulha"
                                                maxlength="255">@if(Request::old('observacao')){{ old('observacao') }}@else{{ $orcamento->observacao }}@endif</textarea>
                                            @error('observacao')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Botão de envio -->
                                    <button type="submit" class="btn btn-success btn-user btn-block">Salvar</button>

                                </form>
                            </div>
                        </div>

                        <!-- Ilustração -->
                        <div class="col-lg-6 d-none d-lg-block bg-edit-orcamento-image"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<!-- Input Mask Plugin -->
<script src="{{ asset('vendor/inputmask/dist/jquery.inputmask.js') }}"></script>

<!-- Money Mask Plugin -->
<script src="{{ asset('/vendor/mask-money/dist/jquery.maskMoney.js') }}"></script>

<!-- Máscara para o campo Tempo Estimado -->
<script>
    $(document).ready(function() {
        $(tempoEstimado).inputmask({
            "regex": "^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$"
        });
    });
</script>

<!-- Máscara para o campo Valor -->
<script>
    $("#valor").maskMoney({affixesStay: false, thousands: ".", decimal: ",", prefix: "R$ ", allowZero: true});
</script>

<!-- Toastr para erros no formulário -->
@if (Session::has('errors'))
<script>
    toastr.options.positionClass = 'toast-top-center';
    toastr.options.showMethod = 'slideDown';
    toastr.warning("O formulário contém campos que precisam ser revisados!");
</script>
@endif

@endsection
