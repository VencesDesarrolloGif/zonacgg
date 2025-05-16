<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");


$negocio= new Negocio();

verificarInicioSesion ($negocio);

$nombre= getValueFromPost ("nombre");


//$log = new KLogger ( "ajaxGetPuntosBySupervisor.log" , KLogger::DEBUG );

$response = array("status" => "success");


    try{

        $puntos = $negocio -> getPuntosServiciosByNamePunto($nombre);
        //$log->LogInfo("Valor de la variable \$supervisorTipo: " . var_export ($puntos, true));
        
        $response ["puntos"] = $puntos;
        //$log->LogInfo("Valor de la variable \$responseajax de puntos segun tipo: " . var_export ($response, true));
        
    }
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] = "No se pudieron obtener los puntos";
    }

echo json_encode ($response);
?>