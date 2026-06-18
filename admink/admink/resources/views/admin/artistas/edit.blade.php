@extends('layouts.admin')

@section('styles')
<!-- Styles -->
@endsection

@section('content')
<div class="container-fluid">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.artistas.index') }}">Artistas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar Artista</li>
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
                                    <h1 class="h4 text-gray-900 mb-4">Edite os dados do artista abaixo</h1>
                                </div>

                                <!-- Formulário -->
                                <form method="POST" class="user"
                                    action="{{ route('admin.artistas.update', ['artista' => $artista->id_artista]) }}">
                                    @csrf
                                    @method('PUT')

                                    <!-- Campo Nome -->
                                    <div class="form-group">
                                        <label for="">Nome*</label>
                                        <input type="text" name="nome"
                                            class="form-control form-control-user @error('nome') is-invalid @enderror"
                                            id="artistaNome" placeholder="Nome"
                                            @if(Request::old('nome')) value="{{ old('nome') }}"
                                            @else value="{{ $artista->nome }}" @endif
                                            maxlength="60" required>
                                        @error('nome')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Campo Apelido -->
                                    <div class="form-group">
                                        <label for="">Apelido*</label>
                                        <input type="text" name="apelido"
                                            class="form-control form-control-user @error('apelido') is-invalid @enderror"
                                            id="artistaApelido" placeholder="Apelido"
                                            @if(Request::old('apelido')) value="{{ old('apelido') }}"
                                            @else value="{{ $artista->apelido }}" @endif
                                            maxlength="60" required>
                                        @error('apelido')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Campo Email -->
                                    <div class="form-group">
                                        <label for="">Email*</label>
                                        <input type="email" name="email"
                                            class="form-control form-control-user @error('email') is-invalid @enderror"
                                            id="artistaEmail" placeholder="artista@email.com.br"
                                            @if(Request::old('email')) value="{{ old('email') }}"
                                            @else value="{{ $artista->email }}" @endif maxlength="60" required>
                                        @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Campo Telefone -->
                                    <div class="form-group">
                                        <label for="">Telefone (Celular)*</label>
                                        <input type="text" name="telefone"
                                            class="form-control form-control-user @error('telefone') is-invalid @enderror"
                                            id="artistaTelefone" placeholder="(42) 99999-9999"
                                            @if(Request::old('telefone')) value="{{ old('telefone') }}"
                                            @else value="{{ $artista->telefone }}" @endif required>
                                        @error('telefone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Campo Data de Nascimento -->
                                    <div class="form-group">
                                        <label for="">Data de Nascimento</label>
                                        <input type="date" name="data_nascimento"
                                            class="form-control form-control-user @error('data_nascimento') is-invalid @enderror"
                                            id="artistaDataNascimento"
                                            @if(Request::old('data_nascimento')) value="{{ old('data_nascimento') }}"
                                            @elseif ($artista->data_nascimento) value="{{ date_format($artista->data_nascimento, 'Y-m-d') }}"
                                            @else value=""
                                            @endif>
                                        @error('data_nascimento')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Editar vínculo com estúdio -->
                                    <hr>
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Edite o vínculo do artista com o estúdio</h1>
                                    </div>

                                    <!-- Campo Data de Início -->
                                    <div class="form-group">
                                        <label for="">Data de Início</label>
                                        <input type="date" name="data_inicio"
                                            class="form-control form-control-user @error('data_inicio') is-invalid @enderror"
                                            id="artistaDataInício"
                                            @if(Request::old('data_inicio')) value="{{ old('data_inicio') }}"
                                            @elseif ($artista_estudio->data_inicio)
                                        value="{{ date_format($artista_estudio->data_inicio, 'Y-m-d') }}"
                                        @else
                                        value="" @endif>
                                        @error('data_inicio')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Campo Data de Fim -->
                                    <div class="form-group">
                                        <label for="">Data de Fim</label>
                                        <input type="date" name="data_fim"
                                            class="form-control form-control-user @error('data_fim') is-invalid @enderror"
                                            id="artistaDataFim"
                                            @if(Request::old('data_fim')) value="{{ old('data_fim') }}"
                                            @elseif ($artista_estudio->data_fim)
                                        value="{{ date_format($artista_estudio->data_fim, 'Y-m-d') }}"
                                        @else
                                        value="" @endif>
                                        @error('data_fim')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Campo Ativo -->
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input type="hidden" name="ativo" value="0">
                                            <input class="form-check-input" type="checkbox" name="ativo" id="ativo"
                                                value="1"
                                                @if(Request::old('ativo')) checked
                                                @elseif($artista_estudio->ativo) checked
                                                @endif>
                                            <label class="form-check-label" for="ativo">
                                                Ativo
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Campo Visitante -->
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input type="hidden" name="visitante" value="0">
                                            <input class="form-check-input" type="checkbox" name="visitante"
                                                id="visitante" value="1"
                                                @if(Request::old('visitante')) checked
<<<<<<< HEAD
                                                @elseif($artista->visitante != 0) checked
=======
                                                @elseif($artista_estudio->visitante) checked
>>>>>>> 888b0a5f3282a12b2ddd90eac233f807dccc2628
                                                @endif>
                                            <label class="form-check-label" for="visitante">
                                                Visitante
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Botão de envio -->
                                    <button type="submit" class="btn btn-success btn-user btn-block">Salvar</button>

                                </form>
                            </div>
                        </div>

                        <!-- Ilustração -->
                        <div class="col-lg-6 d-none d-lg-block bg-edit-artista-image"></div>

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

<!-- Máscara para o campo Telefone -->
<script>
    $(document).ready(function() {
        $(artistaTelefone).inputmask({
            "mask": "(99) 99999-9999"
        });
    });
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
