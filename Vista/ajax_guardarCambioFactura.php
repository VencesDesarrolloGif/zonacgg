<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
$response = array ();
verificarInicioSesion($negocio);
//$log = new KLogger ( "ajax_updateRequisicion.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable \$requisicion: " . var_export ($requisicion, true));
$usuario = $_SESSION ["userLog"]["usuario"];
$facturaId=getValueFromPost("facturaId");
$mercanciaEntregada=getValueFromPost("mercanciaEntregada");
$facturaPagada=getValueFromPost("facturaPagada");

try{
    $negocio -> updateFactura($facturaId,$mercanciaEntregada,$facturaPagada);
    $response ["status"] = "success";
    $response ["message"] = "La factura fue editada";
}catch (Exception $e){
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }
echo json_encode ($response);
?>