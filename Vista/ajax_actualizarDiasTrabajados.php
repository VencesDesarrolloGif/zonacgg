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
// $log = new KLogger("AjaxActualizarDiasTrabajados.log", KLogger::DEBUG);


$entidadempleado=$_POST["entidadempleado"];
$consecutivoemp=$_POST["consecutivoemp"];
$categoriaemp=$_POST["categoriaemp"];
$DiasTrabajados1= $_POST["DiasTrabajados1"];
// $log->LogInfo("Valor de la variable qry:  " . var_export($_POST, true));

try {
    $datos = $negocio -> ActualizarDiasTrabajados($entidadempleado,$consecutivoemp,$categoriaemp,$DiasTrabajados1);
   
    $response["status"] = "success";
    $response["datos"]  = $datos;

    } 
    catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
