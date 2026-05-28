@extends('layouts.admin')

@section('styles')
<!-- Styles -->
@endsection

@section('content')
<div class="container-fluid">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.agendamentos.index') }}">Agendamentos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cadastrar Agendamento</li>
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
                                    <h1 class="h4 text-gray-900 mb-4">Insira abaixo os dados do agendamento</h1>
                                </div>
                                
                                <!-- Formulário -->
                                <form class="user" action="{{ route('admin.agendamentos.store') }}" method="POST">
                                    @csrf

                                    <!-- Campo Orçamento -->
                                    <div class="form-group">
                                        <label for="orcamento">Orçamento* (Tattoo | Cliente | Artista | Tempo estimado)</label>
                                        <select class="custom-select @error('orcamento') is-invalid @enderror"
                                            name="orcamento" id="orcamento" required>
                                            <option value="">Selecione um orçamento...</option>
                                            @foreach ($orcamentos as $o)
                                            <option value="{{ $o->id_orcamento }}" 
                                                @if($o_selected){
                                                    @if ($o_selected == $o->id_orcamento) selected @endif
                                                }
                                                @endif
                                                {{ (Request::old("orcamento") == $o->id_orcamento ? "selected" : "") }}>
                                                {{ $o->tatuagem_nome }} | {{ $o->cliente->nome }} | {{ $o->artista->apelido }} | {{ $o->tempo_estimado }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('orcamento')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Campo Estação -->
                                    <div class="form-group">
                                        <label for="clienteNome">Estação de trabalho*</label>
                                        <select class="custom-select @error('estacao') is-invalid @enderror"
                                            name="estacao" required>
                                            <option value="">Selecione uma estação...</option>
                                            @foreach ($estacoes as $e)
                                            <option value="{{ $e->id_estacao }}"
                                                {{ (Request::old("estacao") == $e->id_estacao ? "selected" : "") }}>
                                                {{ $e->identificacao }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('estacao')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Campo Data e Horário de Início -->
                                    <div class="form-group">
                                        <label for="">Data e Horário de Início*</label>
                                        <input type="datetime-local" name="data_horario_inicio"
                                            class="form-control @error('data_horario_inicio') is-invalid @enderror"
                                            id="agendamentoDataHorarioInicio" value="{{ old('data_horario_inicio') }}" required>
                                        @error('data_horario_inicio')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Campo Data e Horário de Fim -->
                                    <div class="form-group">
                                        <label for="">Data e Horário de Término*</label>
                                        <input type="datetime-local" name="data_horario_fim"
                                            class="form-control @error('data_horario_fim') is-invalid @enderror"
                                            id="agendamentoDataHorarioInicio" value="{{ old('data_horario_fim') }}" required>
                                        @error('data_horario_fim')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Campo Observação -->
                                    <div class="form-group">
                                        <label for="">Observação</label>
                                        <input type="text" name="observacao"
                                            class="form-control @error('observacao') is-invalid @enderror"
                                            id="clienteObservacao" placeholder="Observação"
                                            value="{{ old('observacao') }}" maxlength="255">
                                        @error('observacao')
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
                        <div class="col-lg-6 d-none d-lg-block bg-create-agendamento-image"></div>

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