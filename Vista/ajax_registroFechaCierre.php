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
$usuario = $_SESSION ["userLog"]["usuario"];

verificarInicioSesion ($negocio);
// $log = new KLogger ( "ajax_registroCierre.log" , KLogger::DEBUG );
  

if (!empty ($_POST))
{
    
    $usuarioCaptura=$_SESSION ["userLog"]["usuario"];
    $periodoId= getValueFromPost("periodoId");
    
    try
    {

       
            $fechaTerminoQuincena=getValueFromPost("fechaTermino");
            //$log->LogInfo("Valor de la variable \$fechaTerminoQuincena: " . var_export ($fechaTerminoQuincena, true));
            
            $diaTerminoQuincena=date("d", strtotime($fechaTerminoQuincena));
            //$log->LogInfo("Valor de la variable \$diaTerminoQuincena: " . var_export ($diaTerminoQuincena, true));


            $fechaCambioPeriodo =strtotime($fechaTerminoQuincena."+ 1 day");
            //$log->LogInfo("Valor de la variable \$fechaCambioPeriodo: " . var_export ( date("Y-m-d",$fechaCambioPeriodo)." 00:00:00", true));


            $datos = array (
            "fechaInicioPeriodo" => getValueFromPost("fechaInicio"),
            "fechaTerminoPeriodo" => getValueFromPost("fechaTermino"),
            "periodoId" => $periodoId,
            "fechaCambioPeriodo" => date("Y-m-d",$fechaCambioPeriodo)." 12:00:00",
            "usuarioCaptura" => $usuarioCaptura,

            );
            
            // $log->LogInfo("Valor de la variable \$datos: " . var_export ($datos, true));

            $response ["status"] = "success";
            $response ["message"] = "ok";


            $negocio -> cierrePeriodo($datos);

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
