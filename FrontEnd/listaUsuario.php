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

    $url = $servidor . 'APIListaUsuario.php';
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
    <title>Consulta de Usuarios</title>
</head>
<body>
    <div class="header">
        <h1>Consulta de Usuarios</h1>
        <div class="button_exit">
                <a href="logout.php">Sair</a>
        </div>
    </div>
    <?php if($perfil_usuario == 'Administrador'):?>
    <div class="button_add">
        <a href="cadastrarUsuario.php">Novo Usuario</a>
    </div>
    <?php endif; ?>
    <div class="listaUsuario">
        <table border="1" style="width: 100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Usuario</th>
                    <th>Perfil</th>
                    <?php
                        if($perfil_usuario == 'Administrador'): ?>
                    <th>Ações</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (is_array($jsonObj) && !empty($jsonObj)){
                        foreach ( $jsonObj as $usuarios){
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($usuarios->id) . "</td>";
                            echo "<td>" . htmlspecialchars($usuarios->nome) . "</td>";
                            echo "<td>" . htmlspecialchars($usuarios->usuario) . "</td>";
                            echo "<td>" . htmlspecialchars($usuarios->perfil) . "</td>";
                            if($perfil_usuario =='Administrador'){
                                echo "<td>";
                                echo "<a class='btn-editar' href='editarUsuario.php?id=" . $usuarios->id . "'>Editar</a>";
                                echo "<a class='btn-excluir' href='excluirUsuario.php?id=" . $usuarios->id . "'>Excluir</a>";
                                echo "</td>";
                            }
                            echo "</tr>";  
                        }
                    }else{
                        $colspan = ($perfil_usuario == 'Administrador') ? 5 : 4;
                        echo "<tr><td colspan='" . $colspan . "'>Nenhum contato encontrado.</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
    <div class="button_voltar">
        <a href="listaContato.php">Voltar para a Lista</a>
    </div><!--button_voltar-->
</body>
</html>