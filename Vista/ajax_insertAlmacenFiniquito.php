<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$log = new KLogger ( "ajaxInsertAlmFin.log" , KLogger::DEBUG );
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array ();
$response ["status"] = "error";
$empleadoId=getValueFromPost("numeroEmpleado");

    $log->LogInfo("Valor de empleadoId" . var_export ($empleadoId, true));
try {
    $empleadoidd = explode("-", $empleadoId);
    $empleadoEntidad=$empleadoidd[0];
    $empleadoConsecutivo=$empleadoidd[1];
    $empleadoCategoria=$empleadoidd[2];

     $log->LogInfo("Valor de empleadoEntidad" . var_export ($empleadoEntidad, true));
     $log->LogInfo("Valor de empleadoConsecutivo" . var_export ($empleadoConsecutivo, true));
     $log->LogInfo("Valor de empleadoCategoria" . var_export ($empleadoCategoria, true));




     $insertInfoAlmFin = $negocio->insertDatosAlmFin($empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria);
     $response ["status"] = "success";
    }catch(Exception $e){
           $response["status"] = "error";
          }
    // $log->LogInfo("Valor de response" . var_export ($response, true));
echo json_encode($response);
?>