@extends('layouts.admin')

@section('styles')
<!-- Styles -->
@endsection

@section('content')
<div class="container-fluid">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.clientes.index') }}">Clientes</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar Cliente</li>
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
                                    <h1 class="h4 text-gray-900 mb-4">Edite os dados do cliente abaixo</h1>
                                </div>

                                <!-- Formulário -->
                                <form method="POST" class="user"
                                    action="{{ route('admin.clientes.update', ['cliente' => $cliente->id_cliente]) }}">
                                    @csrf
                                    @method('PUT')

                                    <!-- Campo Nome -->
                                    <div class="form-group">
                                        <label for="">Nome*</label>
                                        <input type="text" name="nome"
                                            class="form-control form-control-user @error('nome') is-invalid @enderror"
                                            id="clienteNome" placeholder="Nome" 
                                            @if(Request::old('nome')) value="{{ old('nome') }}"
                                            @else value="{{ $cliente->nome }}" 
                                            @endif
                                            maxlength="60" required>
                                        @error('nome')
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
                                            id="clienteEmail" placeholder="cliente@email.com.br"
                                            @if(Request::old('email')) value="{{ old('email') }}"
                                            @else value="{{ $cliente->email }}" 
                                            @endif maxlength="60" required>
                                        @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Campo Telefone -->
                                    <div class="form-group">
                                        <label for="">Telefone*</label>
                                        <input type="text" name="telefone"
                                            class="form-control form-control-user @error('telefone') is-invalid @enderror"
                                            id="clienteTelefone" placeholder="(42) 99999-9999"
                                            @if(Request::old('telefone')) value="{{ old('telefone') }}"
                                            @else value="{{ $cliente->telefone }}" 
                                            @endif required>
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
                                            id="clienteDataNascimento" 
                                            @if(Request::old('data_nascimento')) value="{{ old('data_nascimento') }}"
                                            @elseif ($cliente->data_nascimento)
                                            value="{{ date_format($cliente->data_nascimento, 'Y-m-d') }}"
                                            @else value="" @endif>
                                        @error('data_nascimento')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Campo Apelido -->
                                    <div class="form-group">
                                        <label for="">Apelido</label>
                                        <input type="text" name="apelido"
                                            class="form-control form-control-user @error('apelido') is-invalid @enderror"
                                            id="clienteApelido" placeholder="Apelido" 
                                            @if(Request::old('apelido')) value="{{ old('apelido') }}"
                                            @else value="{{ $cliente->apelido }}" 
                                            @endif
                                            maxlength="60">
                                        @error('apelido')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Campo Observação -->
                                    <div class="form-group">
                                        <label for="">Observação</label>
                                        <input type="text" name="observacao"
                                            class="form-control form-control-user @error('observacao') is-invalid @enderror"
                                            id="clienteObservacao" placeholder="Observação"
                                            @if(Request::old('observacao')) value="{{ old('observacao') }}"
                                            @else value="{{ $cliente->observacao }}" 
                                            @endif maxlength="255">
                                        @error('observacao')
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
                                                value="1" @if($cliente_estudio->ativo != 0) checked @endif>
                                            <label class="form-check-label" for="ativo">
                                                Ativo
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Botão de envio -->
                                    <button type="submit" class="btn btn-success btn-user btn-block">Salvar</button>

                                </form>
                            </div>
                        </div>
                        
                        <!-- Ilustração -->
                        <div class="col-lg-6 d-none d-lg-block bg-edit-cliente-image"></div>

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

<!-- Máscara para o campo telefone -->
<script>
    $(document).ready(function() {
        $(clienteTelefone).inputmask({
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