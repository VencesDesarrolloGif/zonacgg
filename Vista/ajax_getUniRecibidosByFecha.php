<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
$response = array("status" => "success");
// $log = new KLogger ( "ajax_getUniformesRecibidos.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable entidadConsulta : " . var_export ($entidadConsulta, true));
$fecha1=getValueFromPost("fechaConsulta1");
$fecha2=getValueFromPost("fechaConsulta2");
$tipoConsulta=getValueFromPost("tipoR");
$entidadConsulta=$_SESSION ["userLog"]["entidadFederativaUsuario"];
$sucursalesActuales = array();
	
try{
		for ($i = 0; $i < count($_SESSION['userLog']['sucursalesUsuario']); $i++) {
		    $sucursalesActuales[] = $_SESSION['userLog']['sucursalesUsuario'][$i];  // Guardamos solo los idSucursalUsr
		}

		$sucursalesArreglo = implode(',', $sucursalesActuales);
		$lista= $negocio -> getUniformesRecibidosByFecha2($fecha1,$fecha2,$tipoConsulta,$entidadConsulta,$sucursalesArreglo);
// $log->LogInfo("Valor de la variable lista : " . var_export ($lista, true));
// $log->LogInfo("Valor de la variable count : " . var_export (count($lista), true));
		$response["data"]= $lista;
	} 
	catch( Exception $e ){
		$response["status"]="error";
		$response["error"]="No se pudieron obtener uniformes recibidos";
	}
echo json_encode($response);
?>