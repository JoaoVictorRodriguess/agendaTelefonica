# Agenda Telefônica

Sistema de Agenda Telefônica com frontend e backend separados, usando Docker e integração com Jenkins.

## Tecnologias

- Frontend: HTML, CSS, JavaScript, PHP

- Backend: PHP + MySQL

- Banco de dados: MySQL

- Containerização: Docker

- CI/CD: Jenkins


## Como Rodar Com Docker
1. Clonar o projeto:

```bash
git clone https://github.com/seu-usuario/agendatelefonica.git
cd agendatelefonica 
```


2. Subir os containers:

```bash
docker-compose up -d
```

3. Acessar o frontend:

```bash
http://localhost:8080
```


4. Parar e remover containers:

```bash
docker-compose down
```

### Docker Compose (resumo)

- web: frontend, porta 8082, depende do db

- db: MySQL, porta 3306, usuário e senha configuráveis

## Jenkins

1. Criar pipeline no Jenkins apontando para o repositório do projeto.

2. Pipeline básico (Jenkinsfile):

```bash
git clone https://github.com/seu-usuario/agendatelefonica.git
docker-compose build
docker-compose up -d
``` 
