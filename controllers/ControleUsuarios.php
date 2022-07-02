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
            
            $query = "CAll spInserirUsuarios(:pnomeusuario,:pemailusuario,:psenhausuario)";

            $array = array(":pnomeusuario"=>"{$nome}",":pemailusuario"=>"{$mail}",":psenhausuario"=>"{$senha}");

            //Instanciar a classe BdTurmaConnect
            $dbcontroller=new bdTurmaConnect();
            //Chamar o método
            $rawData = $dbcontroller->executeProcedure($query,$array);

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

    public function UsuariosConsultar() {
        if(isset($_POST['txtNomeUsuario'])) {

            $nome = $_POST['txtNomeUsuario'];
        
            //Chamar o procedure de Conslta de contatos a partir da variável nome
            $query = "CALL spConsultarUsuarios(:pnomeusuario)";
            //Definir o conjunto de dados
            $array = array(":pnomeusuario"=>"{$nome}");
            //Instanciar a classe BdTurmaConnect
            $dbcontroller = new bdTurmaConnect();
            //Chamar o método execute procedure trazendo a partir das variáveis query e array
            $rawData = $dbcontroller->executeProcedure($query,$array);
            //Verificar se o retorno está vazio
            if(empty($rawData)){
                $statusCode = 404;
                $rawData = array('sucesso' => 0);
            }
            else{
                $statusCode = 200;
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

    public function UsuariosValidar() {
        if(isset($_POST['txtNomeUsuario'])) {

            $nome = $_POST['txtNomeUsuario'];
            $senha = $_POST['txtSenhaUsuario'];
        
            //Chamar o procedure de Conslta de contatos a partir da variável nome
            $query = "CALL spValidarUsuarios(:pnomeusuario,:psenhausuario)";
            //Definir o conjunto de dados
            $array = array(":pnomeusuario"=>"{$nome}",":psenhausuario"=>"{$senha}");
            //Instanciar a classe BdTurmaConnect
            $dbcontroller = new bdTurmaConnect();
            //Chamar o método execute procedure trazendo a partir das variáveis query e array
            $rawData = $dbcontroller->executeProcedure($query,$array);
            //Verificar se o retorno está vazio
            if(empty($rawData)){
                $statusCode = 404;
                $rawData = array('sucesso' => 0);
            }
            else{
                $statusCode = 200;
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

    public function encodeJson($responseData) {
        $jsonResponse=json_encode($responseData,JSON_UNESCAPED_UNICODE);
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

if (isset($_POST['btnCadast'])){
    $page_key = "Incluir";
    $_POST['HTTP_ACCEPT'] = "application/json";
}

switch($page_key) {
    case "Consultar":
        $Usuarios = new UsuariosRestHandler();
        $Usuarios-> UsuariosConsultar();
        break;
    case "Incluir":
        $Usuarios=new UsuariosRestHandler();
        $Usuarios->UsuariosIncluir();
    break;
    case "Validar":
        $Usuarios=new UsuariosRestHandler();
        $Usuarios->UsuariosValidar();
    break;
}

?>