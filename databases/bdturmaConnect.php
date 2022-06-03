<?php
//Não apresentar tela de erros
//ini_set('display_errors','0');

//Criação de uma classe bdturmConnect
class bdTurmaConnect {
    //Declaração de variáveis públicas apenas dentro da classe bdTurmaConnect
    public $host = "localhost";
    public $user = "root";
    public $password = "";
    public $database = "bdturma88";
    // Função para conectar banco de dados
    function connectDB() {
        //As declarações try...catch marcam um bloco de declarações para testar (try),  e especifica uma resposta, caso uma exceção seja lançada. (tratamento de exceções)
        try{
            //$this se refencia a classe neste caso
            $this->conn= new PDO("mysql:host={$this->host};dbname={$this->database};charset=utf8",$this->user,$this->password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $this->conn->query('SET NAMES utf8');
        }
        catch(PDOException $e){
            echo "Não foi possível conectar ao servidor.\n"."<br>";echo"Mensagem: ".utf8_encode($e->getMessage())."\n";
        }
    }
    // Método para executar instruções usadas nas inserções e modificações de dados
    function executeQuery($query){
        try{
            //conecta no banco de dados
            $conn = $this->connectDB();
            //depois da conexão com o banco de dados ele prepara as instruções para executar uma função
            $resultado = $this->conn->prepare($query);
            //para validar se o resultado está correto ou não, aplicaremos um if/else, com as verificações de 0(não funcionou) e 1(funcionou)
            if(!$resultado->execute()){
                $resultado="Não foi possível excutar a instrução";
            }
            else{
                $resultado=array('sucesso'=>1);
            }
        }
        catch(PDOException $e){
            die(print_r($e->getMessage()));
        }
        //para retornar o resultado
        return $resultado;
    }
    // Método para executar instruções usadas nas consultas de dados
    function executeSelectQuery($query){
        try{
            //conecta no banco de dados
            $conn = $this->connectDB();
            //depois da conexão com o banco de dados ele executa as consultas
            $resultado = $this->conn->query($query);
            $resultado ->execute();
            //Um while faz com que os registros sejam percorridos em looping
            //Cada consulta de reslultdo é apresentado baseado nos dados associados
            while ($linha = $resultado->fetch(PDO::FETCH_ASSOC)){
                //array_map transforma os dados para o sistema de acentuação utf8
                $resultset[] = $linha;
            }
            //Se o resultset não estiver vazio apresentar o resultado
            if(!empty($resultset)){
                return $resultset;
            }
        }
        catch(PDOException $e){
            die(print_r($e->getMessage()));
        }
    }
    // Método para buscar o último código
    function executeBuscaCodigoQuery($query){
        try{
            //conecta no banco de dados
            $conn = $this->connectDB();
            //depois da conexão com o banco de dados ele prepara as instruções para executar uma função
            $resultado = $this->conn->prepare($query);
            //para validar se o resultado está correto ou não, aplicaremos um if/else, com as verificações de 0(não funcionou) e 1(funcionou)
            if(!$resultado->execute()){
                $resultado="Não foi possível excutar a instrução";
            }
            else{
                $linha = $resultado->fetch();
                if(!is_null($linha[0])){
                    $resultado=$linha[0]+1;
                }
                else{
                    $resultado = 1;
                }   
            }
        }
        catch(PDOException $e){
            die(print_r($e->getMessage()));
        }
        //para retornar o resultado
        return $resultado;
    }
    function executeProcedureOut($query,$array,$final){
        try{
            $conn = $this->connectDB();
            $stmt = $this->conn->prepare($query);
            foreach($array as $key => $value){
                $stmt->bindValue($key,$value);
            }
            $stmt->execute();
            while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)){
                $resultset[] = $linha;
            }
        }
        catch(PDOException $e){
            die(print_r($e->getMessage()));
        }
        return $resultset;
    }
    function executeProcedure($query,$array){
        try{
            $resultset = [];
            $conn = $this->connectDB();
            $stmt = $this->conn->prepare($query);
            foreach($array as $key => $value){
                $stmt->bindValue($key,$value);
            }
            $stmt->execute();
            while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)){
                $resultset[] = $linha;
            }
        }
        catch(PDOException $e){
            die(print_r($e->getMessage()));
        }
        return $resultset;
    }
}
?>