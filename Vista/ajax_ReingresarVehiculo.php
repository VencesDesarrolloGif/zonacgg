<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio (); 
$response = array ();
$response ["status"] = "error";

verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajax_DarBajavehiculo.log" , KLogger::DEBUG );
if (!empty ($_POST))
{
    $usuarioCapturareingreso=$_SESSION ["userLog"]["usuario"];
    $numeroeconomicoReingreso2 = $_POST["numeroeconomicoReingreso2"];
    $selMotivoReingreso2 = $_POST["selMotivoReingreso2"];
    $selMotivoSiniestro2 = $_POST["selMotivoSiniestro2"];
    $numeroPlacas2 = $_POST["numeroPlacas2"];
    $inpNumeroDeSerie2 = $_POST["inpNumeroDeSerie2"];
    $ComentariosReingreso = $_POST["ComentariosBaja2"];
//$log->LogInfo("Valor de la variable \$usuarioCapturaBaja: " . var_export ($usuarioCapturaBaja, true));
    try
    {
        $negocio -> ReingresarVehiculo($usuarioCapturareingreso,$numeroeconomicoReingreso2,$selMotivoReingreso2,0,$numeroPlacas2,$inpNumeroDeSerie2,$ComentariosReingreso); 
        $response ["status"] = "success";
        $response ["message"] = "Vehiculo Reingresado Éxitosamente";

        
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
