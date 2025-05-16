<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
$response = array ();
//$usuario = array ();
//$log = new KLogger ( "ajaxRegistroCobranza.log" , KLogger::DEBUG );
$selectMaterial=$_POST['selectMaterial'];
// $log = new KLogger ( "ajaxRegistroMovimientoCobraaanzaa.log" , KLogger::DEBUG );
verificarInicioSesion ($negocio);
if (!empty ($_POST))
{
    //$usuario = $_SESSION ["userLog"]["usuario"];
//$log->LogInfo("Valor de la variable \$datastring: " . var_export ($_SESSION ["userLog"]["usuario"], true));  
    try
    {
        $ListaCosto = $negocio->negocio_Costomaterial($selectMaterial);
       
        $response ["datos"] = $ListaCosto;
        $response ["status"] = "success";
       
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