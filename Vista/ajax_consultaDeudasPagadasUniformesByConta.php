<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
// $log = new KLogger("consultaDeudas.log", KLogger::DEBUG);
$negocio           = new Negocio ();
$response          = array();
$response["status"]= "error";
$datos             = array();
try {
    $datos = $negocio -> obtenerUnifPagadosBYcontabilidad();
    // $log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));
$largodeudas= count($datos);

if ($largodeudas !=0){
    for ($i=0; $i < $largodeudas; $i++) { 
        $estatusD = $datos[$i]["estatusDeuda"];
     if ($estatusD=='1') {
         $datos[$i]["estatusDeuda"] = "<label style='color:green'>Pagado</label>";
        }
    }
}

    $response["status"] = "success";
    $response["datos"]  = $datos;
}catch (Exception $e) {
    $response["mensaje"]= "Error al iniciar sesion";}
echo json_encode($response);
