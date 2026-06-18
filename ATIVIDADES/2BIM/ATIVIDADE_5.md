# Atividade 5 – Adição de Funcionalidade em Sistema Legado com Sprout Class/Method (2º Bimestre)

Esta atividade usa o sistema legado **Admink** como base para praticar manutenção evolutiva em PHP/Laravel. O objetivo é adicionar uma nova funcionalidade sem aumentar desnecessariamente a complexidade do código antigo.

## Contexto do Projeto

O sistema **ADMINK** é um monolito legado desenvolvido em PHP/Laravel que concentra regras vitais de negócio. O cliente solicitou uma nova funcionalidade urgente: **sincronizar os agendamentos recém-criados com o Google Calendar**.

Seu impulso inicial pode ser abrir o controlador legado e inserir a integração completa da API do Google direto no método `store()` do `AgendamentoController`. Não faça isso. O código legado já é complexo e adicionar mais responsabilidades no mesmo ponto só aumenta a dívida técnica e o risco de quebrar a criação de agendamentos.

## Objetivo

Aplicar as estratégias de manutenção em sistemas legados para adicionar a nova funcionalidade de forma segura, usando o padrão **Sprout Class/Method** e garantindo que o código novo nasça protegido por testes automatizados.

## Base de Apoio

Use o projeto Admink como base e consulte os arquivos abaixo antes de começar:

- [README do Admink](../../admink/admink/README.md)
- `admink/admink/app/Http/Controllers/Admin/AgendamentoController.php`
- `admink/admink/app/Agendamento.php`
- `admink/admink/app/Http/Requests/AgendamentoRequest.php`
- `admink/admink/tests/Unit`

O `README` do Admink contém as instruções de instalação, configuração do PHP com `pvm`, configuração do Node com `nvm`, criação do `.env`, preparação do banco e execução do sistema.

## Apoio para a integração com a API do Google

Para implementar a sincronização com o Google Calendar a documentação oficial da API deve ser consultada antes de codificar a solução.

### Documentação oficial recomendada

