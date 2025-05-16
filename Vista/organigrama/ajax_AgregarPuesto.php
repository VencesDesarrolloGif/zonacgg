<?php
session_start();
require "../conexion/conexion.php";
require_once("../logger/KLogger.php");
// $log = new KLogger ( "ajax_AgregarPuesto.log" , KLogger::DEBUG );
$response           = array();
$response["status"] = "error";
$idPuesto     = $_POST['idPuesto'];
$nivel = $_POST['nivel'];

try {
    $sql = "UPDATE catalogopuestos 
            SET idNivelAsignado='$nivel'
            WHERE idPuesto='$idPuesto'"; 
// $log->LogInfo("Valor de variable sql" . var_export ($sql, true));

        $res = mysqli_query($conexion, $sql);
        $response["status"] = "success";
   }catch (Exception $e) {
    $response["message"] = "Error al AgregarPuesto";
    }
echo json_encode($response);