<?php

    if($_SERVER['REQUEST_METHOD'] =='POST'){

        require_once('config.php');

        //pega os dados do formulario
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];


        $postdata = http_build_query(
            array(
                'api_token' => $token,
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

        // Se a API retornar sucesso, redireciona para a lista
        if ($jsonObj->status == 'sucesso') {
            header("Location: listaContato.php");
            exit();
        }else{
            $mensagem_erro = "Não foi possivel editar este contato";
            header("Location: listaContato.php");
            exit();
        }
    }

    //verifica se a URL contem o 'id'
    else if(isset($_GET['id'])){
        $id = $_GET['id'];

        require_once('config.php');
        
        //requisição para API pegar os dados deste contato
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

        $contato = json_decode($result);//decodifica a resposta da API

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
        // Se a página for acessada sem um ID, redireciona para a lista de contatos
        header("Location: listaContato.php");
        exit();
    }
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Contato</title>
</head>
<body>
    <h1>Editar Contato</h1>
    <form action="editarContato.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

        <label for="nome">Nome: </label><br>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required><br><br>

        <label for="telefone">Telefone: </label><br>
        <input type="text" id="telefone" name="telefone" value="<?php echo htmlspecialchars($telefone); ?>" required><br><br>

        <label for="email">Email: </label><br>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br><br>

        <button type="submit">Salvar Alterações</button>
    </form>
    <br>
    <a href="listaContato.php">Voltar para a Lista</a>
</body>
</html>