<?php
session_start();
  
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");

	
		//$log = new KLogger ( "ajax_ObtenerPlantillaParaAdmin.log" , KLogger::DEBUG );
		$tipoTurnoPlantillaId=getValueFromPost("tipoTurnoPlantillaId");  
		$puntoServicioPlantillaId=getValueFromPost("puntoServicioPlantillaId"); 
		$puestoPlantillaId=getValueFromPost("puestoPlantillaId");

		//$log->LogInfo("Valor de variable de NOMBRE que viene de form" . var_export ($puntoServicio, true));


	try{
		// se cambio a la funcion de los operativos debido a los requerimientos de que ahora tambin las plantillas administrativas van a filtrarse por el espacio que queda anteriormente no se filtrabaj dejando meter a mas administrativos excediendo las plantillas seleccionadas 
		$datos = $negocio -> getplantillasparaselectorcontrataciones($puestoPlantillaId, $tipoTurnoPlantillaId, $puntoServicioPlantillaId); 
		//$datos= $negocio -> ObtenerPlantillaParaAdmin($tipoTurnoPlantillaId,$puntoServicioPlantillaId,$puestoPlantillaId);
		$response["datos"]= $datos;

		//$log->LogInfo("Valor de variable de nombre que viene de form" . var_export ($nombre, true));
		//$log->LogInfo("Valor de la variable \$response empleado: " . var_export ($response, true));

	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Requisición";
	}


echo json_encode($response); 


?>

