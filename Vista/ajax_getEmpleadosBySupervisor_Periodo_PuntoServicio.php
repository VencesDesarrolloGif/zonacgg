<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);
// $log = new KLogger ( "ajaxConsultaEmpleadosBySupervisorPeriodoPuntoServicio.log" , KLogger::DEBUG );

$response = array("status" => "success");

if(!empty ($_POST))
{
	$supervisorId= getValueFromPost ("supervisorId");

	if($_SESSION ["userLog"]["rol"]=="Analista Asistencia" and $supervisorId!='' ){
    
    	$usuario=$supervisorId;
    
	}else if ($_SESSION["userLog"]["rol"]=="Supervisor" || $_SESSION["userLog"]["rol"]=="Consulta Supervisor"){

    	$usuario = $_SESSION ["userLog"]["empleadoId"];
	}
	
		$fecha1=getValueFromPost("fecha1"); 
		$fecha2=getValueFromPost("fecha2");
		$periodoId=getValueFromPost("periodoId");
		$puntoServicio=getValueFromPost("puntoServicio");

		$empleadoidd = explode("-", $usuario);
/*
        $su$supervisorEntidad=substr($usuario, 0,2);
  		$supervisorConsecutivo=substr($usuario, 3,4);
  		$supervisorTipo=substr($usuario, 8,2);
*/ 
        $supervisorEntidad=$empleadoidd[0];
        $supervisorConsecutivo=$empleadoidd[1];
        $supervisorTipo=$empleadoidd[2];

		//$log->LogInfo("Valor de variable de fecha1" . var_export ($fecha1, true));
		//$log->LogInfo("Valor de variable de fecha2" . var_export ($fecha2, true));
		//$log->LogInfo("Valor de variable de usuario" . var_export ($usuario, true));
		//$log->LogInfo("Valor de variable de usuario" . var_export ($supervisorEntidad, true));
		//$log->LogInfo("Valor de variable de usuario" . var_export ($supervisorConsecutivo, true));
		//$log->LogInfo("Valor de variable de usuario" . var_export ($supervisorTipo, true));

try{
// $log->LogInfo("Valor de variable de fecha1" . var_export ($fecha1, true));
// $log->LogInfo("Valor de variable de fecha2" . var_export ($fecha2, true));
// $log->LogInfo("Valor de variable de supervisorEntidad" . var_export ($supervisorEntidad, true));
// $log->LogInfo("Valor de variable de supervisorConsecutivo" . var_export ($supervisorConsecutivo, true));
// $log->LogInfo("Valor de variable de supervisorTipo" . var_export ($supervisorTipo, true));
// $log->LogInfo("Valor de variable de periodoId" . var_export ($periodoId, true));
// $log->LogInfo("Valor de variable de puntoServicio" . var_export ($puntoServicio, true));
	$listaEmpleados= $negocio -> getListaEmpleadosBySupervisorPeriodoPuntoServicio($fecha1, $fecha2, $supervisorEntidad, $supervisorConsecutivo,$supervisorTipo, $periodoId, $puntoServicio);
	
    for ($i = 0; $i < count($listaEmpleados); $i++)
    {
        $empleadoEntidadId = $listaEmpleados [$i]["entidadFederativaId"];
        $empleadoConsecutivoId = $listaEmpleados [$i]["empleadoConsecutivoId"];
        $empleadoTipoId = $listaEmpleados [$i]["empleadoCategoriaId"];
        $listaEmpleados [$i]["asistencia"] = $negocio -> getAsistenciaByEmpleadoPeriodo ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId);
        $listaEmpleados [$i]["turnosExtras"] = $negocio -> getSumaTurnosExtras ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId);
        $listaEmpleados [$i]["descuentos"] = $negocio -> getSumDescuentos ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId);
        $listaEmpleados [$i]["incidenciasEspeciales"] = $negocio -> getSumaIncidenciasEspeciales ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId);
        $listaEmpleados [$i]["diasFestivos"] = $negocio -> getSumaDiasFestivos ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId);
        
    }

	$response["listaEmpleados"]= $listaEmpleados;
	//$log->LogInfo("Valor de la variable \$listaEmpleados: " . var_export ($response, true));

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
