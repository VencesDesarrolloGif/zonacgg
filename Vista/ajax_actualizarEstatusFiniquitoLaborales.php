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
//$log = new KLogger ( "ajax_actualizarEstatusFiniquitoLaborales.log" , KLogger::DEBUG );


    $empleadoEntidadId=getValueFromPost("empleadoEntidadId");
    $empleadoConsecutivoId=getValueFromPost("empleadoConsecutivoId");
    $empleadoTipoId=getValueFromPost("empleadoTipoId");
    $FechaAltaEmpleadoLaborales=getValueFromPost("FechaAltaEmpleadoLaborales");
//$log->LogInfo("Valor de la variable empleadoEntidadId: " . var_export ($empleadoEntidadId, true));

    try
    {
        $negocio -> ActualizarFiniquitoLaborales($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$FechaAltaEmpleadoLaborales);
                
        $response ["status"] = "success";
        $response ["message"] = "Actualizacion finalizada";
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