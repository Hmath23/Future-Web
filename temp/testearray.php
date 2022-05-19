<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste-Array</title>
</head>
<body>

<?php

    echo "Teste de Array <br>";

    //Atribuição de um array
    $array_numeros = array(5,10,15,20,25);

    //Apresentar os dados do array
    print_r($array_numeros);
    
    echo "<br><br>";

    //Verificar a quantidade de itens
    $qtdeitens = count($array_numeros);

    echo "A quantidade de itens no array é: ". $qtdeitens."<br><br>";

    //Apresentar os dados utlizando estrtura de repetição
    //For
    //Para cada valor de i realizar uma contagem começando em zero e acrescentando um valor a i enquanto i <qtdeitens.
    //Em seguida, apresentar os valores dos índices e o valor para cada índice.
    
    for($i=0;$i < $qtdeitens;$i++){
        echo "Para o índice ". $i. " o valor é ".$array_numeros[$i]."<br>";
    }

    echo "<br>";

    //Foreach
    //Para cada valor no array, apresentá-lo como um valor de i
    //Em seguida, apresentar o valor
    foreach($array_numeros as $i){
        echo $i."<br>";
    }

    echo "<br>";

    //Vetor de duas dimensões
    $salarios = array();
    $salarios["Claudia"] = 1000;
    $salarios["Natalia"] = 5000;
    $salarios["Daniel"] = 1500;
    $salarios["Paulo"] = 3300;

    //Para cada valor de array $salário, o índice "nome" se torna $key_arr e o valor "salário" de torna $var_arr

    foreach($salarios as $key_arr => $var_arr){
        echo "O salário de ".$key_arr. " é igual a ".$var_arr."<br>";
    }

    echo "<br>";

    //Vetor de 3 Dimensões
    $produtos = array(
        array("Maça",20,10),
        array("Banana",10,15),
        array("Laranja",15,7),
        array("Pera",20,5)
    );

    //for dentro de outro for
    //Para linha executar a contagem.
    //Para cada coluna fazer uma contagem e apresentar os valores de produtos, linhas e colunas

    for($linha=0; $linha < 4; $linha++){
        echo"<p><b>Linha Número: ". $linha ."</b></p>";
        echo"<ul>";
            for($coluna=0; $coluna < 3; $coluna++){
                echo "<li>".$produtos[$linha][$coluna]."</li>";
            }

        echo"</ul>";
    }

    echo "<br>";

    $idade = array("Marcos"=>"35","Suzana"=>"40","Joel"=>"45");
    
    session_start();

    //Se a session não existir, será criada
    if (empty($_SESSION['lista'])){
        $_SESSION['lista']=[];
    }
    
    array_push($_SESSION['lista'],$idade);
    
    $tabela = "<table border='1'>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Idade</th>
                    </tr>
                </thead>
                <tbody>";

    $retorno = $tabela;

    //foreach dentro de outro foreach

    //print_r($_SESSION['lista']);

    //Para cada valor da variável session, passar para a variável $linhadoarray
    //Para cada valor da variável $linhasdoarray apresentar o índice ($key_nome) e o valor ($var_idade)

    foreach ($_SESSION['lista'] as $linhadoarray){
        foreach($linhadoarray as $key_nome => $var_idade){
            $retorno.="<tr>";
            $retorno.= "<td>".$key_nome."</td>";
            $retorno.= "<td>".$var_idade."</td>";
            $retorno.="</tr>";
        }
    }
   
        $retorno.="<tr>";
        $retorno.= "<td> ***** </td>";
        $retorno.= "<td> ***** </td>";
        $retorno.="</tr>";

        //A variável armazena as keys a variável idade
        $indice = array_keys($idade);
        //A função classifica os valores em ordem crescente
        rsort($indice);

        //Enquanto não estiver vazio, faça
        while (!empty($indice)){
            $retorno.="<tr>";
            //Pega os "nomes" de dentro da variável índice e coloca na variável $nomecoluna
            $nomecoluna = array_pop($indice);
            $retorno.= "<td>".$nomecoluna."</td>";
            $retorno.= "<td>".$idade[$nomecoluna]."</td>";
            $retorno.="</tr>";
        }

        $retorno.="<tr>";
        $retorno.= "<td> ***** </td>";
        $retorno.= "<td> ***** </td>";
        $retorno.="</tr>";
        
        $indice=array_keys($idade);

        do {
            $retorno.="<tr>";
            //Pega os "nomes" de dentro da variável índice e coloca na variável $nomecoluna
            $nomecoluna = array_pop($indice);
            $retorno.= "<td>".$nomecoluna."</td>";
            $retorno.= "<td>".$idade[$nomecoluna]."</td>";
            $retorno.="</tr>";
        }
        
        while (!empty($indice));

        $retorno.="<tr>";
        $retorno.= "<td> ***** </td>";
        $retorno.= "<td> ***** </td>";
        $retorno.="</tr>";

        foreach ($idade as $coluna=>$conteudodacoluna){
            $retorno.="<tr>";
            $retorno.= "<td>".$coluna."</td>";
            $retorno.= "<td>".$conteudodacoluna."</td>";
            $retorno.="</tr>";
        }

        
    $retorno.="</tbody></table>";
    echo $retorno;





    session_destroy();
?>
</body>
</html>