<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
$numeroEmpleado=getValueFromPost ("numeroEmpleado");

//$log = new KLogger ( "ajax_VerificacionFirmaAlamcenada.log" , KLogger::DEBUG );
   try {
        $DatosFirma = $negocio->getDatosFirmaAlmacenada($numeroEmpleado);
        $response["datos"] = $DatosFirma;
       } 
    catch (Exception $e) {
        $response["status"] = "error";
        $response["error"]  = "No se puedo obtener lista de Firmas Almacenadas";
        //$log->LogInfo("Valor de la variable response: " . var_export ($response, true));

    }
echo json_encode($response);
 