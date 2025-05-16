<?php
session_start();
require "../conexion/conexion.php";
require_once("../logger/KLogger.php");
// $log = new KLogger ( "ajax_eliminarSubDependencia.log" , KLogger::DEBUG );
$response           = array();
$response["status"] = "error";
$idRelacion = $_POST['idRelacionDN'];

try {

    $sql = "UPDATE relacionDepartamentosNiveles 
            SET departamentoACargo='0'
            WHERE idRelacionDN='$idRelacion'"; 
    // $log->LogInfo("Valor de variable sql" . var_export ($sql, true));
        $res = mysqli_query($conexion, $sql);
        $response["status"] = "success";
   }catch (Exception $e) {
    $response["message"] = "Error al AgregarPuesto";
    }
echo json_encode($response);