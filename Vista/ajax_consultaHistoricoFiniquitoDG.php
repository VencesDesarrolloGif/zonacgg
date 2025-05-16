<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
//$log               = new KLogger("ajax_consultaHistoricoFiniquitoDGaaaaaaaaaaaaaaaaaa.log", KLogger::DEBUG);
//$log->LogInfo("Valor de la variable datos1: " . var_export ($datos, true));     
$negocio            = new Negocio ();
$response           = array();
$response["status"] = "error";
$datos              = array();
$usuario            = $_SESSION ["userLog"]["usuario"];

try {
    $datos = $negocio -> obtenerListaHistoricoFiniquitosDG();
    for ($i = 0; $i < count($datos); $i++) {  
     
        $FiniquitoAcordado = $datos[$i]["FiniquitoAcordado"];
        $numempleado       = $datos[$i]["numempleado"];        
        $Estatus           = $datos[$i]["Estatus"];    
        $FechaAcción       = $datos[$i]["FechaAcción"];

        if($Estatus== '3' ){
             $datos[$i]["Estatus"]   = "<label style='color:green'> Finiquito Aceptado </label>";

        }if($Estatus== "4" ){
         $datos[$i]["Estatus"]       = "<label style='color:red'> Finiquito Rechazado </label>";
         }                                              
    }
    $response["status"] = "success";
    $response["datos"]  = $datos;
} catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
