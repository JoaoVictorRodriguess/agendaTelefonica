<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }


    $servidor = "http://web/BackEnd/";

    if (!isset($_SESSION['chave'])) {
        $_SESSION['chave'] = 'usuario123';
    }

    $perfil_usuario = 'Visitante';
    if(isset($_SESSION['perfil'])){
        $perfil_usuario = $_SESSION['perfil'];
    }
    $token = hash('sha256', $_SESSION['chave'] . date('Y-m-d'));
?>
