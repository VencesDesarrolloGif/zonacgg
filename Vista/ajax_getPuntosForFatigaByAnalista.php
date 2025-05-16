<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");


$negocio= new Negocio();

verificarInicioSesion ($negocio);


//$log = new KLogger ( "ajaxGetPuntosAnalista.log" , KLogger::DEBUG );
		$fecha1=getValueFromPost("fecha1");
		$fecha2=getValueFromPost("fecha2");


$response = array("status" => "success");


    try{

        $puntos = $negocio -> getPuntosServicios($fecha1, $fecha2);
        
        
        $response ["puntos"] = $puntos;
        
        
    }
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] = "No se pudieron obtener los puntos";
    }
//$log->LogInfo("Valor de la variable \$response: " . var_export ($response, true));
echo json_encode ($response);
?>

