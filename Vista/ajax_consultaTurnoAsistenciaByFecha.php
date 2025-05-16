<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");

	
		// $log = new KLogger ( "ajaxObtenerTurnoAsistencia.log" , KLogger::DEBUG );
		// $log->LogInfo("Valor de variable post " . var_export ($_POST, true));
		$fecha=getValueFromPost("fechaAsistencia");
		$empleado=getValueFromPost("numeroEmpleado");
		$puntoServicio=getValueFromPost("puntoServicio");
		$idplantillaPunto=getValueFromPost("idplantillaPunto");
		$empleadoidd = explode("-", $empleado);
/*
            $empleadoEntidad=substr($empleado, 0,2);
		$empleadoConsecutivo=substr($empleado, 3,4);
		$empleadoCategoria=substr($empleado, 8,2);

*/
        $empleadoEntidad=$empleadoidd[0];
        $empleadoConsecutivo=$empleadoidd[1];
        $empleadoCategoria=$empleadoidd[2];


		 


	try{
		
		$turno= $negocio -> negocio_obtenerTurnoAsistencia($fecha,$empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria,$puntoServicio,$idplantillaPunto);
		$response["turno"]= $turno;

		//$log->LogInfo("Valor de variable de nombre que viene de form" . var_export ($nombre, true));
		//$log->LogInfo("Valor de la variable \$response empleado: " . var_export ($response, true));

	} 
	catch( Exception $e )
	{
		$response["status"]="error";
		$response["error"]="No se puedo obtener el Turno del empleado";
	}


echo json_encode($response);


?>
