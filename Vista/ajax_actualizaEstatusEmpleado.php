<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
$response = array ();
verificarInicioSesion ($negocio); 
if (!empty ($_POST))
{
// $log = new KLogger ( "ajaxActualizaEstatusEmpleado.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable \$_POST : " . var_export ($_POST, true));
    $empleadoId=getValueFromPost("numeroEmpleado");
    $empleadoidd = explode("-", $empleadoId);
    $empleadoEntidad=$empleadoidd[0];
    $empleadoConsecutivo=$empleadoidd[1];
    $empleadoCategoria=$empleadoidd[2];
    $estatusEmpleado=getValueFromPost("estatusEmpleado");
    $plantillaTexto=getValueFromPost("plantillaTexto");
    $usuarioCaptura=$_SESSION ["userLog"]["usuario"];
    $empleado ["entidadId"] = $empleadoEntidad;
    $empleado ["consecutivoId"] = $empleadoConsecutivo;
    $empleado ["tipoId"] = $empleadoCategoria;
    try
    {
        $negocio -> negocio_actualizarEstatusEmpleado($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria, $estatusEmpleado, $usuarioCaptura, $plantillaTexto);
        $negocio -> updateEstatusEmpleadoOperacionesActivo ($empleado, 1);
        $response ["status"] = "success";
        $response ["message"] = "movimiento Exitoso";
    } 
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }
}
else
{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}
echo json_encode ($response);
?>