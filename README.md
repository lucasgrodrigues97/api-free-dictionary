# Back-end Challenge - Dictionary

## Introdução

Uma API RESTful para consulta de definições de palavras, construída como desafio técnico.

#### Tecnologias (Back-End):
- Linguagem: PHP
- Framework: Laravel
- Autenticação: Laravel Passport
- Gerenciador de dependências: Composer
- Banco de dados: MySQL (ou o que estiver usando)
- Servidor embutido: Artisan

### Como instalar e rodar o projeto

```
git clone https://github.com/lucasgrodrigues97/api-free-dictionary.git
cd api-free-dictionary
```

### Instale as dependências:

```
composer install
```

### Copie o arquivo .env.example para .env e configure suas variáveis de ambiente (como o DB, etc):

```
cp .env.example .env
```

### Gere a chave da aplicação:

```
php artisan key:generate
```

### Rode as migrations:

```
php artisan migrate
```

### Instale o Passport:

```
php artisan passport:install
```

### Rode o servidor:

```
php artisan serve
A API estará disponível em http://127.0.0.1:8000
```

### Observações
```
This is a challenge by Coodesh
```
