## Admink — guia para executar o projeto

Este guia mostra, passo a passo, como instalar, configurar e executar o projeto Admink no Windows. O sistema foi desenvolvido em **Laravel 6** e usa PHP, MySQL/MariaDB e componentes da stack do ecossistema Laravel.

Documentação oficial do Laravel: [laravel.com/docs/6.x](https://laravel.com/docs/6.x)

Siga a ordem apresentada para evitar erros. O PHP será instalado e ativado com `pvm`, o Node.js com `nvm`, e o `php.ini` será alterado na instalação do PHP gerenciada pelo `pvm`.

**Sequência exata dos passos**

1. Instalar `pvm`.
2. Instalar `nvm`.
3. Instalar MariaDB ou MySQL.
4. Instalar o MySQL Workbench.
5. Usar o `pvm` para instalar e ativar o PHP 7.3.x.
6. Ajustar o `php.ini` dessa instalação do PHP.
7. Usar o `nvm` para instalar e ativar o Node.js 16.x.
8. Instalar o Composer.
9. Instalar o Yarn.
10. Criar o banco `admink` no Workbench.
11. Importar os scripts do banco na ordem correta.
12. Configurar o arquivo `.env`.
13. Instalar as dependências do projeto.
14. Gerar a chave da aplicação e popular o banco.
15. Compilar os arquivos do projeto.
16. Iniciar a aplicação.

**1) Instalar as ferramentas**
- Instale o `pvm` para gerenciar o PHP.
- Instale o `nvm` para gerenciar o Node.js.
- Instale o MariaDB Community Server ou o MySQL Community Server.
- Instale o MySQL Workbench para criar e administrar o banco.
- Instale o Composer.
- Instale o Yarn 1.x.

