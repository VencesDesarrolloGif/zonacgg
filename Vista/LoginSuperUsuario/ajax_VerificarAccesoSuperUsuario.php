<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");

$response           = array();
$response["status"] = "error";
$datos              = array();
$log = new KLogger ( "ajax_VerificarAccesoSuperUsuario.log" , KLogger::DEBUG );
$log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));
if (!empty ($_POST))
{
    $usuario = $_POST ["usuario"];
    $ipIngreso = $_POST ["ipIngreso"]; 
    
    $sql = "SELECT * from IngresoSuperUsuarioTemp
            where (UsuarioTempS='$usuario' or ipIngresadaTempS='$ipIngreso')";     
$log->LogInfo("Valor de la variable sql " . var_export ($sql, true));
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
        $response["status"]= "success";
        $response["datos"] = $datos;
        echo json_encode($response);
}else{
    $response["datos"] = $datos;
    $response["mensaje"] = "Error al iniciar sesion";
    include ("LoginSuperUsuario/form_LoginSuperUsuario.php");
    echo json_encode($response);
}
