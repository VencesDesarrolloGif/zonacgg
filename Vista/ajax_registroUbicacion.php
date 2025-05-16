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
//$log = new KLogger ( "ajaxRegistroUbicacion.log" , KLogger::DEBUG );

$usuario = $_SESSION ["userLog"]["usuario"];
$numeroEmpleado=$_SESSION ["userLog"]["empleadoId"];
$fechaDispositivo=getValueFromPost("fechaDispositivo");

$unixtime = strtotime($fechaDispositivo);
$time = date("Y-m-d G:i:s",$unixtime);


    //$date=date_format($fechaDispositivo,"Y/m/d H:i:s");

    $datosUbicacion = array (
    "entidadEmpleado" =>substr($numeroEmpleado, 0,2),
    "consecutivoEmpleado" =>substr($numeroEmpleado, 3,4),
    "tipoEmpleado" =>substr($numeroEmpleado, 8,2),
    "latitud" => getValueFromPost("latitude"),
    "longitud" => getValueFromPost("longitude"),
    "fechaDispositivo" =>$time
    );



     //$log->LogInfo("Valor de la variable \$datosUbicacion: " . var_export ($datosUbicacion, true));
    try
    {
       
        $negocio -> registroUbicacion($datosUbicacion);
        
        $response ["status"] = "success";
        $response ["message"] = "Se registró su ubicación";
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