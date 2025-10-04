<?php

    session_start();
    require_once('config.php');

    if($perfil_usuario !='Administrador'){
        header("Location: listaContato.php");
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];

        $chave_unica = uniqid(); 

        $postdata = http_build_query(
            array(
                'api_token' => $token,
                'perfil' => $perfil_usuario,
                'nome' => $nome,
                'telefone' => $telefone,
                'email' => $email,
                'chave_unica' => $chave_unica 
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

        $url = $servidor. 'APIAdicionarContato.php'; 

        $result = file_get_contents($url, false, $context);

        $jsonObj = json_decode($result); 

        if($jsonObj -> status == 'sucesso'){
            header("Location: listaContato.php");
            exit();
        }else{
            $mensagem_ero = $jsonObj -> mensagem;
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/novoPadrão.css">
    <script src="assets/js/script.js"></script>
    <title>Adicionar Contato</title>
</head>
<body>
    <div class="header">
        <h1>Adicionar Novo Contato</h1>
    </div><!--header-->
    <form action="adicionarContato.php" method="POST">
        <div class="addContato">
            <label for="nome">Nome: </label>
            <input type="text" id="nome" name="nome" required>

            <label for="telefone">Telefone: </label>
            <input type="text" id="telefone" value="" oninput="this.value = formatarTelefone(this.value)" maxlength="25" name="telefone" required>

            <label for="email">Email: </label>
            <input type="email" id="email" name="email" required>

            <button type="submit">Salvar Contato</button>
        </div><!--addContato-->
    </form>
    <div class="button_voltar">
        <a href="listaContato.php">Voltar para a Lista</a>
    </div><!--button_voltar-->
    <script src="assets/js/script.js"></script>
</body>
</html>