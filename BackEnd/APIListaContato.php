<?php

    header("Content-Type: application/json"); //Define que é um json

    if ($_SERVER['REQUEST_METHOD'] == 'POST' )
    { 
        require_once('chave.php');//chamar a chave
        $api_token = $_POST['api_token'];
        if($_POST['api_token'] == $chave ){
            
            require_once('../../dbConnect.php'); //Conexão com o banco

            $query = 'SELECT id, nome, telefone, email FROM contatos'; //Consulta
            
            $stmt = mysqli_prepare($conn, $query);//Prepara a consulta ao banco de dados
            mysqli_stmt_execute($stmt); //Executar 
            mysqli_stmt_store_result($stmt); //Armazena os resultados da consulta na memória para que usar em outras funções.

            mysqli_stmt_bind_result($stmt, $id, $nome, $telefone, $email); // armazenar os dados em variaveis
            
            $response = array(); //Criando um array para carregar os dados da tabela

            //carrega os dados em um array
            if ( mysqli_stmt_num_rows($stmt) > 0 ){
                while(mysqli_stmt_fetch($stmt)){
                    array_push($response, array( "id" => $id,
                                         "nome" => $nome,
                                         "telefone" => $telefone,
                                         "email" => $email ));
                }
            }
        
            echo json_encode($response);//Envia para a tela o array em formato json

            }else{
                echo json_encode(array("auth_token" => false));
            }
    }else{
        echo "Método de requisição inválido";
    }

?>