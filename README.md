# Teste tecnico SEFAZ

Sistema desenvolvido para cadastro de funcionários com uma simples landing page falando mais sobre a SEFAZ-AL

## Tecnologias Utilizadas

### Laravel

Framework PHP Back end

### Vue.js

Framework JavaScript para desenvolvimento Front End

### MySQL

SGBD relacional para persistência dos dados da API

### Docker

Ferramenta de gestão de containers para execução padronizada de ambientes computacionais

## Funcionalidades

### Autenticação

A autenticação é realizada atráves de token JWT

### Variáveis de Ambiente

O sistema utiliza variáveis de ambiente para definir credenciais e configurações com base no ambiente em que ela será executada

### CRUD de Funcionários

O sistema utiliza um CRUD de funcionários de acordo com os padrões exigidos no teste

## Como executar o projeto

### Requisitos

- Docker
- Docker Compose

### Passos

- Executar o comando

```
docker compose up
```

<small> O comando acima irá executar o arquivo docker-compose.yml contendo o backend, frontend e o Banco de Dados, executando as migrations e disponibilizando a API na porta 8000 e o frontend na porta 3000 </small>

### Documentação

Após a execução do projeto, a documentação da API pode ser acessada pela url:
<code>http://localhost:8000/api/documentation</code>

Após a execução do projeto, o frontend pode ser acessada pela url:
<code>http://localhost:3000</code>
