<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "success";
$datos              = array();
$datos1              = array();
// $log = new KLogger ( "ajax_eliminarClienteAsignado.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));  
try {

    $idRelacionCliente  = $_POST["idRelacionCliente"];
    
    $sql = "DELETE FROM relacionUsuarios_clientes WHERE idIncrementUC = '$idRelacionCliente'"; 
    // $log->LogInfo("Valor de la variable sql: " . var_export ($sql, true));  
    $res = mysqli_query($conexion, $sql);  
    if ($res !== true) {
        $response["status"] = "error";
        $response["message"]='error al eliminar el cliente';
        return;
    }else{
        $response["message"]='Se eliminó exitosamente la relacion con el cliente';
    }
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
