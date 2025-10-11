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
        $endereco = $_POST['endereco'];
        $num = $_POST['num'];
        $CEP = $_POST['CEP'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];

        $chave_unica = uniqid(); 

        $postdata = http_build_query(
            array(
                'api_token' => $token,
                'perfil' => $perfil_usuario,
                'nome' => $nome,
                'telefone' => $telefone,
                'email' => $email,
                'endereco' => $endereco,
                'num' => $num,
                'CEP' => $CEP,
                'cidade' => $cidade,
                'estado' => $estado,
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
            if(isset($_POST['acao'])){
                if($_POST['acao'] == 'salvar'){
                    header("Location: listaContato.php");
                    exit();
                }else if($_POST['acao'] == 'salvarNovo'){
                    header("Location: " .$_SERVER['PHP_SELF']);
                    exit();
                }
            }else{
                $mensagem_ero = $jsonObj -> mensagem;
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
            <input type="text" id="nome" name="nome" placeholder="Digite seu nome completo" required>

            <label for="telefone">Telefone: </label>
            <input type="text" id="telefone" value="" oninput="this.value = formatarTelefone(this.value)" maxlength="25" name="telefone" placeholder="Digite apenas números (ex: 11912345678)"required>

            <label for="email">Email: </label>
            <input type="email" id="email" name="email" placeholder="exemplo@email.com" required>

            <div class="endereco">
                <label for="CEP">CEP:</label>
                <input type="text" class="CEP" id="CEP" oninput ="buscarCEP(this.value)" name="CEP" placeholder="Digite seu CEP" required>

                <div class="linha-endereco">
                    <div class="campo-endereco">
                        <label for="endereco">Endereço:</label>
                        <input type="text" class="endereco" id="endereco" name="endereco" maxlength="150" placeholder="Rua, avenida ou logradouro" required>
                    </div>

                    <div class="campo-numero">
                        <label for="num">Número:</label>
                        <input type="text" class="num" id="num" maxlength="6" name="num" placeholder="Nº" required>
                    </div>
                </div>
                <div class="linha-estado">
                    <div class="campo-cidade">
                        <label for="cidade">Cidade:</label>
                        <input type="text" class="cidade" id="cidade" name="cidade" placeholder="Cidade" required>
                    </div>
                    <div class="campo-estado">
                        <label for="estado">Estado:</label>
                        <input type="text" class="estado" id="estado" name="estado" maxlength="150" placeholder="Estado" required>
                    </div>
                </div>
            </div>


            <button type="submit" name="acao" value="salvar">Salvar Usuario</button>
            <button type="submit" name="acao" value="salvarNovo">Salvar e cadastrar um novo</button>
            <button type="reset">Limpar Campos</button>
        </div><!--addContato-->
    </form>
    <div class="button_voltar">
        <a href="listaContato.php">Voltar para a Lista</a>
    </div><!--button_voltar-->
    <script src="assets/js/script.js"></script>
</body>
</html>