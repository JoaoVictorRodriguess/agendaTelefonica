<?php

    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        require_once('chave.php');
        $api_token = $_POST['api_token'];
        if($_POST['api_token'] == $hash){

            require_once('../../dbConnect.php');

            $nome = $_POST['nome'];
            $telefone = $_POST['telefone'];
            $email = $_POST['email'];

            $query = 'INSERT INTO contatos (nome, telefone, email) VALUES ( ?, ?, ?)';

            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, 'sss', $nome, $telefone, $email);
            $executou = mysqli_stmt_execute($stmt);

            $response = array();
            if($executou) {
                $response['status'] = 'sucesso';
                $response['mensagem'] = 'contato adicionado com sucesso!';
            }else{
                $response['status'] = 'erro';
                $response['mensagem'] = 'Erro ao adicionar o contato: '. mysqli_stmt_error($stmt);
            }
            
            echo json_encode($response);
        }
    }

?>