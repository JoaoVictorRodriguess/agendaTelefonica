<?php 

    header("Content-Type: application/json");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        require_once('../../dbConnect.php');

        $nome = $_POST['nome'];
        $usuario = $_POST['usuario'];
        $senha_plana = $_POST['senha'];
        $senha_hash = password_hash($senha_plana, PASSWORD_DEFAULT);
        $perfil_novo_usuario = $_POST['perfil_novo_usuario'] ?? 'Usuario';

        $query = 'INSERT INTO usuarios (nome, usuario, senha, perfil) VALUES ( ?, ?, ?, ?)';

        $stmt = mysqli_prepare($conn, $query);

        mysqli_stmt_bind_param($stmt, 'ssss', $nome, $usuario, $senha_hash, $perfil_novo_usuario);

        $execute = mysqli_stmt_execute($stmt);

        $response = array();

        if($execute) {
                $response['status'] = 'sucesso';
                $response['mensagem'] = 'perfil adicionado com sucesso!';
            }else{
                $response['status'] = 'erro';
                $response['mensagem'] = 'Erro ao adicionar o perfil: '. mysqli_stmt_error($stmt);
            }
        
            echo json_encode($response);
        }
?>