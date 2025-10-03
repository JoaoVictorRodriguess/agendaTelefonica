<?php
    $senha = "minhaSenha";
    $hash = password_hash($senha, PASSWORD_DEFAULT);
    echo "Hash gerado: " . $hash;

?>

CREATE TABLE usuarios (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(80) NOT NULL,
    usuario VARCHAR(15) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);



