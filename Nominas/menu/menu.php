<?php

session_start ();
	$usuario = $_SESSION;
	if ($usuario == null)
{

//	echo "<script> var a=$usuario;  alert(a);</script>";

    header("Location: ../login/login.html");    
}else{

	//echo "<script>alert('entro');</script>";
 // echo "<script>   alert($usuario);</script>";
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
  <title>Iniciar Sesion</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

 


	</head>
	<body>
		
<div class="errorMsg">
</div>

		<?php
	include '../encabezado.html';	
	?>	


  <link href="../../Vista/css/bootstrap.css" rel="stylesheet">
  <style type="text/css">
    
  </style>
  <link rel="stylesheet" 
		      href="../css/bootstrap-3.3.5/dist/css/bootstrap.min.css"><!--el que guss ocupa-->
  <link href="../../Vista/css/bootstrap-responsive.css" rel="stylesheet">
  <link href="../../Vista/css/login.css" rel="stylesheet">
  <link href="../../Vista/css/animate-custom.css" rel="stylesheet">
  <script type="text/javascript" src="../../Vista/js/jquery-2.1.1.js"></script>
  <script type="text/javascript" src="../../Vista/js/bootstrap.js"></script>
  <!--script src="prueba.js"></script-->
