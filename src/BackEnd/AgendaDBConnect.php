<?php
    define( 'HOST', 'db' ); //A função define cria uma variável passando um valor para amesma.
    define( 'USER', 'user' ); 
    define( 'PASS', 'user123' );
    define( 'DB', 'agenda' );

    // Conexão
    $conn = mysqli_connect(HOST, USER, PASS, DB);

    if (!$conn) {
        die("Erro de conexão: " . mysqli_connect_error());
    }

      // Charset correto
    mysqli_set_charset($conn, "utf8mb4");

/*Para se conectar ao banco de dados precisamos dequatro campos:
• HostName: nome ou IP do computador onde esta o bancode dados;
• User: usuário do banco de dados;
• Password: senha do usuário do banco de dados;
• DataBase: nome do banco de dados.*/
