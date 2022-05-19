<?php

require_once("../functions/funcoes.php");

if (isset($_POST["btnEnviar"])){

    $valido=true;
    $campos;
     //Declraração de variáveis
     $nome = $_POST['txtNome'];
     $email = $_POST['txtMail'];
     $fone = $_POST['txtPhone'];
     $endereco =  $_POST['txtEndereco'];
     $cidade = $_POST['txtCidade'];
     $uf = $_POST['txtUF'];
     $cep = $_POST['txtCEP'];
     $bairro=$_POST['txtBairro'];
    
    //Definir o conjunto de dados
    $array = ["nome"=>"{$nome}", "cep"=>"{$cep}", "endereco"=>"{$endereco}","bairro"=>"{$bairro}","cidade"=>"{$cidade}","uf"=>"{$uf}","email"=>"{$email}","telefone"=>"{$fone}"];
    array_push($_SESSION['lista'], $array);
   
    echo $nome.", seus dados foram cadastrados com sucesso";
}

if (isset($_POST["btnListar"])){
     if(!empty($_SESSION['lista'])){
            $exibirdados = listar();
            echo $exibirdados;
    }
    else{
            echo "Não há dados para serem listados";
    }
}


// Apresentar o resultado de duas variáveis
    //Testar botões
        // Verificar se o campo txtNome foi preenchido
        // Se sim, atribuir valores as variáveis
        // if(isset($_POST['txtNome'])) {
           // $fone = $_POST['txtPhone'];
           // $cep = $_POST['txtCEP'];  

           // // apresentar o valor da variável
           // //echo "Telefone: ".$txtPhone."<br>"
           // //echo "Cep: ".$cep."<br>";

           //  // atribuir o resultado na variável $body
              // $body ="=================================================="."<br>";
              // $body = $body."FALE CONOSCO - TESTE EXIBIÇÃO"."<br>";
              // $body = $body."=================================================="."<br>";
              // $body = $body ."Nome: ".$nome."<br>";
              // $body = $body ."Email: ".$email."<br>";
              // $body = $body ."Telefone: ".$fone."<br>";
              // $body = $body."=================================================="."<br>";

            // //apresentar valor da variável
               // echo $body."<br>";

            //chamar a funcão dia_atual 
                // $dia = dia_atual();
                //     echo $dia."<br>";

                // $hora = date('H:i:s');
                //     echo $hora."<br>";

                // if (($hora >= "00:00:00'") && ($hora <= "11:59:59")){
                //         echo "Bom dia !!";
                //     } 

                // elseif (($hora >= "12:00:00'") && ($hora <= "17:59:59")){
                //         echo "Bom tarde !!";
                //     } 

                // else{
                //         echo "Boa noite !!";
                //     }
                //     echo "<br><br>";
            //}
?>