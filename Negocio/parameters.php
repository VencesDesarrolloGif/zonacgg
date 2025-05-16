<?php

require_once("..\Persistencia\Cliente.class.php");

//print_r($_POST);


$numeroCliente=$_POST['numeroCliente'];
$razonSocial=$_POST['razonSocial'];
$nombreComercial= $_POST['nombreComercial'];


echo ($_POST);

	$cliente= new Cliente();

	$cliente->addCliente($numeroCliente,$razonSocial , $nombreComercial );
	
?>