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






}

?>