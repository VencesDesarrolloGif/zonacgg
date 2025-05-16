<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajax_consultaEmpleadoIdPeriodo.php.log" , KLogger::DEBUG );
$response = array("status" => "success");
if(!empty ($_POST))
{
        //$usuario = $_SESSION ["userLog"]["empleadoId"];
        $fecha1=getValueFromPost("fecha1");
        $fecha2=getValueFromPost("fecha2");
        $periodoId=getValueFromPost("periodoId");
        $empleado ["entidadId"] = getValueFromPost ("empleadoEntidadId");
        $empleado ["consecutivoId"] = getValueFromPost ("empleadoConsecutivoId");
        $empleado ["tipoId"] = getValueFromPost ("empleadoTipoId");
        $usuario=$_SESSION['userLog'];
        $entidadUsuario=$usuario["entidadFederativaUsuario"];
        $RolUsuario=$usuario["rol"];
        $lineaNegocioUsuario=$usuario["lineaNegocioUsuario"];
        //$log->LogInfo("Valor de variable de usuario" . var_export ($usuario, true));        
try{

    $listaEmpleados= $negocio -> negocio_getAdminById($fecha1, $fecha2,$periodoId, $empleado,$entidadUsuario, $RolUsuario,$lineaNegocioUsuario);
    
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