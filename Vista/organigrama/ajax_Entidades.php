<?php
session_start();
require "../conexion.php";
require_once ("../../libs/logger/KLogger.php");
date_default_timezone_set('America/Mexico_City');
// $log = new KLogger ("ajax_Entidades.log" , KLogger::DEBUG );
$response = array();
$response["status"] = "error";

$region = array();
$entidades = array();

$linea=$_POST['linea'];
$entidad = $_SESSION["userLog"]["entidadFederativaUsuario"][0];
$rol = $_SESSION["userLog"]["rol"];

try{
    if($rol=="Direccion General"){

       $sql1 = " SELECT idEntidadFederativa, nombreEntidadFederativa
                 FROM entidadesfederativas 
                 WHERE idEntidadFederativa!='33'
                 AND idEntidadFederativa!='50'";

          $res1 = mysqli_query($conexion, $sql1);
          while(($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
                 $entidades[] = $reg1;
          }
    }else{
          $sql = " SELECT idRegionI 
                   FROM index_regiones
                   WHERE idEntidadI='$entidad'
                   AND idLineaNegI='$linea'";

          $res = mysqli_query($conexion, $sql);
          while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
                 $region[] = $reg;
          }

              $idRegion = $region[0]["idRegionI"];

          $sql1 = " SELECT ef.idEntidadFederativa, ef.nombreEntidadFederativa
                    FROM index_regiones ir
                    LEFT JOIN entidadesfederativas ef ON ef.idEntidadFederativa=ir.idEntidadI
                    WHERE idRegionI='$idRegion'
                    AND idLineaNegI='$linea'
                    AND ir.idEntidadI!='50'";

          $res1 = mysqli_query($conexion, $sql1);
          while(($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
                 $entidades[] = $reg1;
          }
    }
    // $log->LogInfo("Valor de variable entidades" . var_export ($entidades, true));
    $response["entidades"] = $entidades;
    $response["status"] = "success";
}catch(Exception $e){
       $response["message"] = "Error al iniciar sesion";
}
echo json_encode($response);