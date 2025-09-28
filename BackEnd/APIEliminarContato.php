<?php

    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        require_once('chave.php');
        $api_token = $_POST['api_token'];
        if ($_POST['api_token'] == $hash){

            require_once('../../dbConnect.php');

            $id = $_POST['id'];

            $query = 'DELETE FROM contatos WHERE id=?';

            $stmt = mysqli_prepare($conn, $query); 
            mysqli_stmt_bind_param($stmt, 'i', $id); 
            $executou = mysqli_stmt_execute($stmt); 

            $response = array();
            if($executou){
                $response['status'] = 'sucesso';
                $response['mensagem'] = 'contato excluido com sucesso';
            }else{
                $response['status'] = 'Erro';
                $response['mensagem'] = 'Erro ao excluir o contato' . mysqli_stmt_error($stmt);
            }
            echo json_encode($response);
        }
    }
?>