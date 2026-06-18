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
            <li class="breadcrumb-item active" aria-current="page">Cadastrar Artista</li>
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
                                    <h1 class="h4 text-gray-900 mb-4">Insira abaixo os dados do artista</h1>
                                </div>

                                <!-- Formulário -->
                                <form class="user" action="{{ route('admin.artistas.store') }}" method="POST">
                                    @csrf

                                    <!-- Campo Nome -->
                                    <div class="form-group">
                                        <label for="artistaNome">Nome*</label>
                                        <input type="text" name="nome"
                                            class="form-control form-control-user @error('nome') is-invalid @enderror"
                                            id="artistaNome" placeholder="Nome" value="{{ old('nome') }}" maxlength="60"
                                            required>
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
                                            id="artistaApelido" placeholder="Apelido" value="{{ old('apelido') }}"
                                            maxlength="60" required>
                                        @error('apelido')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Campo Email -->
                                    <div class="form-group">
                                        <label for="artistaEmail">Email*</label>
                                        <input type="email" name="email"
                                            class="form-control form-control-user @error('email') is-invalid @enderror"
                                            id="artistaEmail" placeholder="artista@email.com.br"
                                            value="{{ old('email') }}" maxlength="60" required>
                                        @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Campo Telefone -->
                                    <div class="form-group">
                                        <label for="artistaTelefone">Telefone (Celular)*</label>
                                        <input type="text" name="telefone"
                                            class="form-control form-control-user @error('telefone') is-invalid @enderror"
                                            id="artistaTelefone" placeholder="(42) 99999-9999"
                                            value="{{ old('telefone') }}" maxlength="15" required>
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
                                            id="artistaDataNascimento" value="{{ old('data_nascimento') }}">
                                        @error('data_nascimento')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Botão de envio -->
                                    <button type="submit" class="btn btn-success btn-user btn-block">Cadastrar</button>

                                </form>
                            </div>
                        </div>

                        <!-- Ilustração -->
                        <div class="col-lg-6 d-none d-lg-block bg-create-artista-image"></div>
                        
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