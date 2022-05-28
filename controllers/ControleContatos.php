<?php 
//Não apresentar tela de erros
//ini_set('display_errors','0');

use FTP\Connection;

require_once("../databases/bdturmaConnect.php");
require_once("../config/SimpleRest.php");

$page_key="";

//Classe que empresta as definições feitas no arquivo SimpleRest
class ContatosRestHandler extends SimpleRest {
    public function ContatosIncluir() {
        if(isset($_POST['txtNome'])) {

            $nome=$_POST['txtNome'];
            $endereco=$_POST['txtEndereco'];
            $fone=$_POST['txtPhone'];
            $bairro=$_POST['txtBairro'];
            $cidade=$_POST['txtCidade'];
            $uf=$_POST['txtUF'];
            $cep=$_POST['txtCEP'];
            $email=$_POST['txtMail'];
            
            //Declarar a variável código como o último dado inserido na coluna
            $query="SELECT codContato from tbcontatos ORDER by codContato desc LIMIT 1";
             //Instanciar a classe BdTurmaConnect
             $dbcontroller = new bdTurmaConnect();
             //Chamar o método para popular a variável código
             $codigo = $dbcontroller->executeBuscaCodigoQuery($query);
            
            //Defnir as instruções SQL

            $query = "INSERT INTO tbContatos (codContato,
                                            nomedoContato,
                                            enderecoContato,
                                            telefoneContato,
                                            bairro,
                                            cidade,
                                            uf,
                                            cep,
                                            emailContato)

                                            VALUES ({$codigo},
                                                    '{$nome}',
                                                    '{$endereco}',
                                                    '{$fone}',
                                                    '{$bairro}',
                                                    '{$cidade}',
                                                    '{$uf}',
                                                    '{$cep}',
                                                    '{$email}')";
            //Instanciar a classe BdTurmaConnect
            $dbcontroller = new bdTurmaConnect();
            //Chamar o método
            $rawData = $dbcontroller->executeQuery($query);
            //Verificar se o retorno está vazio
            if(empty($rawData)){
                $statusCode = 404;
                $rawData = array('sucesso' => 0);
            }
            else{
                $statusCode = 200;
                $rawData = array('sucesso' => 1);  
            }
            //Verificar qual o tipo de cabeçalho web
            $requestContentType = $_POST['HTTP_ACCEPT'];
            $this->setHttpHeaders($requestContentType,$statusCode);
            $result["RetornoDados"] = $rawData;
            //Verificar se o arquivo passado foi json
            if(strpos($requestContentType,'application/json') !== false){
                $response = $this->encodeJson(($result));
                echo $response;
            }
        }
    }

    public function encodeJson($responseData){
        $jsonResponse = json_encode($responseData);
        return $jsonResponse;
    }
}

if(isset($_GET["page_key"])){
    $page_key = $_GET["page_key"];
}

else{
    if(isset($_POST["page_key"])){
        $page_key = $_POST["page_key"];
    }
}

switch($page_key){
    case "Incluir":
        $contatos = new ContatosRestHandler();
        $contatos-> ContatosIncluir();
        break;
}
?>