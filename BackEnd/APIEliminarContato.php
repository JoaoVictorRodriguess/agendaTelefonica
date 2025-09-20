<?php

    header("Content-Type: application/json");

    if ( $_SERVER['REQUEST_METHOD'] == 'POST'){

        require_once('chave.php');
        $api_token = $_POST['api_token'];
        if ($_POST['api_token'] == $chave){

            require_once('../../dbConnect.php');

            $id = $_POST['id'];

            $query = 'DELETE FROM contatos WHERE id=?'; //instrução pra remover o registro

            $stmt = mysqli_prepare($conn, $query); //preparar a consulta usando a variavel de conexão conn
            mysqli_stmt_bind_param($stmt, 'i', $id); //vincular o id a consulta que foi preparada. 
            $executou = mysqli_stmt_execute($stmt); //executar a consulta e armazenar em uma variavel pra ver se deu certo

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