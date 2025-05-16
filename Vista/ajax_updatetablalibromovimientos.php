<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
$response = array ();
$datos=array();
$idmovimiento=$_POST["idmovimiento"];
$accionSoli=$_POST["accionSoli"];

//$log = new KLogger ( "ajaxinsertarhistoricoediter.log" , KLogger::DEBUG );
verificarInicioSesion ($negocio);

if (!empty ($_POST))
{
    try
    {
        $update = $negocio->negocio_actualizartablalibromovimiento($idmovimiento,$accionSoli);
        $response ["status"] = "success";
        $response ["datos"] = $datos; 
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