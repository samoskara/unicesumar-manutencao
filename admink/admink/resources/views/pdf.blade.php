<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Termo de Responsabilidade</title>
    <style>
        html,
        body {
            font-family: 'Arial', sans-serif;
            margin: 50;
        }

        .h1 {
            font-size: 84px;
        }

        .li {
            margin-top: 10;
            margin-bottom: 10;
        }
    </style>
</head>

<body>
    <h1>Termo de Responsabilidade</h1>
    <br>
    <p>Eu, <strong>{{ $agendamento->orcamento->cliente->nome }}</strong>, por meio deste termo de
        responsabilidade, afirmo que tenho mais de 16 anos,
        ou permissão dos meus responsáveis, para realizar a
        tatuagem abaixo descrita, no Estúdio Bloco 143, em <strong>{{ date_format($agendamento->data_horario_inicio, 'd/m/Y H:i') }}</strong>. </p>
    <br>
    <p>Também confirmo a ciência de que todos os
        procedimentos de cicatrização da tatuagem são de
        minha responsabilidade, e que os profissionais do Estúdio
        Bloco 143 me instruíram sobre como realizá-los.
    </p>
    <br>
    <ul>
        <li>
            Tatuagem: <strong>{{ $agendamento->orcamento->tatuagem_nome }}</strong>
        </li>
        <li>
            Local no corpo: <strong>{{ $agendamento->orcamento->tatuagem_local }}</strong>
        </li>
        <li>
            Comprimento: <strong>{{ $agendamento->orcamento->tatuagem_comprimento }} cm</strong>
        </li>
        <li>
            Largura: <strong>{{ $agendamento->orcamento->tatuagem_largura }} cm</strong>
        </li>
        <li>
            Descrição: <strong>{{ $agendamento->orcamento->tatuagem_descricao }}</strong>
        </li>
        <li>
            Artista: <strong>{{ $agendamento->orcamento->artista->nome }}</strong>
        </li>
        <li>
            Valor: <strong>R$ {{ $agendamento->orcamento->valor }}</strong>
        </li>
    </ul>
    <br>
    <p>Assinatura do estúdio: ________________________________</p>
    <br>
    <p>Assinatura do cliente: ________________________________</p>
</body>

</html>