- [Google Calendar API Overview](https://developers.google.com/calendar/api/guides/overview)
- [Google Calendar API Quickstart](https://developers.google.com/calendar/api/quickstart/php)
- [Google Cloud Console](https://console.cloud.google.com/)
- [Google Identity OAuth 2.0](https://developers.google.com/identity/protocols/oauth2)

### Passo a passo da integração

1. Acesse o Google Cloud Console.
2. Crie um projeto novo para a atividade, ou selecione um projeto já existente.
3. Ative a Google Calendar API nesse projeto.
4. Configure a tela de consentimento OAuth.
5. Crie as credenciais necessárias para autenticação.
6. Anote os dados gerados e coloque apenas o que for sensível no arquivo `.env`.
7. Leia a documentação do quickstart em PHP para entender o fluxo de autenticação e envio de eventos.
8. Implemente a integração dentro da classe `GoogleCalendarService`, sem espalhar a lógica no controlador legado.

### Orientação prática para o aluno

- O código legado não deve receber toda a integração da API.
- O serviço novo deve concentrar a montagem do evento, a autenticação e o envio para o Google Calendar.
- Se a API exigir tokens, scopes ou identificadores, mantenha esses valores em variáveis de ambiente.
- Use testes unitários com mock/fake para validar a integração sem acessar a internet durante a execução dos testes.

## Roteiro de Execução

### Passo 1: Preparar o ambiente do Admink

1. Siga o [README do Admink](../../admink/admink/README.md).
2. Instale as ferramentas necessárias na ordem indicada.
3. Crie o arquivo `.env` a partir de `.env.example` na pasta `admink/admink`.
4. Configure o banco, rode os scripts da pasta `database/create_scripts` e suba a aplicação localmente.

### Passo 2: Entender o ponto de integração

1. Abra a classe `admink/admink/app/Http/Controllers/Admin/AgendamentoController.php`.
2. Localize o método `store()`.
3. Identifique o trecho em que o agendamento já foi salvo com sucesso.
4. É exatamente depois desse ponto que a integração com o Google Calendar deve ser chamada.

### Passo 3: Criar o broto com Sprout Class

1. Não altere a lógica principal do controlador legada no início.
2. Crie uma classe nova e isolada em `admink/admink/app/Services/GoogleCalendarService.php`.
3. Essa classe deve ter uma única responsabilidade: receber os dados do agendamento e enviar as informações para a API do Google Calendar.
4. Evite hard coding. Coloque credenciais e configurações no `.env`.
5. Se necessário, crie métodos pequenos e objetivos, como `sync()` ou `createEvent()`.

### Passo 4: Blindar o código novo com testes

1. Crie uma classe de teste em `admink/admink/tests/Unit/GoogleCalendarServiceTest.php`.
2. Escreva pelo menos dois testes:
   - um para o caminho feliz, quando a sincronização com o Google Calendar funciona;
   - outro para o cenário de erro, quando a API retorna falha ou exceção.
3. Use mock/fake da chamada HTTP para não depender da internet durante o teste.
4. O objetivo é garantir que o broto nasça testado antes de ser chamado pelo legado.

### Passo 5: Inserir apenas a chamada no código legado

1. Volte ao método `store()` de `AgendamentoController`.
2. Após o agendamento ser salvo com sucesso, insira somente a chamada do serviço novo.
3. A estrutura deve ficar parecida com isso:

```php
$googleCalendarService->sync($agendamento);
```

4. O controlador legado deve continuar responsável apenas pelo fluxo principal de cadastro.
5. A integração externa deve ficar concentrada na nova classe de serviço.

### Passo 6: Revisar a solução

1. Verifique se o agendamento continua sendo salvo corretamente.
2. Confirme se a chamada ao serviço novo acontece somente após o sucesso da gravação.
3. Valide se os testes do serviço novo passam.
4. Não espalhe lógica de integração pela controller, modelo ou view.

## Arquivos Esperados na Solução

Ao final da atividade, a implementação deve incluir, no mínimo:

- `admink/admink/app/Services/GoogleCalendarService.php`
- `admink/admink/tests/Unit/GoogleCalendarServiceTest.php`
- ajuste pontual em `admink/admink/app/Http/Controllers/Admin/AgendamentoController.php`
- configurações novas no `.env` e, se necessário, no `.env.example`

## Critérios de Entrega

### Repositório da entrega

1. A entrega deve ser publicada em um repositório público no GitHub.
2. O repositório deve ser um fork do repositório da disciplina.
3. O projeto e as issues devem estar visíveis.

### Evidências

A entrega deve incluir evidências da implementação da funcionalidade, como:

- print do código novo em `GoogleCalendarService`
- print do teste unitário criado ou atualizado
- print da integração chamando o serviço após o `save()` do agendamento
- print da execução dos testes com sucesso
- link do commit realizado no padrão Conventional Commits

### Commit

Faça o commit da solução usando o padrão Conventional Commits.

Exemplo:

```text
feat(agendamento): sincroniza eventos com o google calendar
```

### Envio por e-mail

Após publicar o repositório, enviar o link por e-mail para:

**joao.vsantos@unicesumar.edu.br**

**Título do e-mail:**

```text
Atividade 5 Manutenção ESOFT5S 2BIM
```

**Corpo do e-mail:**

```text
Integrantes:

Nome completo de cada integrante da equipe
Usuário do GitHub de cada integrante

Repositório: https://github.com/seu-usuario/seu-fork
Project: https://github.com/seu-usuario/seu-fork/projects/XX
```

## Prazo de Entrega

**Data**: 18/05
**Horário**: 19h

## Checklist de Validação

Antes de entregar, valide se:

- [ ] o README do Admink foi seguido para preparar o ambiente
- [ ] a classe `GoogleCalendarService` foi criada em `app/Services`
- [ ] o método `store()` do `AgendamentoController` recebeu apenas a chamada do serviço
- [ ] os dados sensíveis ficaram no `.env`
- [ ] pelo menos dois testes unitários foram criados ou atualizados
- [ ] o caminho feliz e o cenário de erro foram cobertos nos testes
- [ ] o código legado permaneceu limpo e sem excesso de responsabilidade
- [ ] o commit foi feito no padrão Conventional Commits
- [ ] o repositório público e o project estão disponíveis para avaliação
