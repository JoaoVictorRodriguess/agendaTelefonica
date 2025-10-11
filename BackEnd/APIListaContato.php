<?php

    header("Content-Type: application/json"); 

    if ($_SERVER['REQUEST_METHOD'] == 'POST' ){
         
        require_once('chave.php');
        $api_token = $_POST['api_token'];
        if($api_token == $hash ){
            
            require_once('../../dbConnect.php'); 

            $query = 'SELECT id, nome, telefone, email, endereco, num, CEP, cidade, estado FROM contatos'; 
            
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_execute($stmt); 
            mysqli_stmt_store_result($stmt); 

            mysqli_stmt_bind_result($stmt, $id, $nome, $telefone, $email, $endereco, $num, $CEP, $cidade, $estado);
            
            $response = array();

            if ( mysqli_stmt_num_rows($stmt) > 0 ){
                while(mysqli_stmt_fetch($stmt)){
                    array_push($response, array( "id" => $id,
                                         "nome" => $nome,
                                         "telefone" => $telefone,
                                         "email" => $email,
                                         "endereco" => $endereco,
                                         "num" => $num,
                                         "CEP" => $CEP,
                                         "cidade" => $cidade,
                                         "estado" => $estado, ));
                }
            }
        
            echo json_encode($response);

            }else{
                echo json_encode(array("auth_token" => false));
            }
    }else{
        echo "Método de requisição inválido";
    }

?>