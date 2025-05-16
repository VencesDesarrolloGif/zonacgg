<?php
session_start();
require "conexion.php";
require_once("../libs/logger/KLogger.php");
$response = array();
$datos  = array();
$response["status"] = "error";
// $log = new KLogger ( "ajax_consultaRegistrosPatronales.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de variable _POST" . var_export ($_POST, true));

try {
      $sql = "SELECT  idcatalogoRegistrosPatronales, entidadRegistro, nombreEntidadFederativa
              FROM catalogoregistrospatronales
              LEFT JOIN entidadesfederativas ON (idEntidadFederativa=entidadRegistro)";
      // $log->LogInfo("Valor de variable sql" . var_export ($sql, true));
      $res = mysqli_query($conexion, $sql);
         while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
                $datos[] = $reg;
         }
      
      $response["status"] = "success";
      $response["datos"]  = $datos;

 }catch (Exception $e) {
    $response["mensaje"] = "Error al consultar documento SAT";
	}
echo json_encode($response);