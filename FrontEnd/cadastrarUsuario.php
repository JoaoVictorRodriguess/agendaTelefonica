<?php

    require_once('config.php');

    $mensagem_erro = '';
    $perfil_admin_logado = isset($perfil_usuario) && $perfil_usuario == 'Administrador';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $nome = $_POST['nome'];
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];

        if($perfil_admin_logado){
        $perfil_novo= $_POST['perfil'];
        $postdata = http_build_query(
            array(
                'nome' => $nome,
                'usuario' => $usuario,
                'senha' => $senha,
                'perfil_novo_usuario' => $perfil_novo
            )
        );
        }else{
            $postdata = http_build_query(
            array(
                'nome' => $nome,
                'usuario' => $usuario,
                'senha' => $senha
            )
        );
        }
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

        if($perfil_admin_logado){
            if ($jsonObj->status == 'sucesso') {
                header("Location: listaUsuario.php");
                exit();
            }else{
                $mensagem_erro = "Não foi possivel cadastrar esse contato";
                header("Location: listaUsuario.php");
                exit();
            }
        }else{
            if ($jsonObj->status == 'sucesso') {
                header("Location: index.html");
                exit();
            }else{
                $mensagem_erro = "Não foi possivel cadastrar esse contato";
                header("Location: index.html");
                exit();
            }

        }
    }

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Cadastrar Usuário</title>
</head>
<body>
    <div class="header">
        <h1>Cadastro de Usuario</h1>    
    </div>
     <form action="cadastrarUsuario.php" method="POST">
        <div class="cadContato">
            <label for="nome">Nome: </label>
            <input type="text" id="nome" name="nome" required>

            <label for="usuario">Email: </label>
            <input type="email" id="usuario" name="usuario" required>


            <label for="senha">Senha: </label>
            <input type="password" id="senha" name="senha" required>

            <?php
                if($perfil_admin_logado): ?>
                    <select name="perfil" id="perfil" required>
                        <option value="" disabled selected>Selecione o tipo de perfil</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Usuario">Usuario</option>
                    </select> 
            <?php endif; ?>

            <button type="submit">Salvar Usuario</button>
            <button type="reset">Limpar Campos</button>
        </div>
        </form>
        <?php
                if($perfil_admin_logado): ?>
                    <div class="button_voltar">
                        <a href="listaUsuario.php">Voltar para a Lista</a>
                    </div><!--button_voltar-->
        <?php
            else:?>
                    <p style="text-align: center; margin-top: 20px;"> 
                        Já tem conta? <a href="index.html">Voltar para o Login</a> </p>     
        <?php endif; ?>
</body>
</html>