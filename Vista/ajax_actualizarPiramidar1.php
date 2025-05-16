<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
//$log = new KLogger("Actír1.log", KLogger::DEBUG);

$negocio 			= new Negocio ();
$response           = array();
$response["status"] = "error";
$datos              = array();
$entidademp			=$_POST["entidademp"];
$consecutivoemp	    =$_POST["consecutivoemp"];
$categoriaemp		=$_POST["categoriaemp"];
$netoAlPagocalculado=$_POST["netoAlPagocalculado"];
$netoAlPago         =$_POST["netoAlPago"];
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));

try {
    $datos = $negocio -> ActualizarFiniquitoPiramidado1($entidademp,$consecutivoemp,$categoriaemp,$netoAlPago,$netoAlPagocalculado);

    $response["status"] = "success";
} catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
