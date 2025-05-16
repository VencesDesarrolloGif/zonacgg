<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
// $log = new KLogger ( "ajaxincidenciasAlCierre.log" , KLogger::DEBUG );
$response = array("status" => "success");
$fechaCierre= getValueFromPost("fechaCierre");
$fechaCambioPeriodo= getValueFromPost("fechaCambioPeriodo");
$idTipoPeriodo= getValueFromPost("idTipoPeriodo");
try{
	$incidenciasAlCierre= $negocio -> getModificacionesPostCierre($fechaCierre,$fechaCambioPeriodo,$idTipoPeriodo);
	for($i=0;$i<count($incidenciasAlCierre);$i++){
		$numeroEmpleado=$incidenciasAlCierre[$i]["numeroEmpleado"];
		$fechaAsistencia=$incidenciasAlCierre[$i]["fechaAsistencia"];


           	$empleadoidd = explode("-", $numeroEmpleado);
        	$empleadoEntidad=$empleadoidd[0];
        	$empleadoConsecutivo=$empleadoidd[1];
        	$empleadoCategoria=$empleadoidd[2];
		$datos = array (
			"empleadoEntidadAsistenciaEdited" => $empleadoEntidad,
		    	"empleadoConsecutivoAsistenciaEdited" =>$empleadoConsecutivo,
		    	"empleadoTipoAsistenciaEdited" => $empleadoCategoria,
		    	"fechaInicioPeriodo" => "2020-11-01 00:00:00",
		    	"fechaCierrePeriodo" =>$fechaCierre,
		    	"fechaAsistenciaEdited"=>$fechaAsistencia,
	    	);
	    	//$log->LogInfo("Valor de la variable \$datos: " . var_export ($datos, true));
	    	$incidenciasAlCierre [$i]["incidenciaCierre"] = $negocio -> getIncidenciasAlCierre ($datos);
	}
	// $log->LogInfo("Valor de la variable incidenciasAlCierre: " . var_export ($incidenciasAlCierre, true));
	$response["incidenciasAlCierre"]= $incidenciasAlCierre;
} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener datos";
}

echo json_encode($response);

?>