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

// $log = new KLogger ( "ajax_ConfirmarRevisionVacacionesPendientes.log" , KLogger::DEBUG );

$entidadEmpFiniquito=$_POST["entidadEmpFiniquito"];
$consecutivoEmpFiniquito=$_POST["consecutivoEmpFiniquito"];
$categoriaEmpFiniquito=$_POST["categoriaEmpFiniquito"];

// $log->LogInfo("Valor de _POST" . var_export ($_POST, true));


try {

    $DiasTrabajados  = $negocio -> InsertConfirmacionRevisionVacacionesPendientes($entidadEmpFiniquito,$consecutivoEmpFiniquito,$categoriaEmpFiniquito);
    $response["status"] = "success";
    $response["message"] = "Revisión Del Empleado Registrada Correcatmente";

    } catch (Exception $e) {
       $response["message"] = "Error Al Rgistrar La Revisión Del Empleado ";}
echo json_encode($response);
