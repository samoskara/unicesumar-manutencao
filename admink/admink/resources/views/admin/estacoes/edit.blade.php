@extends('layouts.admin')

@section('styles')
<!-- Styles -->
@endsection

@section('content')
<div class="container-fluid">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.estacoes.index') }}">Estações</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar Estação</li>
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
                                    <h1 class="h4 text-gray-900 mb-4">Edite os dados da estação abaixo</h1>
                                </div>

                                <!-- Formulário -->
                                <form method="POST" class="user"
                                    action="{{ route('admin.estacoes.update', ['estacao' => $estacao->id_estacao]) }}">
                                    @csrf
                                    @method('PUT')

                                    <!-- Campo Identificação -->
                                    <div class="form-group">
                                        <label for="">Identificação*</label>
                                        <input type="text" name="identificacao"
                                            class="form-control form-control-user @error('identificacao') is-invalid @enderror"
                                            id="estacaoIdentificacao" placeholder="Identificação"
                                            @if(Request::old('identificacao')) value="{{ old('identificacao') }}" 
                                            @else value="{{ $estacao->identificacao }}" @endif maxlength="20" required>
                                        @error('identificacao')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Campo Ativa -->
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input type="hidden" name="ativa" value="0">
                                            <input class="form-check-input" type="checkbox" name="ativa" id="ativa"
                                                value="1" @if($estacao->ativa != 0) checked @endif>
                                            <label class="form-check-label" for="ativa">
                                                Ativa
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Botão de envio -->
                                    <button type="submit" class="btn btn-success btn-user btn-block">Salvar</button>
                                </form>
                            </div>
                        </div>

                        <!-- Botão de envio -->
                        <div class="col-lg-6 d-none d-lg-block bg-edit-estacao-image"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<!-- Toastr para erros no formulário -->
@if (Session::has('errors'))
<script>
    toastr.options.positionClass = 'toast-top-center';
    toastr.options.showMethod = 'slideDown';
    toastr.warning("O formulário contém campos que precisam ser revisados!");
</script>
@endif

@endsection