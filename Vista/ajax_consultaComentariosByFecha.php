<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");
$fecha1=getValueFromPost("fecha1");
$fecha2=getValueFromPost("fecha2");

if(!empty ($_POST))
{
      //$log = new KLogger ( "ajaxObtenerPuntosServiciosTable.log" , KLogger::DEBUG );
	try{
		$listaComentarios= $negocio -> getComentariosGuardiasByPeriodo($fecha1, $fecha2);
            $response["data"]= $listaComentarios;

		//$log->LogInfo("Valor de variable de estatusEmpleado que viene de form" . var_export ($estatusEmpleado, true));
		//$log->LogInfo("Valor de la variable \$response punto: " . var_export ($response, true));
      } 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se pudo obtener lista de comentarios";
	}
}
echo json_encode($response);
?>

