<?php

    session_start();
    require_once("config.php");
	$postdata = http_build_query(
			array( 'api_token' => 'TokendeTeste',
                   'api_usuario' => $_POST['usuario'],
                   'api_senha' => $_POST['senha']) );
			
	$opts = array('http' => 
	    array(
          'method' => 'POST',
		  'header' => 'Content-type: Application/x-www-form-urlencoded',
		  'content' => $postdata ) );

	$context = stream_context_create($opts);
	$result = file_get_contents( $servidor . 'APILogin.php', false, $context);
		
	$jsonObj = json_decode($result);

    if ($jsonObj && !empty($jsonObj->logou)) {
        $_SESSION['chave'] = $jsonObj->chave;
        if(isset($jsonObj->perfil)){
            $_SESSION['perfil'] = $jsonObj->perfil;
        }
        header("Location: listaContato.php");
        exit();
    }else{
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/novoPadrão.css">
    <title>Login</title>
</head>
<body>
    <div class="header">
        <h1>Login</h1>  
    </div>
    <div class="error-message">
        Usuário ou senha inválida
    </div>
    <form action="login.php" method="POST">
        <div class="login">
            <label for="usuario">Usuário</label>
            <input type="text" id="usuario" name="usuario" required>

            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required>

            <button type="submit">Entrar</button>
        </div>
    </form>
</body>
</html>

<?php
    }
?>