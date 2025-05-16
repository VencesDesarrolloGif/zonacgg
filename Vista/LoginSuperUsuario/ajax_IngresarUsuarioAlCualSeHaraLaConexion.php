<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
// $log = new KLogger ( "ajax_IngresarUsuarioAlCualSeHaraLaConexion.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));

try {
    $Usuario = $_POST ["Usuario"];
    $ipIngreso = $_POST ["ipIngreso"];

    $datos              = array();
    $sql = "SELECT max(histFechaInser) as fecha from historicoingresosuperusuariotemp where histipIngresadaTempS='$ipIngreso'";     
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }
    $FechaRegistro = $datos[0]["fecha"];  
   $sql1 = "UPDATE historicoingresosuperusuariotemp SET histUsuarioAceso='$Usuario'
            where histipIngresadaTempS='$ipIngreso'
            and histFechaInser='$FechaRegistro'";     
        $res1 = mysqli_query($conexion, $sql1);  
        if ($res1 !== true) {
            $response["status"] = "error";
            $response["message"]='error al ACTUALIZAR el usuario';
            return;
        }else{
            $response["status"]= "success";
            $response["message"]='El CambioDe Contraseña Se Realizó Correctamente';
        }
    $sql2 = "UPDATE ingresosuperusuariotemp SET UsuarioAceso='$Usuario'
            where ipIngresadaTempS='$ipIngreso'";     
        $res2 = mysqli_query($conexion, $sql2);  
        if ($res2 !== true) {
            $response["status"] = "error";
            $response["message"]='error al ACTUALIZAR el usuario';
            return;
        }else{
            $response["status"]= "success";
            $response["message"]='El CambioDe Contraseña Se Realizó Correctamente';
        }
}catch (Exception $e) {
    $response["message"] = "Error al registrar eL inicio De Sesion";}
echo json_encode($response);
