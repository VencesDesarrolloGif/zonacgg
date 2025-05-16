<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

//$log = new KLogger ( "ajaxPuestosPorTipoLinea.log" , KLogger::DEBUG );
$negocio= new Negocio();
verificarInicioSesion ($negocio);
$response = array("status" => "success");
    try{

        $Abecedario = $negocio -> obtenerCatalogoAbecedario();

        
        $response ["datos"] = $Abecedario;
    //    $log->LogInfo("Valor de la variable \$responseajax de puesto segun tipo: " . var_export ($_POST, true));
        
    }
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] = "No se pudieron obtener los Abecedario";
    }

echo json_encode ($response);
?>