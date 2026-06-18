# Atividade 4 – Inventário Automatizado, SATD e Refatoração Oportunista (2º Bimestre)

Esta atividade foca em medir a dívida técnica de implementação de forma objetiva, registrar a dívida assumida de maneira explícita e aplicar a Regra do Escoteiro com refatorações oportunistas no sistema legado de biblioteca.

## Objetivo

Identificar, registrar e tratar dívida técnica de implementação com apoio de análise estática, usando o SonarQube ou o SonarLint, além de aplicar pequenas refatorações seguras com aumento de cobertura de testes.

## Exemplo de Apoio

Para orientar a execução, utilize o projeto `library-maintenance-lab`.

- `library-maintenance-lab/pom.xml`: configuração Maven do laboratório
- `library-maintenance-lab/src/main/java/LibrarySystem.java`: exemplo de classe central com alta concentração de responsabilidades
- `library-maintenance-lab/src/main/java/LoanManager.java`: exemplo de classe com lógica de empréstimo e pontos de melhoria
- `library-maintenance-lab/src/test/java/LoanManagerTest.java`: exemplo de teste unitário com JUnit 4

### Tutorial de instalação e configuração do SonarQube no Windows

Como apoio para montar o ambiente local, consulte o guia:

- [SonarQube Community Edition for Windows: Setup & Usage Guide](https://medium.com/@anummateen5311/sonarqube-community-edition-for-windows-setup-usage-guide-bbd8dfacdca4)

O tutorial apresenta o fluxo de instalação do SonarQube Community Edition, configuração do Java e do Sonar Scanner, criação do projeto local e execução da análise.

## Análise Estática e Inventário da Dívida

O primeiro passo é executar uma análise estática no código-fonte do sistema legado para levantar um inventário das principais dívidas de implementação.

### Ação no Repositório

- Instalar e configurar o SonarQube em ambiente local ou utilizar o SonarLint diretamente na IDE.
- Executar a análise apontando para o diretório `src/main/java` do projeto `library-maintenance-lab`.
- Identificar os principais code smells encontrados pelo analisador.
- Registrar os resultados com print da análise, evidenciando os pontos mais críticos.

## Custo e Juros da Dívida

A análise estática deve ser usada como base para discutir o custo de manutenção da dívida técnica.

### Ação no Repositório

- Selecionar as 5 infrações consideradas mais graves.
- Priorizar os problemas que estejam em áreas com maior risco de alteração ou maior frequência de manutenção.
- Justificar por que cada item foi escolhido como prioridade, relacionando o achado ao impacto de manutenção e aos juros da dívida.

Além de medir a dívida com ferramenta, o aluno deve declará-la de forma consciente no rastreador de tarefas.

### Ação no GitHub

- Criar 5 issues novas no GitHub Projects descrevendo os problemas encontrados.
- Marcar obrigatoriamente cada issue com a label `technical debt`.
- Explicar na issue por que o item foi assumido como dívida e qual é o risco de mantê-lo sem tratamento.
- Vincular as issues ao board do projeto para acompanhamento.

## Regra do Escoteiro e Refatoração Oportunista

Depois de identificar a dívida técnica, aplique a Regra do Escoteiro: deixe o código um pouco melhor do que encontrou.

### Ação no Repositório

- Durante a correção do code smell, implementar refatorações adicionais identificadas no mesmo trecho de código, desde que seguras e pequenas.
- Refatorar o comportamento sem alterar a intenção funcional do sistema.
- Sempre que possível, extrair métodos, reduzir duplicação, melhorar nomes e diminuir acoplamento.
- Criar testes automatizados para aumentar a cobertura do método ou arquivo alterado.

## Segurança de Comportamento com JUnit

A refatoração precisa ser validada com teste automatizado para provar que o comportamento foi preservado.

### Ação no Repositório

- Escrever ou atualizar testes com JUnit cobrindo o cenário alterado.
- Executar a suíte de testes antes e depois da refatoração.
- Apresentar evidência da barra verde do JUnit, demonstrando que a mudança não quebrou o sistema.

## Commit e Padrão de Mensagem

Ao final da atividade, o histórico de versionamento também deve refletir a melhoria realizada.

### Ação no GitHub

- Criar o commit utilizando o padrão Conventional Commits.
- Usar obrigatoriamente o prefixo `refactor`.
- A mensagem deve deixar claro o módulo ou a responsabilidade afetada.

Exemplo:

```text
refactor(library): remove acoplamento com ResultSet no metodo de busca
```

## Formato de Entrega

### Repositório da Entrega

1. A entrega deve ser feita em um repositório público no GitHub.
2. O repositório deve ser um fork do repositório da disciplina.
3. O project e as issues devem estar visíveis no repositório.

### Evidências

A entrega deve incluir evidências da análise, da declaração da dívida e da refatoração aplicada, como:

- print do SonarQube ou do SonarLint com os code smells encontrados
- link do board com as 5 issues registradas
- justificativa das dívidas mais graves escolhidas para tratamento
- teste automatizado cobrindo a refatoração aplicada
- print da barra verde do JUnit após a correção
- commit realizado com mensagem no padrão Conventional Commits

### Envio por E-mail

Após publicar o repositório no GitHub, enviar o link por e-mail para:

**joao.vsantos@unicesumar.edu.br**

O e-mail deve seguir este formato:

**Título do e-mail:**

```text
Atividade 4 Manutenção ESOFT5S 2BIM
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

**Data**: 28/05/2026  
**Horário**: até 19h

## Checklist de Validação

Antes de entregar, validar:

- [ ] Análise estática executada com SonarQube ou SonarLint
- [ ] 5 code smells priorizados e justificados
- [ ] 5 issues criadas com a label `technical debt`
- [ ] Board atualizado com as dívidas registradas
- [ ] Refatoração oportunista aplicada com Regra do Escoteiro
- [ ] Teste automatizado adicionado ou atualizado para a mudança
- [ ] Barra verde do JUnit evidenciada após a refatoração
- [ ] Commit realizado no padrão Conventional Commits com prefixo `refactor`
- [ ] Repositório público e fork da disciplina
- [ ] E-mail preparado com o link do repositório e project