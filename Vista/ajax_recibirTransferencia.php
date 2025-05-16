<?php

session_start();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

$response = array ();

verificarInicioSesion($negocio);

	//$log = new KLogger ( "ajax_updateRequisicion.log" , KLogger::DEBUG );
    $idTransferencia=getValueFromPost("idTransferencia");    
	$entidadRecepcion=getValueFromPost("entidadRecepcion");    
    //$entidadRecepcion=$_SESSION ["userLog"]["entidadFederativaUsuario"];
	//$log->LogInfo("Valor de la variable entidadRecepcion: " . var_export ($entidadRecepcion, true));
    try
    {
        $negocio -> negocio_entradaDeTransferencia($idTransferencia,$entidadRecepcion);
        
        $response ["status"] = "success";
        $response ["message"] = "Uniformes recibidos";
    } 
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }

echo json_encode ($response);
?>