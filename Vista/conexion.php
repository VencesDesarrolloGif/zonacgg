<?php
	$server = "127.0.0.1";
	$user = "root";
	$password = "Admin*gif";
	$bd = "zonacgg";

	$conexion = mysqli_connect($server, $user, $password, $bd);
	if (!$conexion){ 
		die('Error de Conexión: ' . mysqli_connect_errno());	
	}
	mysqli_query($conexion, "SET NAMES 'UTF8'");	
?>

