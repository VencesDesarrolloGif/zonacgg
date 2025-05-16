<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php"); 

$negocio = new Negocio();

verificarInicioSesion ($negocio);
// $log = new KLogger ( "ajax_getEmpleadosFatigaPorPlantillas.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de variable de post" . var_export ($_POST, true));

$response = array("status" => "error");

	//$supervisorId= getValueFromPost ("supervisorId");
	$fecha1=getValueFromPost("fecha1");
	$fecha2=getValueFromPost("fecha2");
	$puntoServicio=getValueFromPost("puntoServicio");
	$idplantillaPunto=getValueFromPost("idplantillaPunto");
	//$numeroempleadosupervisor=getValueFromPost("numeroempleadosupervisor");
		//$log->LogInfo("Valor de variable de fecha2" . var_export ($fecha2, true));
		//$log->LogInfo("Valor de variable de puntoServicio" . var_export ($puntoServicio, true));

	if($fecha1=="" || $fecha2==""){
 
	$response["status"]="error";
	$response["error"]="No se puedo obtener consulta";

	}
	else{
		 
try{

	$listaEmpleados= $negocio -> getEmpleadoForFatigaPorPlantilla($fecha1,$fecha2,$puntoServicio,$idplantillaPunto);
	//$log->LogInfo("Valor de variable de puntoServicio" . var_export ($puntoServicio, true));
	
    for ($i = 0; $i < count($listaEmpleados); $i++) 
    {
        $empleadoEntidadId = $listaEmpleados [$i]["entidadFederativaId"];
        $empleadoConsecutivoId = $listaEmpleados [$i]["empleadoConsecutivoId"];
        $empleadoTipoId = $listaEmpleados [$i]["empleadoCategoriaId"];
        $IdPlantilla = $listaEmpleados [$i]["IdPlantilla"];

        $listaEmpleados [$i]["asistencia"] = $negocio -> getAsistenciaByEmpleadoPuntoServicioFatigaPorPlantilla($fecha1,$fecha2, $empleadoEntidadId, $empleadoConsecutivoId,$empleadoTipoId, $puntoServicio,$IdPlantilla);
        $listaEmpleados [$i]["diasFestivos"] = $negocio -> getSumaDiasFestivosFatigaPorPlantilla($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId,$puntoServicio,$IdPlantilla);
       
    }

	$response["listaEmpleados"]= $listaEmpleados;
	$response["status"]="success";
	

} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener consulta";
}
}

//$log->LogInfo("Valor de la variable \$response: " . var_export ($response, true));



echo json_encode($response);

?>
