<?php
session_start();
require "../conexion/conexion.php";
require_once("../logger/KLogger.php");
// $log = new KLogger ( "ajax_ConsultaVigenciaTP.log" , KLogger::DEBUG );
$response           = array();
$response["status"] = "error";
$datos              = array();
$fechaExpedicion =$_POST['fechaExpedicionAdd'];
$fechaVigencia   =$_POST['fechaVigenciaAdd'];
$registroPatronal=$_POST['registroPatronal'];

try {

    $sql1="SELECT count(idTarjetasPatronales) as existeTarjetaVigente,idTarjetasPatronales
           FROM catalogotarjetaspatronales
           WHERE (fechaExpedicion <= CAST('$fechaExpedicion' AS DATE) OR fechaExpedicion <= CAST('$fechaVigencia' AS DATE))
           AND (fechaFinVigencia >= CAST('$fechaExpedicion' AS DATE) OR fechaFinVigencia >= CAST('$fechaVigencia' AS DATE))
           AND estatusEliminadoTarjetasPatronales='0'
           AND registroPatronalTarjeta='$registroPatronal'";
        // $log->LogInfo("Valor de variable sql1" . var_export ($sql1, true));

    $res1 = mysqli_query($conexion, $sql1);
    while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
            $datos[] = $reg1;
    }

    $existencia=$datos[0]["existeTarjetaVigente"];
    $response["idTarjetaActiva"]=$datos[0]["idTarjetasPatronales"];
        // $log->LogInfo("Valor de variable existencia" . var_export ($existencia, true));

    if($existencia!=0) {
       $response["status"] = "error";
    }else{
          $response["status"] = "success";
    }

 }catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";
	}
        // $log->LogInfo("Valor de variable response" . var_export ($response, true));

echo json_encode($response);