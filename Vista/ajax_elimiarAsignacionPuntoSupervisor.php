<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");

$negocio = new Negocio ();

$response = array ();
$messages = array ();

verificarInicioSesion ($negocio);

if (!empty ($_POST))
{
//$log = new KLogger ( "ajaxEliminaAsignacion.log" , KLogger::DEBUG );


    $usuario = $_SESSION ["userLog"]["usuario"];

    $supervisorId=getValueFromPost ("supervisorId");
    //$idPunto=getValueFromPost ("idPunto");
    $empleadoidd = explode("-", $supervisorId);

    $supervisorEntidad=$empleadoidd[0];
    $supervisorConsecutivo=$empleadoidd[1];
    $supervisorTipo=$empleadoidd[2];

    $supervisor = array (
     "supervisorEntidad" => substr($supervisorEntidad),
     "supervisorConsecutivo" => substr($supervisorConsecutivo),
     "supervisorTipo" => substr($supervisorTipo),
     "puntoServicioId" => getValueFromPost("idPunto"),
    );

     //$log->LogInfo("Valor de la variable \$supervisor: " . var_export ($supervisor, true));
    try
    {

    $negocio -> deletePuntoServicioSupervisor($supervisor);
    
    $response ["status"] = "success";
    $response ["message"] = "El punto de servicio fue eliminado";

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

$response ["messages"] = $messages;

echo json_encode ($response);
?>
