<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "success";
$datos              = array();
$datos1              = array();
// $log = new KLogger ( "ajax_AgregarEliminarRegion.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));  
try {
    $idRegion = $_POST["idRegion"];
    $opcion   = $_POST["opcion"];//2 es eliminar  1 es agregar , 3 es reactivar
    $usuario  = $_SESSION ["userLog"]["usuario"];
    if($opcion =="1"){
        $sql = "INSERT INTO catalogoRegiones (IdRegiones, DescripcionRegiones,EstatusRegion,UsuarioEdicion,FechaEdicion)VALUES (null, '$idRegion','1','$usuario',now())";
    }else if($opcion =="2"){
        $sql = "UPDATE catalogoRegiones set EstatusRegion='0',UsuarioEdicion='$usuario',FechaEdicion=now() WHERE IdRegiones = '$idRegion'"; 
    }else if($opcion =="3"){
        $sql = "UPDATE catalogoRegiones set EstatusRegion='1',UsuarioEdicion='$usuario',FechaEdicion=now() WHERE IdRegiones = '$idRegion'"; 
    }
    // $log->LogInfo("Valor de la variable sql: " . var_export ($sql, true));  
    $res = mysqli_query($conexion, $sql);  
    if ($res !== true) {
        $response["status"] = "error";
        $response["message"]='error al enviar la entidad a la region';
        return;
    }else{
        if($opcion =="1"){
            $response["message"]='Se Guardo Exitosamente Nueva Region';
        }else{
            $response["message"]='Se Eliminó Exitosamente Region';
        }
    }
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
