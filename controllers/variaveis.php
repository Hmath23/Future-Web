<?php

//Verificar se existe valor definido no parâmetro 
if(isset($_GET['cor'])) {
    //Declaração de variáveis
    $nome;
    $idade;
    $a;
    $b;
    $c;
    $cor;

    //Variáveis também podem receber parâmetros
    $cor = $_GET["cor"];

    //Atribuir valor para uma variável
    //Popular a variável
    //variável nome que recebe
    $nome = "Matheus";

    //Apresentar o valor da variável
    echo $nome . "<br>";

    //Concatenar
    echo "Olá, " . $nome . "<br>";

    $idade = 1;

    echo "Idade = " . $idade . "<br>"; 

    $a = $idade + 1;

    echo "a = " . $a . "<br>";

    $b = "2";

    echo "b = " . $b . "<br>";

    $c = $b + $a;

    echo "c = " . $c . "<br>";

    echo "A cor escohida foi " .$cor;

}
?>