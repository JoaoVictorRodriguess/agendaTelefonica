<?php

    header("Content-Type: application/json");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        require_once('chave.php');
        $api_token = $_POST['api_token'];
        $perfil = $_POST['perfil'];
        if($_POST['api_token'] == $hash){

            if($perfil !='Administrador'){
                $response = array("Erro", "mensagem" => "Acesso negado. Apenas Administradores podem realizar esta ação.");
                echo json_encode(@$response);
                exit();
            }

            require_once('../../dbConnect.php');

            $nome = $_POST['nome'];
            $telefone = $_POST['telefone'];
            $email = $_POST['email'];
            $endereco = $_POST['endereco'];
            $num = $_POST['num'];
            $CEP = $_POST['CEP'];

            $query = 'INSERT INTO contatos (nome, telefone, email, endereco, num, CEP) VALUES ( ?, ?, ?, ?, ?, ?)';

            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, 'ssssss', $nome, $telefone, $email,$endereco, $num, $CEP);
            $execute = mysqli_stmt_execute($stmt);

            $response = array();
            if($execute) {
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