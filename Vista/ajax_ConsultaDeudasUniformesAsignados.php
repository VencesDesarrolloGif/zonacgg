<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
//$log = new KLogger("consultaDeudas.log", KLogger::DEBUG);
$negocio           = new Negocio ();
$response          = array();
$response["status"]= "error";
$datos             = array();
try {
    $datos = $negocio -> obtenerUnifAsigDeuda();
/*
        for($i = 0; $i < count($datos); $i++) {
             $cantidadUnifDeuda= $datos[$i]["cantidadUnifDeuda"]; 
          if($cantidadUnifDeuda==2) {
             $datos[$i]["montoDeuda"]=($datos[$i]["montoDeuda"])*2;
            }else{
                  $datos[$i]["montoDeuda"]= $datos[$i]["montoDeuda"]; 
                 }
            }         */
    //$log->LogInfo("Valor de la variable costoUniforme: " . var_export ($costoUniforme, true));
    $response["status"] = "success";
    $response["datos"]  = $datos;
}catch (Exception $e) {
    $response["mensaje"]= "Error al iniciar sesion";}
echo json_encode($response);
