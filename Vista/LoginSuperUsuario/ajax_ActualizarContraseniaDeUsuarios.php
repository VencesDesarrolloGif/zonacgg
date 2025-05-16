<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
// $log = new KLogger ( "ajax_ActualizarContraseniaDeUsuarios.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));

try {
    $usuariosParaGuardar = $_POST ["usuariosParaGuardar"];
    $CambioContrasenia = md5($_POST ["CambioContrasenia"]);
    $NumEmp = $_POST ["NumEmp"];
    $constrasenia = $_POST ["constrasenia"];
    for ($i=0; $i <count($usuariosParaGuardar) ; $i++) { 

        $Usuario = $usuariosParaGuardar[$i];
        $sql = "UPDATE usuarios SET contrasenia='$CambioContrasenia',fechaEdit=now(),EmpleadoEdit='$NumEmp',ContraseniaEmpEdit='$constrasenia'
            where usuario='$Usuario'";     
        $res = mysqli_query($conexion, $sql);  
        if ($res !== true) {
            $response["status"] = "error";
            $response["message"]='error al ACTUALIZAR el usuario';
            return;
        }else{
            $response["status"]= "success";
            $response["message"]='El CambioDe Contraseña Se Realizó Correctamente';
        }
    }
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
