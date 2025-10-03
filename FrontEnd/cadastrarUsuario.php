<?php

    session_start();
    require_once('config.php');

    if($perfil_usuario != 'Administrador'){
        header("Location: listaContato.php");
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $nome = $_POST['nome'];
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];
        $perfil_novo= $_POST['perfil'];

        $postdata = http_build_query(
            array(
                'api_token' => $token,
                'perfil_admin' => $perfil_usuario,
                'nome' => $nome,
                'usuario' => $usuario,
                'senha' => $senha,
                'perfil_novo_usuario' => $perfil_novo
            )
        );

        $opts = array('http' => 
            array(
                'method' => 'POST',
                'header' => 'Content-Type: Application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );

        $context = stream_context_create($opts);

        $url = $servidor . 'APICadastrarUsuario.php';
        $result = file_get_contents($url, false, $context);
        $jsonObj = json_decode($result);

        if ($jsonObj->status == 'sucesso') {
            header("Location: listaContato.php");
            exit();
        }else{
            $mensagem_erro = "Não foi possivel cadastrar esse contato";
            header("Location: listaContato.php");
            exit();
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style2.css">
    <title>Cadastrar Usuário</title>
</head>
<body>
    <h1>Cadastro de Usuario</h1>
     <form action="cadastrarUsuario.php" method="POST">

        <label for="nome">Nome: </label>
        <input type="text" id="nome" name="nome" required>

        <label for="usuario">Email: </label>
        <input type="email" id="usuario" name="usuario" required>


        <label for="senha">Senha: </label>
        <input type="password" id="senha" name="senha" required>

        <select name="perfil" id="perfil" required>
            <option value="" disabled selected>Selecione o tipo de perfil</option>
            <option value="Administrador">Administrador</option>
            <option value="Usuario">Usuario</option>
        </select> 

        <button type="submit">Salvar Usuario</button>
        <button type="reset">Limpar Campos</button>

     </form>
</body>
</html>