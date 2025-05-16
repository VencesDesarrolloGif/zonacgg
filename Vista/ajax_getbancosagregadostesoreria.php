<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$accion=$_POST["accion"];
$idbanco=$_POST["idbanco"];
$descbanco=$_POST["descbanco"];

$response = array("status" => "success");
// $log = new KLogger ( "ajaxgetbancossss.log" , KLogger::DEBUG );
try {
if($accion==1){
    $bancos             = $negocio->negocio_ListaBancos();
    $response["bancos"] = $bancos;
}else if($accion==2){
$lista=$negocio->negocioinsertbanco($idbanco,$descbanco);

 //$log->LogInfo("Valor de descbanco" . var_export ($descbanco, true)); 

if($lista["accion"]==1){
   $response["mensaje"] = "Actualmente tienes agregado este banco";	
}else { $response["mensaje"] = "";	

}


}
  
    //$log->LogInfo("Valor de response" . var_export ($response, true));

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No se puedo obtener lista de bancos";
}

echo json_encode($response);
