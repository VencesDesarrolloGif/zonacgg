<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
//$log = new KLogger ( "ajaxConsultaStock.log" , KLogger::DEBUG );
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
$uniformeSeleccionado = $_POST["uniformeSeleccionado"];
$EntidadSeleccionada = $_POST["EntidadSeleccionada"];
$sucursalSeleccionada = $_POST["sucursalSeleccionada"];

try {
    $cantidadStock  = $negocio->obtenerCantidadStock($uniformeSeleccionado,$EntidadSeleccionada,$sucursalSeleccionada);
    $largoResult=  count($cantidadStock);
  //  $log->LogInfo("Valor de largoResult" . var_export ($largoResult, true));

     if ($largoResult ==0) {
	    $response["datos"] = 0;
    }else{
	 $cantidadtotal= $cantidadStock[0]['cantidadUniformes'];
    $response["datos"] = $cantidadtotal;
}
   //$log->LogInfo("Valor de response" . var_export ($response, true));
} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No Se Puedo Obtener Las Entidades Del Usuario";
}
echo json_encode($response);
