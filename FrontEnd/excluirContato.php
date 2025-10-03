<?php
    
    session_start();
    require_once('config.php');


     if($perfil_usuario !='Administrador'){
        header("Location: listaContato.php");
        exit();
    }

    if(isset($_GET['id'])){

        $id = $_GET['id'];

       $postdata = http_build_query(
            array(
                'api_token' => $token,
                'perfil' => $perfil_usuario,
                'id' => $id 
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
        $url = $servidor . 'APIEliminarContato.php';
        $result = file_get_contents($url, false, $context);

        $jsonObj = json_decode($result);

        if ($jsonObj->status == 'sucesso') {
            header("Location: listaContato.php");
            exit();
        }else{
            $mensagem_erro = "Não foi possivel excluir este contato";
            header("Location: listaContato.php");
            exit();
        }
    }else{
        header("Location: listaContato.php");
        exit();
    }
    


?>