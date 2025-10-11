<?php

    session_start();
    require_once('config.php');


     if($perfil_usuario !='Administrador'){
        header("Location: listaUsuario.php");
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] =='POST'){

        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $usuario = $_POST['usuario'];
        $perfil = $_POST['perfil'];


        $postdata = http_build_query(
            array(
                'api_token' => $token,
                'perfil_usuario' => $perfil_usuario,
                'id' => $id,
                'nome' => $nome,
                'usuario' => $usuario,
                'perfil' => $perfil
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

        $url = $servidor . 'APIEditarUsuario.php';
        $result = file_get_contents($url, false, $context);
        $jsonObj = json_decode($result);

        // echo "<pre>";
        //     var_dump($result);
        //     echo "</pre>";
        // exit();

        if ($jsonObj && isset($jsonObj->status) && strtolower($jsonObj->status) == 'sucesso') {
            header("Location: listaUsuario.php");
            exit();
        } else {
            echo "Não foi possível editar este contato";
            exit();
        }
    }

    else if(isset($_GET['id'])){
        $id = $_GET['id'];

        require_once('config.php');
        
        $postdata = http_build_query(
            array(
                'api_token' => $token
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

        $url = $servidor . 'APIListaUsuario.php';
        $result = file_get_contents($url, false, $context);

        $usuarios = json_decode($result);

        $usuarios_encontrado = false;
        if (is_array($usuarios)) {
            foreach ($usuarios as $u) {
                if ($u->id == $id) {
                    $nome = $u->nome;
                    $usuario = $u->usuario;
                    $perfil = $u->perfil;
                    $usuarios_encontrado = true;
                    break;
                }
            }
        }

        if(!$usuarios_encontrado){
            header("Location: listaUsuario.php");
            exit();
        }
    }else {
        header("Location: listaUsuario.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/script.js"></script>
    <title>Editar Contato</title>
</head>
<body>
     <div class="header">
        <h1>Editar Usuario</h1>  
    </div>
    <form action="editarUsuario.php" method="POST">
        <div class="cadContato">

            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

            <label for="nome">Nome: </label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required>

            <label for="usuario">Email: </label>
            <input type="email" id="usuario" name="usuario" value="<?php echo htmlspecialchars($usuario); ?>" required>
            
            <select name="perfil" id="perfil" required>
                <option value="" disabled>Selecione o tipo de perfil</option>
                <option value="Administrador"<?php echo ($perfil === 'Administrador') ? 'selected' : ''; ?>> Administrador</option>
                <option value="Usuario"<?php echo ($perfil === 'Usuario') ? 'selected' : ''; ?>>Usuário</option>
            </select>

            <button type="submit">Salvar Alterações</button>
        </div>
    </form>
    <div class="button_voltar">
        <a href="listaUsuario.php">Voltar para a Lista</a>
    </div>
</body>
</html>