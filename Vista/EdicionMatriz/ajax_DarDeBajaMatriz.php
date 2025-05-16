<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
//$log = new KLogger ( "ajax_DarDeBajaMatriz.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
$response= array();
$response["status"]     = "success";

$IdMatriz      = $_POST["IdMatriz"];
$usuario        = $_SESSION ["userLog"]["usuario"];
$EstatusEdicion = "0";
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
try{

   $sql = "UPDATE matrices 
            SET UsuarioEdicionMatriz='$usuario',FechaEdicionMatriz=now(),EstatusMatriz='$EstatusEdicion'
            WHERE IdMatriz='$IdMatriz'";
    
    //$log->LogInfo("Ejecutando matricesEntidades: " . $sql);
    
    $res = mysqli_query($conexion, $sql);  
    if ($res !== true) {
        $response["status"] = "error";
        $response["message"]='error al actualizar petición';
        return;
    }else{
        //se actualiza asistencia
        $response["message"]='Se actualizó correctamente la petición';
    }

    $sql1 = "UPDATE matricesEntidades 
            SET UsuarioEdicionEntidad='$usuario',FechaEdicionEntidad=now(),EstatusEntidadesMatriz='$EstatusEdicion'
            WHERE IdMatrizPrincipal='$IdMatriz'
            and EstatusEntidadesMatriz ='1'";
    
    //$log->LogInfo("Ejecutando matricesEntidades: " . $sql1);
    
    $res1 = mysqli_query($conexion, $sql1);  
    if ($res1 !== true) {
        $response["status"] = "error";
        $response["message"]='error al actualizar petición';
        return;
    }else{
        //se actualiza asistencia
        $response["message"]='Se actualizó correctamente la petición';
    }

    //$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
}catch (Exception $e) {
    $response["message"] = "Error al iniciar sesion";
}

echo json_encode($response);
?> 