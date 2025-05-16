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
    $usuarioCapturaBaja=$_SESSION ["userLog"]["usuario"];
    $numeroeconomicoBaja=$_POST["numeroeconomicoBaja"];
    $selMotivoBaja1=$_POST["selMotivoBaja1"];
    $selMotivoSiniestro1=$_POST["selMotivoSiniestro1"];
    $numeroeconomicoconsulta1=$_POST["numeroeconomicoconsulta1"];
    $numeroPlacas1=$_POST["numeroPlacas1"];
    $inpNumeroDeSerie1=$_POST["inpNumeroDeSerie1"];
    $ComentariosBaja1=$_POST["ComentariosBaja1"];
    $DocFiniquitoHiden=$_POST["DocFiniquitoHiden"];
    $DocChequesHiden=$_POST["DocChequesHiden"];
    
    
//$log->LogInfo("Valor de la variable \$usuarioCapturaBaja: " . var_export ($usuarioCapturaBaja, true));
    try
    {
        $negocio -> DarDeBajaVehiculo($usuarioCapturaBaja,$numeroeconomicoBaja,$selMotivoBaja1,$selMotivoSiniestro1,$numeroeconomicoconsulta1,$numeroPlacas1,$inpNumeroDeSerie1,$ComentariosBaja1,$DocFiniquitoHiden,$DocChequesHiden); 
        $response ["status"] = "success";
        $response ["message"] = "Vehiculo Dado De Baja Éxitosamente";

        
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
