<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");

$response           = array();
$response["status"] = "error";
$datos              = array();
// $log = new KLogger ( "ajax_VerifiacerSuperUsuario.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));
if (!empty ($_POST))
{
    $usuario = $_POST ["usuario"];
    $pass = md5($_POST ["pass"]); 
    
    $sql = "SELECT * from superusuarios
            where UsuarioS='$usuario'
            and contraseniaS='$pass'";     
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
        $response["status"]= "success";
        $response["datos"] = $datos;
        echo json_encode($response);
}else{
    $response["datos"] = $datos;
    $response["mensaje"] = "Error al iniciar sesion";
    include ("LoginSuperUsuario/form_LoginSuperUsuario.php");
    echo json_encode($response);
}
