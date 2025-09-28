<?php

    session_start();
    require_once("config.php");

    $postdata = http_build_query(
        array('api_token' => $token)
    );

    $opts = array('http' => 
        array(
            'method' => 'POST',
            'header' => 'Content-Type: Application/x-www-form-urlencoded',
            'content' => $postdata));
    
    $context = stream_context_create($opts);

    $url = $servidor . 'APIListaContato.php';
    $result = file_get_contents($url, false, $context);

    $jsonObj = json_decode($result);


?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/script.js"></script>
    <title>Agenda de Contatos</title>
</head>
<body>
    <h1>Agenda de Contatos </h1>
    <div class="button_add">
        <a href="adicionarContato.php">Adicionar Novo Contato</a>
    </div>
    <table border="1" style="width: 100%">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Telefone</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if (is_array($jsonObj) && !empty($jsonObj)){
                    foreach ( $jsonObj as $contato){
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($contato->nome) . "</td>";
                        echo "<td>" . htmlspecialchars($contato->telefone) . "</td>";
                        echo "<td>" . htmlspecialchars($contato->email) . "</td>";
                        echo "<td>";
                        echo "<a class='btn-editar' href='editarContato.php?id=" . $contato->id . "'>Editar</a>";
                        echo "<a class='btn-excluir' href='excluirContato.php?id=" . $contato->id . "'>Excluir</a>";
                        echo "</td>";
                        echo "</tr>";  
                    }
                }else{
                    echo "<tr><th colspan='4'>Nenhum contato encontrado.</td></tr>";
                }
            ?>
        </tbody>
    </table>
</body>
</html>