<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
$response = array ();
$Estructura=array();
verificarInicioSesion ($negocio);

$valorselectomodalidad=$_POST["valorselectomodalidad"];
//$log = new KLogger ( "ajascuentabancarias.log" , KLogger::DEBUG );
 //$log->LogInfo("Valor de la variable \$_POST: " . var_export ($valorselectomodalidad, true));
if (!empty ($_POST))
{
     //$log->LogInfo("Valor de la variable \$montoFormato: " . var_export ($montoFormato, true));
    try
    {
       $Estructura= $negocio -> negocio_DatoEstructuraPlacas($valorselectomodalidad);
    // $log->LogInfo("Valor de la variable \$_POST: " . var_export ($Estructura, true));
        $response ["status"] = "success";
       $response ["datos"] = $Estructura;
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