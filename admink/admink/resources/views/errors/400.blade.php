@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">

    <div class="text-center">
        <div class="error mx-auto" data-text="400">400</div>
        <p class="lead text-gray-800 mb-5">Erro HTTP: bad request</p>
        <p class="text-gray-500 mb-0">A rota inserida na URL é inválida</p>
        <a class="btn btn-outline-secondary mt-3 mb-3" href="{{ route('admin.home') }}">&larr; Voltar para a home do
            Admink
        </a>
        <p>
            <a class="text-gray-800" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
                aria-controls="collapseExample">
                Detalhes
            </a>
        </p>
        <div class="collapse" id="collapseExample">
            <div class="row">
                <div class="col-4"></div>
                <div class="card card-body col-4 justify-content-md-center">
                    @if($exception->getMessage())
                    {{ $exception->getMessage() }}
                    @else Não há detalhes para exibir.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection