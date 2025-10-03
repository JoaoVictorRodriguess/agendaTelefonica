1. Clone o repositório:
   bash
   git clone https://github.com/JoaoVictorRodriguess/agendaTelefonica.git
   cd agendaTelefonica

2. Suba os containers:
    docker-compose up --build


3. Acesse no navegador:
    Sistema: http://localhost:8080

    phpMyAdmin: http://localhost:8081

    (usuário: root, senha: root)

CREATE TABLE usuarios (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(80) NOT NULL,
    usuario VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);



