<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajaxConsultaEmpleadosNominaPunto.log" , KLogger::DEBUG );

$response = array("status" => "success");

if(!empty ($_POST))
{
	$supervisorId= getValueFromPost ("supervisorId");
	

try{


		$fecha1=getValueFromPost("fecha1");
		$fecha2=getValueFromPost("fecha2");
		$puntoServicioId=getValueFromPost("puntoServicioId");
        $puestoCubierto=getValueFromPost("puestoCubierto");
        $roloperativo=getValueFromPost("roloperativo");

        


		//$log->LogInfo("Valor de variable de fecha1" . var_export ($fecha1, true));
		//$log->LogInfo("Valor de variable de fecha2" . var_export ($fecha2, true));
		//$log->LogInfo("Valor de variable de periodoId" . var_export ($periodoId, true));


    	$listaEmpleados= $negocio -> getListaEmpleadosNominaPorPuntoServicio($fecha1, $fecha2,$puntoServicioId,$puestoCubierto,$roloperativo);
	
    for ($i = 0; $i < count($listaEmpleados); $i++)
    {
        $empleadoEntidadId = $listaEmpleados [$i]["empleadoEntidad"];
        $empleadoConsecutivoId = $listaEmpleados [$i]["empleadoConsecutivo"];
        $empleadoTipoId = $listaEmpleados [$i]["empleadoTipo"];        

        $listaEmpleados [$i]["asistencia"] = $negocio -> getAsistenciaByEmpleadoPeriodo2 ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId,$puntoServicioId,$puestoCubierto);        
        $listaEmpleados [$i]["turnosExtras"] = $negocio -> getSumaTurnosExtrasPorPunto ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId,$puntoServicioId,$puestoCubierto);
        $listaEmpleados [$i]["descuentos"] = $negocio -> getSumDescuentosPorPunto ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId,$puntoServicioId,$puntoServicioId,$puestoCubierto);
        $listaEmpleados [$i]["incidenciasEspeciales"] = $negocio -> getSumaIncidenciasEspecialesPorPunto ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId,$puntoServicioId,$puestoCubierto);
        $listaEmpleados [$i]["diasFestivos"] = $negocio -> getSumaDiasFestivos2 ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId,$puntoServicioId,$puestoCubierto);
        
    }
    //$log->LogInfo("Valor de la variable asistencia: " . var_export ($listaEmpleados[0]["asistencia"], true));

	$response["listaEmpleados"]= $listaEmpleados;
	

	

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


echo json_encode($response);

?>
