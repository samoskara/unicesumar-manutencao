@extends('layouts.app')

@section('content')
<body class="bg-gradient-dark">
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">

                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-login-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Crie uma conta!</h1>
                            </div>
                            <form method="POST" action="{{ route('register') }}" class="user">
                                @csrf
                                <!-- Campo para inserir nome -->
                                <div class="form-group">
                                    <label for="exampleFirstName"
                                        class="col-form-label text-md-right">{{ __('Nome') }}</label>
                                    <input type="text" name="name"
                                        class="form-control form-control-user @error('name') is-invalid @enderror"
                                        id="exampleFirstName" value="{{ old('name') }}" required autocomplete="name"
                                        autofocus placeholder="Nome">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <!-- Campo para inserir email -->
                                <div class="form-group">
                                    <label for="exampleInputEmail"
                                        class="col-form-label text-md-right">{{ __('Email') }}</label>
                                    <input type="email" name="email"
                                        class="form-control form-control-user @error('email') is-invalid @enderror"
                                        id="exampleInputEmail" value="{{ old('email') }}" required autocomplete="email"
                                        placeholder="Insira seu email...">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <!-- Campo para inserir senha -->
                                <div class="form-group">
                                    <label for="exampleInputPassword"
                                        class="col-form-label text-md-right">{{ __('Senha') }}</label>

                                    <input type="password" name="password"
                                        class="form-control form-control-user @error('password') is-invalid @enderror"
                                        id="exampleInputPassword" required autocomplete="new-password"
                                        placeholder="Senha">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <!-- Campo para confirmar senha -->
                                <div class="form-group">
                                    <label for="exampleRepeatPassword"
                                        class="col-form-label text-md-right">{{ __('Confirme a senha') }}</label>
                                    <input type="password" name="password_confirmation"
                                        class="form-control form-control-user" id="exampleRepeatPassword" required
                                        autocomplete="new-password" placeholder="Confirme a senha">
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Criar conta
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

@endsection