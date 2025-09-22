<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        require_once('config.php');

        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];

        $chave_unica = uniqid(); //gerar uma chave unica para a requisição

        $postdata = http_build_query(
            array(
                'api_token' => $token,
                'nome' => $nome,
                'telefone' => $telefone,
                'email' => $email,
                'chave_unica' => $chave_unica //a nova chave
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

        $url = $servidor. 'APIAdicionarContato.php'; //A url da API

        $result = file_get_contents($url, false, $context);

        $jsonObj = json_decode($result); //Decodificar a resposta da API

        //Verificar se a operação foi bem sucedida
        if($jsonObj -> status == 'sucesso'){
            header("Location: listaContato.php"); //redireciona pra pagina de listagem
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
    <title>Adicionar Contato</title>
</head>
<body>
    <h1>Adicionar Novo Contato</h1>
    <?php if (isset($mensagem_ero)): ?>
        <p style="color:red;"><?php echo htmlspecialchars($mensagem_ero); ?></p>
        <?php endif; ?>
    <form action="adicionarContato.php" method="POST">
        <label for="nome">Nome: </label><br>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="telefone">Telefone: </label><br>
        <input type="text" id="telefone" name="telefone" required><br><br>

        <label for="email">Email: </label><br>
        <input type="email" id="email" name="email" required><br><br>

        <button type="submit">Salvar Contato</button>
    </form>
    <br>
    <a href="listaContato.php">Voltar para a Lista</a>
</body>
</html>