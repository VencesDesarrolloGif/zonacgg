<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
$response = array ();
$valorconsulta=array();
verificarInicioSesion ($negocio);

$consultavehicular=$_POST["consultavehicular"];
$valordelcampodeconsulta=$_POST["valordelcampodeconsulta"];
// $log = new KLogger ( "ajascuentabancarias.log" , KLogger::DEBUG );
 //$log->LogInfo("Valor de la variable \$_POST: " . var_export ($valorselectorplacas, true));
if (!empty ($_POST))
{
     //$log->LogInfo("Valor de la variable \$montoFormato: " . var_export ($montoFormato, true));
    try
    {
       $valorconsulta= $negocio -> getdatosvehiuclares($consultavehicular,$valordelcampodeconsulta);
     // $log->LogInfo("Valor de la variable \$_POST: " . var_export ($valorconsulta, true));
        $response ["status"] = "success";
       $response ["datos"] = $valorconsulta;
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
    $response ["message"] = "No se puedo obtener los datos del vehiculo";
}

echo json_encode ($response);
?>
