<?php
session_start();
require "../conexion/conexion.php";
require_once("../logger/KLogger.php");
// $log = new KLogger ( "ajax_eliminarPuesto.log" , KLogger::DEBUG );
$response           = array();
$response["status"] = "error";
$idPuesto     = $_POST['idPuesto'];

try {
    $sql = "UPDATE catalogopuestos 
            SET idNivelAsignado='0'
            WHERE idPuesto='$idPuesto'"; 
// $log->LogInfo("Valor de variable sql" . var_export ($sql, true));

        $res = mysqli_query($conexion, $sql);
        $response["status"] = "success";
   }catch (Exception $e) {
    $response["message"] = "Error al eliminarPuesto";
    }
echo json_encode($response);