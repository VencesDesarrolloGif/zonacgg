<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
//$log = new KLogger("getEstatusPago.log", KLogger::DEBUG);
$negocio = new Negocio ();
$response           = array();
$response["status"] = "error";
$datos              = array();
$entidadempDeu	  =$_POST["entidadempDeu"];
$consecutivoempDeu=$_POST["consecutivoempDeu"];
$categoriaempDeu  =$_POST["categoriaempDeu"];


//$log->LogInfo("Valor de la variable entidadempDeu: " . var_export ($entidadempDeu, true));
//$log->LogInfo("Valor de la variable consecutivoempDeu: " . var_export ($consecutivoempDeu, true));
//$log->LogInfo("Valor de la variable categoriaempDeu: " . var_export ($categoriaempDeu, true));
try {
    $datos = $negocio -> ObtenerEstatusPAgo($entidadempDeu,$consecutivoempDeu,$categoriaempDeu);
	//$log->LogInfo("Valor de la variable categoriaempDeu: " . var_export ($datos, true));


    $response["status"] = "success";
    $response["datos"]  = $datos;
} catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
