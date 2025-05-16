<?php
session_start();
require "../conexion.php";
require_once ("../../libs/logger/KLogger.php");
$response           = array();
$niveles            = array();
$response["status"] = "error";
$log = new KLogger ("ajax_ConsultaNiveles.log" , KLogger::DEBUG );
try {
    $sql = "SELECT idNivelOrg,descripcionNivel
            FROM catalogo_organigramaniveles";
    $res = mysqli_query($conexion, $sql);

    while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
           $niveles[] = $reg;
    }
    $log->LogInfo("Valor de variable niveles" . var_export ($niveles, true));
    $response["status"] = "success";
    $response["niveles"]  = $niveles;
}catch(Exception $e){
       $response["message"] = "Error al iniciar sesion";
}
echo json_encode($response);