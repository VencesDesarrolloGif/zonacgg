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
// $log = new KLogger ( "ajaxEdicionDatosImssTable.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable post: " . var_export ($_POST, true));
    $campo=getValueFromPost("campo"); 
    $valor=getValueFromPost("valor");
    $empleadoId=getValueFromPost("numeroEmpleado");
    $empleadoidd = explode("-", $empleadoId);
        $entidadFederativaId=$empleadoidd[0];
        $empleadoConsecutivoId=$empleadoidd[1];
        $empleadoCategoriaId=$empleadoidd[2];
    try
    {
        $negocio -> actualizarDatosImss($campo, $valor, $entidadFederativaId, $empleadoConsecutivoId, $empleadoCategoriaId);
        $response ["status"] = "success";
        $response ["message"] = "Edicion finalizada";
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