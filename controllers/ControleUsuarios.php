<?php //Não apresentar tela de erros
//ini_set('display_errors','0');

use FTP\Connection;

require_once("../databases/bdturmaConnect.php");
require_once("../config/SimpleRest.php");

$page_key="";

//Classe que empresta as definições feitas no arquivo SimpleRest
class UsuariosRestHandler extends SimpleRest {
    public function UsuariosIncluir() {
        if(isset($_POST['txtNomeUsuario'])) {
            $nome=$_POST['txtNomeUsuario'];
            $mail=$_POST['txtEmailUsuario'];
            $senha=$_POST['txtSenhaUsuario'];
            
            //Instanciar a classe BdTurmaConnect
            $dbcontroller=new bdTurmaConnect();
            //Chamar o método
            $rawData=$dbcontroller->executeQuery($query);

            //Verificar se o retorno está vazio
            if(empty($rawData)) {
                $statusCode=404;
                $rawData=array('sucesso'=> 0);
            }

            else {
                $statusCode=200;
                $rawData=array('sucesso'=> 1);
            }

            //Verificar qual o tipo de cabeçalho web
            $requestContentType=$_POST['HTTP_ACCEPT'];
            $this->setHttpHeaders($requestContentType, $statusCode);
            $result["RetornoDados"]=$rawData;

            //Verificar se o arquivo passado foi json
            if(strpos($requestContentType, 'application/json') !==false) {
                $response=$this->encodeJson(($result));
                echo $response;
            }
        }
    }

    public function encodeJson($responseData) {
        $jsonResponse=json_encode($responseData);
        return $jsonResponse;
    }
}

if(isset($_GET["page_key"])) {
    $page_key=$_GET["page_key"];
}

else {
    if(isset($_POST["page_key"])) {
        $page_key=$_POST["page_key"];
    }
}

switch($page_key) {
    case "Incluir":
        $Usuarios=new UsuariosRestHandler();
        $Usuarios->UsuariosIncluir();
    break;
}

?>