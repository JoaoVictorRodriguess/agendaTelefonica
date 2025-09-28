<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $servidor = 'http://localhost/AgendaTelefonica/BackEnd/';

    if (!isset($_SESSION['chave'])) {
        $_SESSION['chave'] = 'usuario123';
    }

    $token = hash('sha256', $_SESSION['chave'] . date('Y-m-d'));
?>
