<?php
session_start();
require "../conexion/conexion.php";
require_once("../logger/KLogger.php");
// $log = new KLogger ( "ajax_AgregarPuesto.log" , KLogger::DEBUG );
$response           = array();
$response["status"] = "error";
$idRelacion = $_POST['idRelacion'];
$depaAcargo = $_POST['depaAcargo'];

try {

    $sql = "UPDATE relacionDepartamentosNiveles 
            SET departamentoACargo='$depaAcargo'
            WHERE idRelacionDN='$idRelacion'"; 
    // $log->LogInfo("Valor de variable sql" . var_export ($sql, true));
        $res = mysqli_query($conexion, $sql);
        $response["status"] = "success";
   }catch (Exception $e) {
    $response["message"] = "Error al AgregarPuesto";
    }
echo json_encode($response);