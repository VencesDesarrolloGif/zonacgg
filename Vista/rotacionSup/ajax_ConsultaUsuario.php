<?php
session_start();
require "../conexion.php"; 
require_once("../../libs/logger/KLogger.php");
if (!isset($_SESSION["userLog"])) {
    header ("Location: https://zonagifseguridad.com.mx//zonagif/Vista/LoginSuperUsuario/form_LoginSuperUsuario.php");
    exit;
}
// $log=new KLogger("ajax_ConsultaUsuarios.log", KLogger::DEBUG);
// $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));     
$response = array();
$rol = $_SESSION["userLog"]["rol"];
$response["rol"] = $rol;
// $log->LogInfo("Valor de la variable response: " . var_export ($response, true));     
$response["status"] = "success";
echo json_encode($response);
