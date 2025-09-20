<?php

    header("Content-Type: application/json");

    if ( $_SERVER['REQUEST_METHOD'] == 'POST'){

        require_once('chave.php');
        $api_token = $_POST['api_token'];
        if($_POST['api_token'] == $chave){

            require_once('../../dbConnect.php');

            $id = $_POST['id'];
            $nome = $_POST['nome'];
            $telefone = $_POST['telefone'];
            $email = $_POST['email'];

            $query = 'UPDATE contatos SET nome = ?, telefone = ?, email = ? WHERE id = ?'; //consultei

            $stmt = mysqli_prepare($conn, $query); //preparei
            mysqli_stmt_bind_param($stmt, 'sssi', $nome, $telefone, $email, $id);
            $execute = mysqli_stmt_execute($stmt);

            $response = array();
            if($execute){
                $response['status'] = 'Sucesso';
                $response['mensagem'] = 'Contato atualizado com sucesso';
            }else{
                $response['status'] = 'Erro';
                $response['mensagem'] = 'Erro ao atualizar contato' . mysqli_stmt_error($stmt);
            }
            
            echo json_encode($response);
        }

    }
