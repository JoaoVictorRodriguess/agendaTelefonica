<?php
    
    if(isset($_GET['id'])){

        $id = $_GET['id'];//Pega o id

        require_once('config.php');

        //Dados que serão enviados para a API de exclusão
       $postdata = http_build_query(
            array(
                'api_token' => $token,
                'id' => $id //O id do contato a ser excluido
            )
        );

        //Configura as opções da requisição POST
        $opts = array('http' => 
            array(
                'method' => 'POST',
                'header' => 'Content-Type: Application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );

        //Cria o contexto e faz a requisição para a API
        $context = stream_context_create($opts);
        $url = $servidor . 'APIEliminarContato.php';
        $result = file_get_contents($url, false, $context);

        $jsonObj = json_decode($result);//Pega o resultado

        //Se a api redirecionar sucesso, vai pra listaContato, se nao, erro
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