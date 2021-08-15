# TSI-PI_4-2020
PI 4 (Projeto Integrador 4 ) E-Commerce  - SENAC 2020
Sistemas para internet.

## Projeto
E-commerce de Jogos
Dashboard e API


## Loja pelo APP 
Shopping para usuário criar seu carrinho de compras e fazer pedidos.
Git do [APP](https://github.com/emerson-cs-santos/TSI_PI4_2020_AndroidAPP)

## Dashboard
Gerenciamento do site, incluir produtos, categorias etc.

# Acesso Dashboard - Site

## Acesso Admin
Alguém do site precisa cadastrar novos usuários.

Usuário padrão com acesso ao dashboard:

#### Usuário
admin@ibest.com

#### Senha
12345678

## Desenvolvido utilizando Laravel
E-Commerce feito utilizando Laravel 8.0
[Documentação](https://laravel.com/docs)

# Instalação Local
Os comandos abaixo devem ser executados no terminal, estando na pasta do projeto.

Observação: Essa configuração deve ser feita de acordo com o seu sistema operacional.

## 1 - PHP
Versão minima 7. 
Recomendo instalar o apache, pois já vem com o mysql, que é a configuração já feita do projeto (Esse site Funciona com vários bancos de dados): 
[Apache](https://www.apachefriends.org/pt_br/index.html)

## 2 - Variáveis de sistema:
É preciso que o sistema operacional reconheça os comandos abaixo para continuar a instalação e depois executar o projeto.

Observação: Essa configuração deve ser feita de acordo com o seu sistema operacional.

### 2.1 - php
Linguagem utilizada para desenvolver o site.

### 2.2 - composer
Gerenciador de dependências do laravel. 
Instalação [Composer](https://getcomposer.org/download/)

### 2.3 - git
Controlador de versões. 
Instalação [Git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)

### 2.4 - NPM
Node deve estar instalado na máquina:
[NodeJS](https://nodejs.org/en/download/)

## 3 - Git
Baixar fontes: 
```bash
git clone https://github.com/emerson-cs-santos/TSI-PI_4-2020.git caminho_seu_pc
```

## 4 - Composer
Executar na pasta do projeto: 
```bash
composer install
```

```bash
composer update 
```

## 5 - NPM
Executar na pasta do projeto: 
```bash
npm install
npm run dev
```

## 6 - Banco

### 6.1 - Configuração
Alterar arquivo .env:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=apishop
DB_USERNAME=root
DB_PASSWORD=
```


### 6.2 - Migrate
Antes de rodar, crie o banco:
```bash
create database apishop;
```

Na pasta do projeto rodar: 
```bash
php artisan migrate
```

### 6.3 - Seeder
Para criar registros e usuário padrão, rodar: 
```bash
php artisan db:seed
```

## 7 - Executar projeto
Rodar: 
```bash
php artisan serve
```

# Chamadas da API
As chamadas estão no git do projeto no arquivo PostMan API Chamadas.json., utilize o PostMan para abrir.

## Usuário

### Criar Usuário
#### Rota: 
http://127.0.0.1:8000/api/registrar_usuario

#### Método:
POST

#### Json de envio - Exemplo
```bash
{
	"name": "postman6",
	"email": "postman6@gmail.com",
	"password": "12345678",
	"password_confirmar": "12345678"
}	
```

#### Json de retorno Sucesso - Exemplo
```bash
{
	"status": "true",
	"id": "58",
}	
```	

#### Json de retorno Erro - Exemplo
```bash
{
	"status": "false",
	"message": "Login incorreto",
}	
```	

## Home

## Lançamentos

## Mais Vendidos

## Categorias

## Produtos

## Busca

## Carrinho

## Pedido




