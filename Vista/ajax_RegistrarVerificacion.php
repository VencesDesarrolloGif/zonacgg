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
//$log = new KLogger ( "ajax_registrarVerificacionVehicular.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
if (!empty ($_POST))
{
    $usuarioCapturaVerificacion=$_SESSION ["userLog"]["usuario"];
    $fotoverificacionhiden=$_POST ["fotoverificacionhiden"][0];
    $formatomultahiden=$_POST ["formatomultahiden"][0];

	$VerificacionesVehiculares = array (
        
        
        "FechaInicialVerificacion" => strtoupper(getValueFromPost("FechaInicialVerificacion")),
        "FechaFinalVerificacion" => strtoupper(getValueFromPost("FechaFinalVerificacion")),
        "SeVerificahiden" => strtoupper(getValueFromPost("SeVerificahiden")),
        "PrimerSemestrHiden" => strtoupper(getValueFromPost("PrimerSemestrHiden")),
        "SegundosemestreHiden" => strtoupper(getValueFromPost("SegundosemestreHiden")),
        "checkCalendarionormalhiden" => strtoupper(getValueFromPost("checkCalendarionormalhiden")),
        "checkSePagoMultahiden" => strtoupper(getValueFromPost("checkSePagoMultahiden")),
        "checkVerificacionATiempohiden" => strtoupper(getValueFromPost("checkVerificacionATiempohiden")),
        "inpNumroEcoVehiculoVerificacion" => strtoupper(getValueFromPost("inpNumroEcoVehiculoVerificacion")),
        "inpNumeroPlacasVerificacion" => strtoupper(getValueFromPost("inpNumeroPlacasVerificacion")),
        "inpcolorEngomadoVerificacion" => strtoupper(getValueFromPost("inpcolorEngomadoVerificacion")),
        "MontoVerificacion" => strtoupper(getValueFromPost("MontoVerificacion")),
        "MontoMulta" => strtoupper(getValueFromPost("MontoMulta")),
        "FolioMulta" => strtoupper(getValueFromPost("FolioMulta")),
        "PorqueMulta" => strtoupper(getValueFromPost("PorqueMulta")),
        "ComentariosGenerales" => strtoupper(getValueFromPost("ComentariosGenerales")),
        "usuarioCapturaVerificacion" => $usuarioCapturaVerificacion,
        "fotoverificacionhiden" => $fotoverificacionhiden,
        "formatomultahiden" => $formatomultahiden,

    ); 
        //$log->LogInfo("Valor de la variable \$Vehiculo: " . var_export ($_POST, true));
    try
    {
        $negocio -> RegistrarVerificacionVehiuclar($VerificacionesVehiculares); 
        $response ["status"] = "success";
        $response ["message"] = "Verificacion del Vehiculo Registrada Éxitosamente";

        
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
