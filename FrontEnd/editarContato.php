<?php

    session_start();
    require_once('config.php');


     if($perfil_usuario !='Administrador'){
        header("Location: listaContato.php");
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] =='POST'){

        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];


        $postdata = http_build_query(
            array(
                'api_token' => $token,
                'perfil' => $perfil_usuario,
                'id' => $id,
                'nome' => $nome,
                'telefone' => $telefone,
                'email' => $email
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

        $url = $servidor . 'APIEditarContato.php';
        $result = file_get_contents($url, false, $context);
        $jsonObj = json_decode($result);

        if ($jsonObj->status == 'sucesso') {
            header("Location: listaContato.php");
            exit();
        }else{
            $mensagem_erro = "Não foi possivel editar este contato";
            header("Location: listaContato.php");
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

        $url = $servidor . 'APIListaContato.php';
        $result = file_get_contents($url, false, $context);

        $contato = json_decode($result);

        $contato_encontrado = false;
        if (is_array($contato)) {
            foreach ($contato as $c) {
                if ($c->id == $id) {
                    $nome = $c->nome;
                    $telefone = $c->telefone;
                    $email = $c->email;
                    $contato_encontrado = true;
                    break;
                }
            }
        }

        if(!$contato_encontrado){
            header("Location: listaContato.php");
            exit();
        }
    }else {
        header("Location: listaContato.php");
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
        <h1>Editar Contato</h1>  
    </div>
    <form action="editarContato.php" method="POST">
        <div class="edContato">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>" disabled>

            <label for="nome">Nome: </label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required>

            <label for="telefone">Telefone: </label>
            <input type="text" id="telefone" oninput="this.value = formatarTelefone(this.value)" maxlength="25" name="telefone" value="<?php echo htmlspecialchars($telefone); ?>" required>

            <label for="email">Email: </label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

            <button type="submit">Salvar Alterações</button>
        </div>
    </form>
    <div class="button_voltar">
        <a href="listaContato.php">Voltar para a Lista</a>
    </div>
    <script src="assets/js/script.js"></script>
</body>
</html>