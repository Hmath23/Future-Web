<?php
//Definir a timezone padrão
//Extraído de:
//https://www.w3schools.com/php/php_date.asp - Get Your Time Zone

date_default_timezone_set("America/Sao_Paulo");

//Iniciar uma Session
    session_start();

//Se a session não existir, será criada
    if(empty($_SESSION['lista'])){
        $_SESSION['lista']=[];
    }

    function listar(){
        // echo "=========================================="."<br>";
        // echo "Espelho de Array - Apresentação didática <br>";
        // echo "=========================================="."<br>";
        // print_r($_SESSION['lista']);
        // echo"<br><br>";

        // $qtderegistros = count($_SESSION['lista']);
        // echo "Quantidade de Registros no Array = ".$qtderegistros;
        // echo"<br><br>";
        // echo "=========================================="."<br>";
        // echo "Tabela com dados <br>";
        // echo "=========================================="."<br>";
        // echo "<br>";

        $tabela="<table border='1'>
                    <thead>
                        <tr>
                            <th>NOME</th>
                            <th>CEP</th>
                            <th>ENDEREÇO</th>
                            <th>BAIRRO</th>
                            <th>CIDADE</th>
                            <th>UF</th>
                            <th>EMAIL</th>
                            <th>TELEFONE</th>
                        </tr>
                    </thead>
                    <tbody>";

        $retorno=$tabela;
        
        foreach($_SESSION['lista'] as $linhadoarray){
            $retorno.="<tr>";
            foreach($linhadoarray as $coluna=>$conteudodacoluna){
                $retorno.="<td>".$conteudodacoluna."</td>";
            }
            $retorno.="</tr>";
        }
        $retorno.="</tbody></table>";
        session_destroy();
        return $retorno;  
}

//Verificar os dias da semana
//Extraído de:
//http://www.linhadecodigo.com.br/artigo/3565/trabalhando-com-funcoes-em-php.asp
function dia_atual(){
    $hoje = getdate();
    //return $hoje;
    //print_r($hoje);
    //Apresentar os dias da semana
    switch($hoje["wday"]){
        case 0:
            return "Domingo";
        break;
        case 1:
            return "Segunda-feira";
        break;
        case 2:
            return "Terça-feira";
        break;
        case 3:
            return "Quarta-feira";
        break;
        case 4:
            return "Quinta-feira";
        break;
        case 5:
            return "Sexta-feira";
        break;
        case 6:
            return "Sábado";
        break;
        }
}
?>