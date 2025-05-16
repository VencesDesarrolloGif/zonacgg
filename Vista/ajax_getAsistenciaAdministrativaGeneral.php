<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajax_getListaAdmin.log" , KLogger::DEBUG );
$response = array("status" => "success");

if(!empty ($_POST))
{
		$fecha1=getValueFromPost("fecha1");
		$fecha2=getValueFromPost("fecha2");
		$periodoId=getValueFromPost("periodoId");	
		$opcion=getValueFromPost("opcion");		
		$usuario=$_SESSION['userLog'];
		$entidadUsuario=$usuario["entidadFederativaUsuario"];		
		$lineaNegocioUsuario=$usuario["lineaNegocioUsuario"];		
		$RolUsuario=$usuario["rol"];		
		$NombreUsuario=$usuario["usuario"];		
		
//		$log->LogInfo("Valor de variable de usuario" . var_export ($usuario, true));

try{

	if($opcion==1)
		$listaEmpleados= $negocio -> negocio_getListaEmpleadosAdminGeneral($fecha1, $fecha2,$periodoId,$entidadUsuario,$RolUsuario,$opcion,$NombreUsuario,$lineaNegocioUsuario);
	else
		$listaEmpleados= $negocio -> negocio_getListaEmpleadosByConsulta($fecha1, $fecha2,$periodoId,$entidadUsuario,$RolUsuario,$opcion,$NombreUsuario,$lineaNegocioUsuario);
	
	for ($i = 0; $i < count($listaEmpleados); $i++)
    {
        $empleadoEntidadId = $listaEmpleados [$i]["entidadFederativaId"];
        $empleadoConsecutivoId = $listaEmpleados [$i]["empleadoConsecutivoId"];
        $empleadoTipoId = $listaEmpleados [$i]["empleadoCategoriaId"];

        $listaEmpleados [$i]["asistencia"] = $negocio -> negocio_getAsistenciaByEmpleadoAdmin ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId);
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