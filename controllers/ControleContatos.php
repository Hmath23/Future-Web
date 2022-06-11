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
                $query = "SELECT codContato from tbcontatos ORDER by codContato desc LIMIT 1";
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
                $requestContentType = $_GET['HTTP_ACCEPT'];
                $this->setHttpHeaders($requestContentType,$statusCode);
                $result["RetornoDados"] = $rawData;
                //Verificar se o arquivo passado foi json
                if(strpos($requestContentType,'application/json') !== false){
                    $response = $this->encodeJson(($result));
                    echo $response;
                }
            }
    }

    public function ContatosConsultar() {
            if(isset($_POST['txtNome'])) {

                $nome = $_POST['txtNome'];
            
                //Chamar o procedure de Conslta de contatos a partir da variável nome
                $query = "CALL spConsultarContatos(:pnome)";
                //Definir o conjunto de dados
                $array = array(":pnome"=>"{$nome}");
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
                    // $this->mostrarContatos($response);
                     echo $response;
                }
            }
            
    }

    public function encodeJson($responseData){
        $jsonResponse = json_encode($responseData,JSON_UNESCAPED_UNICODE);
        return $jsonResponse;
    }

    // public function MostrarContatos($jsonObj){
    //     // $strLista = "<table border=1><tbody>"."\n"."<tr><th>Nome</th><th>Bairro</th></tr>"."\n";
    //     //Receber dados em JSON
    //     $dados = json_decode($jsonObj);
    //     foreach($dados->RetornoDados as $lista){
    //         // $strLista = "<tr>"."<td>".$lista->nomedoContato."</td>"."<td>".$lista->bairro."</td>"."<tr>";
    //     }
    //     // $fp = fopen('result.json','w');
    //     // fwrite($fp,json_encode($strLista));
    //     // fclose($fp);
    //     //  echo $strLista;
    // //     $referer = $_SERVER['HTTP_REFERER'];
    // //     header("Location: $referer");
    // }
}

if(isset($_GET["page_key"])){
    $page_key = $_GET["page_key"];
}

else{
    if(isset($_POST["page_key"])){
        $page_key = $_POST["page_key"];
    }
}

if (isset($_POST['btnEnviar'])){
    $page_key = "Incluir";
    $_POST['HTTP_ACCEPT'] = "application/json";
}

if (isset($_POST['btnListar'])){
    $page_key = "Consultar";
    $_POST['HTTP_ACCEPT'] = "application/json";
}

switch($page_key){
    case "Consultar":
        $contatos = new ContatosRestHandler();
        $contatos-> ContatosConsultar();
        break;
    case "Incluir":
        $contatos = new ContatosRestHandler();
        $contatos-> ContatosIncluir();
        break;
}
?>