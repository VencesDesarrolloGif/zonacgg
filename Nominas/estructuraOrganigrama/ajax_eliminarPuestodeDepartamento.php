<?php
session_start();
require "../conexion/conexion.php";
require_once("../logger/KLogger.php");
// $log = new KLogger ( "ajax_eliminarPuestodeDepartamento.log" , KLogger::DEBUG );
$response           = array();
$response["status"] = "error";
$idRelacion     = $_POST['idRelacion'];

try {
    $sql = "DELETE FROM relacionPuestosDepartamentos 
            WHERE idRelacion='$idRelacion'"; 
// $log->LogInfo("Valor de variable sql" . var_export ($sql, true));

        $res = mysqli_query($conexion, $sql);
        $response["status"] = "success";
   }catch (Exception $e) {
    $response["message"] = "Error al eliminarPuesto";
    }
echo json_encode($response);