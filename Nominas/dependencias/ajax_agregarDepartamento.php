<?php
session_start();
require "../conexion/conexion.php";
require_once("../logger/KLogger.php");
// $log = new KLogger ( "ajax_AgregarPuesto.log" , KLogger::DEBUG );
$response           = array();
$response["status"] = "error";
$idDepartamentoOrg     = $_POST['idDepartamentoOrg'];
$nivel = $_POST['nivel'];

try {
        $idActual = array();
    $sql1 = "SELECT IFNULL(MAX(idRelacionDN),0) as idRelacionActual
             FROM relacionDepartamentosNiveles";
    $res1 = mysqli_query($conexion, $sql1);
    while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))) {
        $idActual[] = $reg1;
    }

    $nuevoID= $idActual[0]['idRelacionActual']+1;

    $sql = "INSERT INTO relacionDepartamentosNiveles (idRelacionDN, idDepartamento, idNivel)
            VALUES('$nuevoID','$idDepartamentoOrg','$nivel')"; 
// $log->LogInfo("Valor de variable sql" . var_export ($sql, true));

        $res = mysqli_query($conexion, $sql);
        $response["status"] = "success";
   }catch (Exception $e) {
    $response["message"] = "Error al AgregarPuesto";
    }
echo json_encode($response);