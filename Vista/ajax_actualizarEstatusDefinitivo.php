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
// $log = new KLogger ( "ajax_actualizarEstatusDefinitivo.log" , KLogger::DEBUG );


    $usuario = $_SESSION ["userLog"]["usuario"];

    $empleadoId=getValueFromPost("numeroEmpleado");
    $empleadoidd = explode("-", $empleadoId);
        $entidadFederativaId=$empleadoidd[0];
        $empleadoConsecutivoId=$empleadoidd[1];
        $empleadoCategoriaId=$empleadoidd[2];


    $datosImss= array (
    "empladoEntidadImss" =>$entidadFederativaId,
    "empleadoConsecutivoImss" => $empleadoConsecutivoId,
    "empleadoCategoriaImss" => $empleadoCategoriaId,
    "empleadoEstatusImss" => getValueFromPost("estatusImss"),
    "comentario" =>strtoupper(getValueFromPost("comentario")),
    "usuario" => $usuario,
    
    );

     // $log->LogInfo("Valor de la variable \$datosImss: " . var_export ($datosImss, true));
    try
    {
        $negocio -> actualizarEstatusDefinitivoImss($datosImss);
        
        $response ["status"] = "success";
        $response ["message"] = "Se registró el cambio éxitosamente";
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