<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajax_getCoberturaByPerfil.log" , KLogger::DEBUG );

$response = array("status" => "success");

if(!empty ($_POST))
{
	//$supervisorId= getValueFromPost ("supervisorId");
	

try{
	
		$fecha1=getValueFromPost("fecha1");
		$fecha2=getValueFromPost("fecha2");
		$puntoServicioId=getValueFromPost("puntoServicioId");
		$puestoId=getValueFromPost("puestoId");
		//$periodoId=getValueFromPost("periodoId");


		//$log->LogInfo("Valor de variable de fecha1" . var_export ($fecha1, true));
		//$log->LogInfo("Valor de variable de fecha2" . var_export ($fecha2, true));
		


    	$asistencia= $negocio -> getTurnosCubiertosByPerfil($fecha1, $fecha2, $puntoServicioId, $puestoId);
    	$turnos=0;

	
    for ($i = 0; $i < count($asistencia); $i++)
    {
        //$empleadoEntidadId = $asistencia [$i]["entidadFederativaId"];
        //$empleadoConsecutivoId = $asistencia [$i]["empleadoConsecutivoId"];
        //$empleadoTipoId = $asistencia [$i]["empleadoCategoriaId"];

        $turnos=$turnos+$asistencia [$i]["valorCobertura"];


        
    }

	$response["asistencia"]= $asistencia;
	$response["turnos"]= $turnos;
	//$log->LogInfo("Valor de la variable \$asistencia: " . var_export ($response, true));

	

	

} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener consulta";
}
}
else
{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}

//$log->LogInfo("Valor de la variable \$response: " . var_export ($response, true));

echo json_encode($response);

?>
