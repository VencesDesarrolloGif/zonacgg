<?php
session_start();
require_once("../../libs/logger/KLogger.php");
require "../conexion.php";
// $log = new KLogger("ajax_consultaEntidadesXUser.log", KLogger::DEBUG);
$response = array();
$response["status"]= "error";
$nombreEF     = array();

$entidadesAconsultar = $_SESSION["userLog"]["entidadFederativaUsuario"];
                                                                     
try {
    for($r=0; $r < count($entidadesAconsultar); $r++){

        $idEF= $entidadesAconsultar[$r]; 

        if($idEF!='33' && $idEF!='50'){
            $sql3="SELECT idEntidadFederativa,nombreEntidadFederativa 
                   FROM entidadesfederativas
                   WHERE idEntidadFederativa='$idEF'";
            $res3 = mysqli_query($conexion, $sql3);

            while($reg3 = mysqli_fetch_array($res3, MYSQLI_ASSOC)) {
                  $nombreEF[]=$reg3;
            }
            $entidadesArreglo[$r]= $nombreEF[$r];
        }
    }
    $response["entidades"]=$entidadesArreglo;
    $response["status"] = "success"; 
    // $log->LogInfo("Valor de la variable response: " . var_export ($response, true));                                                                      
}catch(Exception $e) {
       $response["mensaje"]= "Error al Consultar Adeudos Empleados";
      }
echo json_encode($response);
