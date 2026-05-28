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
            <li class="breadcrumb-item active" aria-current="page">Editar Agendamento</li>
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
                                    <h1 class="h4 text-gray-900 mb-4">Edite abaixo os dados do agendamento</h1>
                                </div>

                                <!-- Formulário -->
                                <form method="POST" class="user"
                                    action="{{ route('admin.agendamentos.update', ['agendamento' => $agendamento->id_agendamento]) }}">
                                    @csrf
                                    @method('PUT')

                                    <!-- Campo Orçamento -->
                                    @php $orcamento_old = false; @endphp
                                    <div class="form-group">
                                        <label for="clienteNome">Orçamento* (Tattoo | Cliente | Artista)</label>
                                        <select class="custom-select @error('orcamento') is-invalid @enderror"
                                            name="orcamento" required>
                                            <option value="">Selecione um orçamento...</option>
                                            @foreach ($orcamentos as $o)
                                            <option value="{{ $o->id_orcamento }}"
                                                @if(Request::old('orcamento')==$o->id_orcamento)
                                                {
                                                    selected
                                                    @php $orcamento_old = true @endphp
                                                } 
                                                @elseif($agendamento->orcamento->id_orcamento == $o->id_orcamento &&
                                                !$orcamento_old) selected
                                                @endif>
                                                {{ $o->tatuagem_nome }} | {{ $o->cliente->nome }} |
                                                {{ $o->artista->apelido }}
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
                                    @php $estacao_old = false; @endphp
                                    <div class="form-group">
                                        <label for="clienteNome">Estação de trabalho*</label>
                                        <select class="custom-select @error('estacao') is-invalid @enderror"
                                            name="estacao" required>
                                            <option value="">Selecione uma estação...</option>
                                            @foreach ($estacoes as $e)
                                            <option value="{{ $e->id_estacao }}"
                                                @if(Request::old('estacao') == $e->id_estacao)
                                                {
                                                    selected
                                                    @php $estacao_old = true @endphp
                                                } 
                                                @elseif($agendamento->estacao->id_estacao == $e->id_estacao &&
                                                !$estacao_old) selected
                                                @endif>
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
                                            id="agendamentoDataHorarioInicio"
                                            @if(Request::old('data_horario_inicio')) value="{{ old('data_horario_inicio') }}" 
                                            @else value="{{ date_format($agendamento->data_horario_inicio, 'Y-m-d\TH:i:s') }}" @endif required>
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
                                            id="agendamentoDataHorarioInicio"  
                                            @if(Request::old('data_horario_fim')) value="{{ old('data_horario_fim') }}" 
                                            @else value="{{ date_format($agendamento->data_horario_fim, 'Y-m-d\TH:i:s') }}" @endif"
                                            required>
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
                                            @if(Request::old('observacao')) value="{{ old('observacao') }}" 
                                                @else value="{{ $agendamento->observacao }}" @endif maxlength="255">
                                        @error('observacao')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Botão de envio -->
                                    <button type="submit" class="btn btn-success btn-user btn-block">Salvar</button>

                                </form>
                            </div>
                        </div>

                        <!-- Ilustração -->
                        <div class="col-lg-6 d-none d-lg-block bg-edit-agendamento-image"></div>

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
    $("#valor").maskMoney({affixesStay: false, thousands: ".", decimal: ",", prefix: "R$ "});
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