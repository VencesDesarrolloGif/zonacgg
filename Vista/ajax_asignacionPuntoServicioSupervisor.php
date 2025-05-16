<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
$response = array ();
verificarInicioSesion ($negocio);

// $log = new KLogger ( "ajax_asignacionPuntoServicioSupervisor.log" , KLogger::DEBUG );
    // $log->LogInfo("Valor de la variable post: " . var_export ($_POST, true));

if (!empty ($_POST))
{



    $usuario = $_SESSION ["userLog"]["usuario"];
    $supervisor=getValueFromPost("supervisorId");

    
       
    $empleadoidd = explode("-", $supervisor);
    $empleadoEntidad=$empleadoidd[0];
    $empleadoConsecutivo=$empleadoidd[1];
    $empleadoCategoria=$empleadoidd[2];

    $datos= array (
    "supervisorEntidad" => $empleadoEntidad,
    "supervisorConsecutivo" => $empleadoConsecutivo,
    "supervisorTipo" => $empleadoCategoria,
    "puntoServicioId" => getValueFromPost("puntoServicioId"),
    "usuarioAsigna" => $usuario,
    );
    

     // $log->LogInfo("Valor de la variable \$datos: " . var_export ($datos, true));
    try
    {
        $negocio -> asignacionPuntoServicioASupervisor($datos);

        $response ["status"] = "success";
        $response ["message"] = "El punto de servicio fue asignado al supervisor";
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