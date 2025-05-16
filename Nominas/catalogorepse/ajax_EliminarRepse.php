<?php
session_start();
require "../conexion/conexion.php";
require_once("../logger/KLogger.php");
//$log = new KLogger ( "ajaxeliminarRepse.log" , KLogger::DEBUG );
$response           = array();
$response["status"] = "error";
$idRep     = $_POST['idRep'];

try {
    $sql = "DELETE FROM catalogorepse
             where idRepse = '$idRep'"; 
             $res = mysqli_query($conexion, $sql);
             $response["status"] = "success";
   }catch (Exception $e) {
    $response["message"] = "Error al eliminarRepse";
    }
echo json_encode($response);