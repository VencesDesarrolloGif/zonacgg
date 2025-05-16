<?php
// Una variable no definida Y no referenciada (sin contexto de uso); imprime NULL
var_dump($variable_indefinida);

// Uso booleano; imprime 'false' (Vea operadores ternarios para más información sobre esta sintaxis)
echo($booleano_indefinido ? "true\n" : "false\n");

// Uso de una cadena; imprime 'string(3) "abc"'
$cadena_indefinida .= 'abc';
var_dump($cadena_indefinida);

// Uso de un entero; imprime 'int(25)'
$int_indefinido += 25; // 0 + 25 => 25
var_dump($int_indefinido);

// Uso de flotante/doble; imprime 'float(1.25)'
$flotante_indefinido += 1.25;
var_dump($flotante_indefinido);

// Uso de array; imprime array(1) {  [3]=>  string(3) "def" }
$array_indefinida[3] = "def"; // array() + array(3 => "def") => array(3 => "def")
var_dump($array_indefinida);

// Uso de objetos; crea un nuevo objeto stdClass (vea http://www.php.net/manual/en/reserved.classes.php)
// Imprime: object(stdClass)#1 (1) {  ["foo"]=>  string(3) "bar" }
$objeto_indefinido->foo = 'bar';
var_dump($objeto_indefinido);
?>