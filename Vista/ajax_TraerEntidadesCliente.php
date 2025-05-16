<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
$response = array ();
 $lista=array();
verificarInicioSesion ($negocio);

//$log = new KLogger ( "ajax_TraerEntidades.log" , KLogger::DEBUG );
 //$log->LogInfo("Valor de la variable \$_POST: " . var_export ($valorselectorbanco, true));
try
{ 
    $lista= $negocio -> negocio_TraerEntidades();
    $response ["status"] = "success";
    $response ["datos"] = $lista;
} 
catch (Exception $e)
{
    $response ["status"] = "error";
    $response ["message"] =  $e -> getMessage ();
}

echo json_encode ($response);
?>