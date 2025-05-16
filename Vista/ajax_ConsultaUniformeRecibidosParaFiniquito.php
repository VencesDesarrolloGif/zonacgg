<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
//$log = new KLogger("ajax_ConsultaUniformeRecibidosParaFiniquito.log", KLogger::DEBUG);

$negocio           = new Negocio ();
$response          = array();
$response["status"]= "error"; 
$datos             = array();

try {
    $datos = $negocio -> obtenerUniformesParaFiniq();

    /*for ($i = 0; $i < count($datos); $i++) {
        
        $entidadEmpAlm = $datos[$i]["entidadEmpAlm"];
        $ConsecutivoEmpAlm = $datos[$i]["ConsecutivoEmpAlm"];
        $CategoriaEmpAlm = $datos[$i]["CategoriaEmpAlm"];
        $FechaBaja = $datos[$i]["FechaBaja"];
        $FechaAlta = $datos[$i]["FechaAlta"];
        $Cobertura1 = $negocio -> obtenerCoberturaXEmpLaborales($FechaAlta,$FechaBaja,$entidadEmpAlm,$ConsecutivoEmpAlm,$CategoriaEmpAlm);
$log->LogInfo("Valor de la variable Cobertura1: " . var_export ($Cobertura1, true));

        $datos[$i]["Cobertura"] = $Cobertura1[0]["TOTAL"];
    }    */          
                                                                              
    $response["status"] = "success";
    $response["datos"]  = $datos;
}catch (Exception $e) {
    $response["mensaje"]= "Error al iniciar sesion";}
echo json_encode($response);
