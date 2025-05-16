<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");


if(!empty ($_POST))
{

	
		//$log = new KLogger ( "ajaxObtenerEmpleadoPorNombre.log" , KLogger::DEBUG );
		$nombre=getValueFromPost("nombre");

		//$log->LogInfo("Valor de variable de NOMBRE que viene de form" . var_export ($nombre, true));


	try{
		
		$usuarios= $negocio -> getUsuariosByName($nombre);
		$response["usuarios"]= $usuarios;

		//$log->LogInfo("Valor de variable de nombre que viene de form" . var_export ($nombre, true));
		//$log->LogInfo("Valor de la variable \$response empleado: " . var_export ($response, true));

	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Empleado";
	}
}

echo json_encode($response);

?>