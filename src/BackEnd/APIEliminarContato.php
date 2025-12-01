<?php

    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        require_once('chave.php');
        $api_token = $_POST['api_token'];
        $perfil_usuario = $_POST['perfil_usuario'];
        if ($_POST['api_token'] == $hash){

            if($perfil_usuario !='Administrador'){
                $response = ['status' => 'erro', "mensagem" => "Acesso negado. Apenas Administradores podem realizar esta ação."];
                echo json_encode($response);
                exit();
            }

            require_once('AgendaDBConnect.php');

            $id = $_POST['id'];

            $query = 'DELETE FROM contatos WHERE id=?';

            $stmt = mysqli_prepare($conn, $query); 
            mysqli_stmt_bind_param($stmt, 'i', $id); 
            $execute = mysqli_stmt_execute($stmt); 

            $response = array();
            if($execute){
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