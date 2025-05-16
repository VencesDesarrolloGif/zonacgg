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

$valorselectormarca=$_POST["valorselectormarca"];
//$log = new KLogger ( "ajascuentabancarias.log" , KLogger::DEBUG );
 //$log->LogInfo("Valor de la variable \$_POST: " . var_export ($valorselectormodelo, true));
if (!empty ($_POST))
{
     //$log->LogInfo("Valor de la variable \$montoFormato: " . var_export ($montoFormato, true));
    try
    {
       $lista= $negocio -> negocio_ListaModelosxMarca($valorselectormarca);
    // $log->LogInfo("Valor de la variable \$_POST: " . var_export ($lista, true));
        $response ["status"] = "success";
       $response ["datos"] = $lista;
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
    $response ["message"] = "No se Pudo Obtener Los Modelos De Esa Marca";
}

echo json_encode ($response);
?>