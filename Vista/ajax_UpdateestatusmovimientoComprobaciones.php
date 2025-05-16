<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio ();
verificarInicioSesion ($negocio);
$response = array ();
//$log = new KLogger ( "ajaxRegistroCobranza.log" , KLogger::DEBUG );
$idlibromovimientos=$_POST['idlibromovimientos'];
$casoactulizar=$_POST['casoactulizar'];

// $log = new KLogger ( "ajaxRegistroMovimientoCobraaanzaa.log" , KLogger::DEBUG );

if (!empty ($_POST))
{
    try
    {
        $negocio->negocio_Actualizarestatuscomprobacion($idlibromovimientos,$casoactulizar);

        $response ["status"] = "success";
        $response ["message"] = "Registo Realizado Éxitosamente";
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