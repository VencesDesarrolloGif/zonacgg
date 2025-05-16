<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$accion=$_POST["accion"];
$valorselector=$_POST["valorselector"];
$cuenta=$_POST["cuenta"];

$response = array("status" => "success");
// $log = new KLogger ( "ajaxgetbancossss.log" , KLogger::DEBUG );
try {
if($accion==1){
    $listacuentabancarias             = $negocio->negocio_ListaCuentasBancarias($valorselector);
    $response["bancos"] = $listacuentabancarias;
}else if($accion==2){
$lista=$negocio->negocioinsercuentabancaria($valorselector,$cuenta);

 //$log->LogInfo("Valor de descbanco" . var_export ($descbanco, true)); 

if($lista["accion"]==1){
   $response["mensaje"] = "Actualmente tienes agregada esta cuenta";	
}else { $response["mensaje"] = "";	

}


}
  
    //$log->LogInfo("Valor de response" . var_export ($response, true));

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No se puedo obtener lista de bancos";
}

echo json_encode($response);
