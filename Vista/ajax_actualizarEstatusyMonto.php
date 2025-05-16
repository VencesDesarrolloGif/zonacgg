<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio 		   = new Negocio ();
$response          = array();
$response["status"]= "error";
$datos             = array();
$entidademp		   =$_POST["entidademp"];
$consecutivoemp	   =$_POST["consecutivoemp"];
$categoriaemp      =$_POST["categoriaemp"];
$MontoAcuerdo      =$_POST["MontoAcuerdo"];

try {
    $datos = $negocio -> ActualizarFiniquitoPiramidadoMonto($entidademp,$consecutivoemp,$categoriaemp,$MontoAcuerdo);
    $response["status"] = "success";
    
}catch (Exception $e) {
        $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);

