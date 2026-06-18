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
            <li class="breadcrumb-item active" aria-current="page">Cadastrar Orçamento</li>
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
                                    <h1 class="h4 text-gray-900 mb-4">Insira abaixo os dados da solicitação</h1>
                                </div>
                                
                                <!-- Formulário -->
                                <form class="user" action="{{ route('admin.orcamentos.store') }}" method="POST">
                                    @csrf

                                    <!-- Campo Cliente -->
                                    <div class="form-group">
                                        <label for="clienteNome">Cliente*</label>
                                        <select class="custom-select @error('cliente') is-invalid @enderror"
                                            name="cliente" required>
                                            <option value="">Selecione um cliente...</option>
                                            @foreach ($clientes as $c)
                                            <option value="{{ $c->id_cliente }}"
                                                {{ (Request::old("cliente") == $c->id_cliente ? "selected" : "") }}>
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
                                    <div class="form-group">
                                        <label for="artistaNome">Artista*</label>
                                        <select class="custom-select @error('artista') is-invalid @enderror"
                                            name="artista" required>
                                            <option value="">Selecione um artista...</option>
                                            @foreach ($artistas as $a)
                                            <option value="{{ $a->id_artista }}"
                                                {{ (Request::old("artista") == $a->id_artista ? "selected" : "") }}>
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
                                            value="{{ old('tatuagem_nome') }}" maxlength="60" required>
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
                                            value="{{ old('tatuagem_local') }}" maxlength="60" required>
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
                                                id="tatuagemComprimento" value="{{ old('tatuagem_comprimento') }}"
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
                                                id="tatuagemLargura" value="{{ old('tatuagem_largura') }}" step=".01"
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
                                            maxlength="255" required>{{ old('tatuagem_descricao') }}</textarea>
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
                                            maxlength="65535">{{ old('tatuagem_referencias') }}</textarea>
                                        @error('tatuagem_referencias')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Campo Colorida -->
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="tatuagem_colorida"
                                                id="tatuagemColorida" value="1"
                                                {{ (Request::old("tatuagem_colorida") ? "checked" : "") }}>
                                            <label class="form-check-label" for="tatuagemColorida">
                                                Colorida
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Campo Autoral -->
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="tatuagem_autoral"
                                                id="tatuagemAutoral" value="1"
                                                {{ (Request::old("tatuagem_autoral") ? "checked" : "") }}>
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
                                            value="{{ old('canal_contato') }}" maxlength="20">
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
                                                value="{{ old('tempo_estimado') }}">
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
                                                value="{{ old('valor') }}">
                                            @error('valor')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <!-- Campo Uso de Materiais -->
                                        <div class="form-group">
                                            <label for="usoMateriais">Nível de uso de materiais</label>
                                            <select class="custom-select @error('uso_materiais') is-invalid @enderror"
                                                name="uso_materiais">
                                                <option value="">Selecione um nível...</option>
                                                @foreach ($uso_materiais as $u)
                                                <option value="{{ $u->id_uso_materiais }}"
                                                    {{ (Request::old("uso_materiais") == $u->id_uso_materiais ? "selected" : "") }}>
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
                                        <div class="form-group">
                                            <label for="complexidade">Nível de complexidade</label>
                                            <select class="custom-select @error('complexidade') is-invalid @enderror"
                                                name="complexidade">
                                                <option value="">Selecione um nível...</option>
                                                @foreach ($complexidade as $c)
                                                <option value="{{ $c->id_complexidade }}"
                                                    {{ (Request::old("complexidade") == $c->id_complexidade ? "selected" : "") }}>
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
                                                maxlength="255">{{ old('observacao') }}</textarea>
                                            @error('observacao')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Botão de envio -->
                                    <button type="submit" class="btn btn-success btn-user btn-block">Cadastrar</button>

                                </form>
                            </div>
                        </div>
                        
                        <!-- Ilustração -->
                        <div class="col-lg-6 d-none d-lg-block bg-create-orcamento-image"></div>

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