**Links úteis para instalação e documentação**
- `pvm` para PHP: [documentação do pvm](https://github.com/pvm/pvm)
- `nvm` para Node.js: [nvm-windows](https://github.com/coreybutler/nvm-windows) ou [nvm para Linux/macOS](https://github.com/nvm-sh/nvm)
- PHP 7.3: [downloads do PHP para Windows](https://windows.php.net/download/)
- Composer: [instalação oficial](https://getcomposer.org/download/)
- Node.js: [downloads oficiais](https://nodejs.org/)
- Yarn: [documentação oficial](https://classic.yarnpkg.com/lang/en/docs/install/)
- MariaDB: [downloads oficiais](https://mariadb.org/download/)
- MySQL Server: [downloads oficiais](https://dev.mysql.com/downloads/mysql/)
- MySQL Workbench: [downloads oficiais](https://dev.mysql.com/downloads/workbench/)
- Material de apoio sobre testes automatizados no Admink: [TCC - Implementação de testes automatizados no Admink](../apoio/TESTES/TCC%20Engenharia%20de%20Software%20-%20João%20Vitor%20-%202022.pdf)

**2) Configurar o PHP com pvm**
- Use o `pvm` para instalar e ativar o PHP 7.3.x.
- Depois de ativar o PHP com o `pvm`, abra o arquivo `php.ini` dessa instalação.
- Nesse arquivo, localize as linhas das extensões e deixe assim:

```ini
extension=openssl
extension=pdo_mysql
```

- Salve o arquivo.
- Feche e abra o terminal novamente.
- Rode `php -m` e confirme se `openssl` e `pdo_mysql` aparecem na lista.

**3) Configurar o Node com nvm**
- Use o `nvm` para instalar e ativar o Node.js 16.x.

```bash
nvm install 16
nvm use 16
```

- Se o Yarn ainda não estiver instalado, rode:

```bash
npm i -g yarn
```

**4) Preparar o banco de dados**
- Abra o MySQL Workbench.
- Conecte no servidor local (`127.0.0.1` ou `localhost`).
- Crie o schema `admink`.
- Importe o arquivo `database/create_scripts/DDL_admink.sql`.
- Depois execute os scripts da pasta `database/create_scripts` nesta ordem:
    1. `DDL_admink.sql`
    2. Scripts de `FUNCTIONS`
    3. Scripts de `PROCEDURES`
    4. Scripts de `TRIGGERS`

Essa ordem evita erros de dependência entre tabelas, funções, procedures e triggers.

- Ainda no Workbench, crie ou ajuste o usuário do banco e as permissões necessárias.
- Para criar o usuário no banco, abra uma aba de SQL no Workbench e execute os comandos abaixo. Eles criam o usuário para os dois formatos de conexão mais comuns e liberam acesso ao schema `admink`:

```sql
CREATE USER 'admink_app'@'127.0.0.1' IDENTIFIED BY 'SenhaForte123';
CREATE USER 'admink_app'@'localhost' IDENTIFIED BY 'SenhaForte123';
GRANT ALL PRIVILEGES ON admink.* TO 'admink_app'@'127.0.0.1';
GRANT ALL PRIVILEGES ON admink.* TO 'admink_app'@'localhost';
FLUSH PRIVILEGES;
```

- Se o servidor estiver usando MySQL 8 e você precisar definir o plugin de autenticação, use `IDENTIFIED WITH mysql_native_password BY 'SenhaForte123'` no lugar de `IDENTIFIED BY 'SenhaForte123'`.
- Depois disso, teste a conexão no Workbench usando o usuário `admink_app`.

**5) Configurar o arquivo `.env`**
- Na pasta `admink/admink`, copie o arquivo `.env.example` para `.env`.
- No Windows, você pode fazer isso com o Explorador de Arquivos ou com o terminal. Exemplo no PowerShell:

```powershell
Copy-Item .env.example .env
```

- Depois de criar o `.env`, abra o arquivo e confira os dados do banco. Ajuste apenas o que for necessário, principalmente a senha:

```env
DB_HOST=127.0.0.1
DB_DATABASE=admink
DB_USERNAME=admink_app
DB_PASSWORD=SENHA_SECRETA
```

- Se o seu banco tiver outra senha, troque `DB_PASSWORD` pela senha que você criou no Workbench.
- Se aparecer erro de autenticação, confira se o usuário existe para `127.0.0.1` e também para `localhost`.
- Em alguns casos, o usuário precisa estar com o plugin `mysql_native_password`.

**6) Instalar as dependências do projeto**
- Na pasta do projeto (`admink/admink`), rode:

```bash
composer install
yarn install
```

- Se o Composer reclamar de TLS/openssl, volte ao passo do PHP e confirme se `extension=openssl` está ativa no `php.ini` do `pvm`.

**7) Gerar a chave e popular o banco**
- Rode os comandos abaixo:

```bash
php artisan key:generate
php artisan db:seed
```

- `php artisan key:generate` cria a chave da aplicação.
- `php artisan db:seed` insere os dados iniciais.

**8) Compilar os arquivos do projeto**
- Gere os arquivos da interface para desenvolvimento:

```bash
yarn dev
```

- Para gerar a versão final dos arquivos, use:

```bash
yarn prod
```

- O projeto já foi ajustado para evitar problemas com `node-sass`. Se der erro de compilação, confira se o Node está na versão 16.x.

**9) Iniciar a aplicação**
- Inicie o servidor do Laravel:

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

- Depois, abra no navegador:

```text
http://127.0.0.1:8000
```

**Comandos Laravel úteis**

```bash
php artisan migrate --step
php artisan cache:clear
php artisan config:cache
```

- `php artisan migrate --step` executa migrations, se necessário.
- `php artisan cache:clear` limpa o cache.
- `php artisan config:cache` recria o cache de configuração.

**Soluções rápidas / Troubleshooting**
- Erro `The openssl extension is required`: abra o `php.ini` do PHP ativado no `pvm`, descomente `extension=openssl`, salve e rode `php -m`.
- Erro `could not find driver`: abra o mesmo `php.ini`, descomente `extension=pdo_mysql`, salve e rode `php -m`.
- Erro com `node-sass` ou `node-gyp`: confira se o Node ativado pelo `nvm` é o 16.x.
- Erro de autenticação no banco: confira usuário, senha, host e plugin `mysql_native_password`.
- Se o Laravel conectar como `user@localhost`, crie também o usuário para `user@127.0.0.1`.

**Notas finais**
- Arquivos importantes:
    - `database/create_scripts/DDL_admink.sql` — estrutura principal do banco
    - `package.json` — dependências da interface
    - `.env.example` — exemplo de configuração

- Evite commitar o arquivo `.env` com senha real.
- Se quiser, eu posso transformar este guia em um roteiro de aula para os alunos.

