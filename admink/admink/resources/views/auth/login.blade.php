@extends('layouts.app')

@section('content')
<body class="bg-gradient-dark">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">

                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Seja bem-vindo!</h1>
                                    </div>
                                    
                                    <!-- Formulário -->
                                    <form method="POST" action="{{ route('login') }}" class="user">
                                        @csrf

                                        <!-- Campo Email -->
                                        <div class="form-group">
                                            <label for="exampleInputEmail"
                                                class="col-form-label text-md-right">{{ __('Email') }}</label>
                                            <input type="email" name="email"
                                                class="form-control form-control-user @error('email') is-invalid @enderror"
                                                value="{{ old('email') }}" required autocomplete="email" autofocus
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Insira seu email...">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        
                                        <!-- Campo Senha -->
                                        <div class="form-group">
                                            <label for="exampleInputPassword"
                                                class="col-form-label text-md-right">{{ __('Senha') }}</label>
                                            <input type="password" name="password"
                                                class="form-control form-control-user @error('password') is-invalid @enderror"
                                                required autocomplete="current-password" id="exampleInputPassword"
                                                placeholder="Senha">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        {{-- <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" name="remember" class="custom-control-input"
                                                    id="customCheck" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="customCheck">Lembre minha
                                                    senha</label>
                                            </div>
                                        </div> --}}

                                        <hr>

                                        <!-- Botão de envio -->
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>

                                    {{-- <hr>
                                    <div class="text-center">
                                        @if (Route::has('password.request'))
                                        <a class="small" href="{{ route('password.request') }}">Esqueceu sua senha?</a>
                                    @endif
                                </div>
                                <div class="text-center">
                                    <a class="small" href="{{ route('register') }}">Crie uma conta!</a>
                                </div> --}}
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

@endsection