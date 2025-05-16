<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
//$log = new KLogger("edghghgh.log", KLogger::DEBUG);

$negocio           = new Negocio ();
$response          = array();
$response["status"]= "error";
$datos             = array();

try {
    $datos = $negocio -> obtenerListaHistoricoAL();

        for ($i = 0; $i < count($datos); $i++) {
        
        $DeudaEmpN = $datos[$i]["DeudaEmp"];
        $datos[$i]["DeudaEmp1"] = ($DeudaEmpN*(-1)); 
        }              
//$log->LogInfo("Valor de la variable DeudaEmp: " . var_export ($DeudaEmp, true));
                                                                              
    $response["status"] = "success";
    $response["datos"]  = $datos;
}catch (Exception $e) {
    $response["mensaje"]= "Error al iniciar sesion";}
echo json_encode($response);
