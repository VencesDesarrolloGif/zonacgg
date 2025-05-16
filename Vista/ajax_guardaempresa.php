<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$empresa=$_POST["empresa"];
$response = array("status" => "success");

//$log = new KLogger ( "ajaxgetbancossssssssssss.log" , KLogger::DEBUG );
try {
$lista=$negocio->negocioinserempresa($empresa);
 //$log->LogInfo("Valor de descbanco" . var_export ($lista, true));  
    //$log->LogInfo("Valor de response" . var_export ($response, true));

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No se puedo obtener lista de bancos";
}

echo json_encode($response);
