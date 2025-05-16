<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio ();
$response           = array();
$response["status"] = "error";
$datos              = array();
$fechaInicioPeriodo= $_POST["fechaInicioPeriodo"]; 
$fechaTerminoPeriodo= $_POST["fechaTerminoPeriodo"];
$caso= $_POST["caso"];
try {
//$log = new KLogger ( "ajax_consultaPeticionesAsistenciaMermaParaCerrar.log" , KLogger::DEBUG );

    $datos = $negocio -> obtenerListaPeticionesAsistenciaParaMErma($fechaInicioPeriodo,$fechaTerminoPeriodo,$caso);
    $datosLargo = count($datos);
//    $log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));

    $response["status"] = "success";
    $response["datos"]  = $datosLargo;
 //   $response["datos1"]  = $datos1;
    } catch (Exception $e) {
       $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
