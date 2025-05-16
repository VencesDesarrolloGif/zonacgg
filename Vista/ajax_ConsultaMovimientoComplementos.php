<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio            = new Negocio ();
$response           = array();
$response["status"] = "error";
$datos              = array();
//$usuario = $_SESSION ["userLog"]["usuario"];
try {
    $datos = $negocio -> obtenerListaHistoricoComp();
    for ($i = 0; $i < count($datos); $i++) {  

        $EstatusComplemento        = $datos[$i]["EstatusComplemento"];
        if($EstatusComplemento==1){
        	$datos[$i]["Estatus"] = "Complementos Solicitado A D.G";
        }
    	else if($EstatusComplemento==2){
    		$datos[$i]["Estatus"] = "Complemento Rechazado Por D.G";
    	}
    	else if($EstatusComplemento==3){
    		$datos[$i]["Estatus"] = "Complemento Aceptado Por D.G";
    	}
    	else if($EstatusComplemento==4){
    		$datos[$i]["Estatus"] = "Complemento Pagado";
    	}
    }
    $response["status"] = "success";
    $response["datos"]  = $datos;
} catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
