<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_obtenerempleadoPorIdFirma.log" , KLogger::DEBUG );
if(!empty ($_POST))
{
	$empleadoId=getValueFromPost("numeroEmpleado");
	$caso=getValueFromPost("caso");
	$usuario = $_SESSION ["userLog"]["usuario"];
	$empleadoidd = explode("-", $empleadoId);
     $empleadoEntidad=$empleadoidd[0];
     $empleadoConsecutivo=$empleadoidd[1];
     $empleadoCategoria=$empleadoidd[2];
	try{
	
	if($caso == "0"){
		$empleado= $negocio -> negocio_obtenerEmpleadoPorIdFirmaBaja($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria);
		$response["empleado"]= $empleado;
	}else{
		$datosUsuario = $negocio -> obtenerIdUsuarioLogeado($usuario);
		if($datosUsuario != $empleadoId){
			$response["status"]="error"; 
			$response["menssaje"]="El número de empleado dueño de la sesión es diferente al número de empleado con el que quiere firmar";
		}else{
			$empleado= $negocio -> negocio_obtenerEmpleadoPorIdFirmaBaja($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria);
			$response["empleado"]= $empleado;	
		}
	}
	//$log->LogInfo("Valor de la variable datosUsuario: " . var_export ($datosUsuario, true));
	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Empleado";
	}
}

echo json_encode($response);

?>