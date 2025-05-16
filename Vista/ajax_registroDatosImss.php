<?php
session_start ();
require_once ("../Negocio/Negocio.class.php"); 
require_once ("Helpers.php"); 
$negocio = new Negocio ();
$response = array ();
verificarInicioSesion ($negocio);

 // $log = new KLogger ( "ajaxRegistroDatosImss.log" , KLogger::DEBUG );
 // $log->LogInfo("Valor de la variable datosImss: " . var_export ($_POST, true)); 
if (!empty ($_POST))
{ 
    $usuario = $_SESSION ["userLog"]["usuario"];
    $datosImss= array (
    "empladoEntidadImss" =>getValueFromPost("empladoEntidadImss"),
    "empleadoConsecutivoImss" => getValueFromPost("empleadoConsecutivoImss"),
    "empleadoCategoriaImss" => getValueFromPost("empleadoCategoriaImss"),
    "fechaImss" => getValueFromPost("fechaImss"),
    "salarioDiario" => getValueFromPost("salarioDiario"),
    "registroPatronal" => getValueFromPost("registroPatronal"),
    "tipoTrabajador" =>getValueFromPost("tipoTrabajador"),
    "empleadoEstatusImss" =>getValueFromPost("empleadoEstatusImss"),
    "Origen" =>getValueFromPost("Origen"),
    );
    try
    {
        $negocio -> insertaDatosImss($datosImss);
        $response ["status"] = "success";
        $response ["message"] = "Empleado registrado éxitosamente";
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