<?php

    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        require_once('chave.php');
        $api_token = $_POST['api_token'];
        $perfil = $_POST['perfil'];
        if($_POST['api_token'] == $hash){

            if($perfil !='Administrador'){
                $response = array("Erro", "mensagem" => "Acesso negado. Apenas Administradores podem realizar esta ação.");
                echo json_encode($response);
                exit();
            }

            require_once('../../dbConnect.php');

            $id = $_POST['id'];
            $nome = $_POST['nome'];
            $telefone = $_POST['telefone'];
            $email = $_POST['email'];
            $endereco = $_POST['endereco'];
            $num = $_POST['num'];
            $CEP = $_POST['CEP'];
            $cidade = $_POST['cidade'];
            $estado = $_POST['estado'];

            $query = 'UPDATE contatos SET nome = ?, telefone = ?, email = ?, endereco = ?, num = ?, CEP = ?, cidade = ?, estado = ? WHERE id = ?'; 

            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, 'ssssssssi', $nome, $telefone, $email, $endereco, $num, $CEP, $cidade, $estado, $id);
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
?>