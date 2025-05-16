<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "success";
$datos              = array();
$datos1              = array();
// $log = new KLogger ( "ajax_eliminarUsuarioAsignado.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));  
try {

    $idRelacion  = $_POST["idRelacion"];
    
    $sql = "DELETE FROM relacionUsuarios_regiones WHERE idIncrementUR = '$idRelacion'"; 
    // $log->LogInfo("Valor de la variable sql: " . var_export ($sql, true));  
    $res = mysqli_query($conexion, $sql);  
    if ($res !== true) {
        $response["status"] = "error";
        $response["message"]='error al eliminar el usuario';
        return;
    }else{
        //se actualiza asistencia
        $response["message"]='Se eliminó exitosamente la entidad a la region';
    }
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
