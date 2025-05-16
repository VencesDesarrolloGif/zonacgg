<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);
// $log = new KLogger ( "ajaxGetempleadosBySupervisorPeriodo.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de variable de user: " . var_export ($_SESSION["userLog"]["rol"], true));

$response = array("status" => "success");

if(!empty ($_POST))
{
	$supervisorId= getValueFromPost ("supervisorId");

try{

	if ($_SESSION["userLog"]["rol"]=="Supervisor" || $_SESSION["userLog"]["rol"]=="Consulta Supervisor"){
		$usuarioCompleto=$_SESSION['userLog'];
    	$usuario = $_SESSION ["userLog"]["empleadoId"];

    	$fecha1=getValueFromPost("fecha1");
		$fecha2=getValueFromPost("fecha2");
		$periodoId=getValueFromPost("periodoId");

		$empleadoidd = explode("-", $usuario);
/*
        $supervisorEntidad=substr($usuario, 0,2);
  		$supervisorConsecutivo=substr($usuario, 3,4);
  		$supervisorTipo=substr($usuario, 8,2);
*/
        $supervisorEntidad=$empleadoidd[0];
        $supervisorConsecutivo=$empleadoidd[1];
        $supervisorTipo=$empleadoidd[2];
		
    	$listaEmpleados= $negocio -> getListaGeneralEmpleadosBySupervisor($fecha1, $fecha2, $supervisorEntidad, $supervisorConsecutivo,$supervisorTipo, $periodoId);
	
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
	
	}else {
$tipopuesto="03";
		 if($_SESSION["userLog"]["rol"]=="Prenomina Administrativa"){
			$tipopuesto="02";}
		

		$fecha1=getValueFromPost("fecha1");
		$fecha2=getValueFromPost("fecha2");
		$periodoId=getValueFromPost("periodoId");

    	if($_SESSION["userLog"]["rol"]=="Gerente Regional" || $_SESSION["userLog"]["rol"]=="Radio Operador"){
			$usuarioRegional=$_SESSION ["userLog"]["usuario"];
			$listaEmpleados= $negocio -> getListaGeneralEmpleadosParaRegional($fecha1, $fecha2,$periodoId,$tipopuesto,$usuarioRegional);
		}else{
			$listaEmpleados= $negocio -> getListaGeneralEmpleados($fecha1, $fecha2,$periodoId,$tipopuesto);
		}
	
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
		$listaEmpleados [$i]["fonacot"]=$negocio -> getDeducciones ($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,1/*donde 1 la accion para consultar en fonacot_nomina*/);
		$listaEmpleados [$i]["infonavit"]=$negocio -> getDeducciones ($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,2/*donde 2 la accion para consultar en infonavit_nomina*/);
		$listaEmpleados [$i]["pension"]=$negocio -> getDeducciones ($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,3/*donde 3 la accion para consultar en pension_nomina*/);
		$listaEmpleados [$i]["prestamo"]=$negocio -> getDeducciones ($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,4/*donde 4 la accion para consultar en prestamo_nomina*/);        
	$listaEmpleados [$i]["alimentos"]=$negocio -> getDeducciones ($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,5/*donde 4 la accion para consultar en alimentos*/);        
    }

	$response["listaEmpleados"]= $listaEmpleados;
	// $log->LogInfo("Valor de la variable \$listaEmpleados: " . var_export ($response, true));
	}
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
