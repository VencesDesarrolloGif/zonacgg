<?php
session_start();
require "../conexion.php";
require_once ("../../libs/logger/KLogger.php");
date_default_timezone_set('America/Mexico_City');
$response = array();
$lineas = array();
$catalogoLN = array();
$response["status"] = "error";
$log = new KLogger ("ajax_lineasNegocio.log" , KLogger::DEBUG );
$entidad = $_SESSION["userLog"]["lineaNegocioUsuario"][0];

    $log->LogInfo("Valor de variable session" . var_export ($_SESSION, true));
    $log->LogInfo("Valor de variable session1" . var_export ($_SESSION["userLog"]["lineaNegocioUsuario"], true));


try{
    for($i=0; $i < count($_SESSION["userLog"]["lineaNegocioUsuario"]); $i++) { 
        $linea= $_SESSION["userLog"]["lineaNegocioUsuario"][$i];

        $sql = " SELECT idLineaNegocio, descripcionLineaNegocio 
                 FROM catalogolineanegocio
                 WHERE  idLineaNegocio=$linea";
        $res = mysqli_query($conexion, $sql);
        while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
               $catalogoLN[] = $reg;
        }

        $lineas[$i]["idLN"] = $catalogoLN[0]["idLineaNegocio"];
        $lineas[$i]["descripcionLN"] = $catalogoLN[0]["descripcionLineaNegocio"];
    }
    $log->LogInfo("Valor de variable lineas" . var_export ($lineas, true));

    $response["lineas"] = $lineas;
    $response["status"] = "success";
}catch(Exception $e){
       $response["message"] = "Error al iniciar sesion";
}
echo json_encode($response);