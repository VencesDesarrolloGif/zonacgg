<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
//$log = new KLogger("aCTUALIZar.log", KLogger::DEBUG);
$negocio = new Negocio ();
$response           = array();
$response["status"] = "error";
$datos              = array();
$entidademp=$_POST["entidademp"];
$consecutivoemp=$_POST["consecutivoemp"];
$categoriaemp=$_POST["categoriaemp"];
$opcion=$_POST["opcion"];
$MontoAcordadoCalculado=$_POST["MontoAcordadoCalculado"];
$netoAlPago = $_POST["netoAlPago"];

//$log->LogInfo("Valor de la variable netoAlPago: " . var_export ($netoAlPago, true));

try {
    $datos = $negocio -> ActualizarFiniquitoPiramidadoDG($entidademp,$consecutivoemp,$categoriaemp,$netoAlPago,$opcion,$MontoAcordadoCalculado);
    $response["status"] = "success";
    $response["datos"]  = $datos;
} catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
