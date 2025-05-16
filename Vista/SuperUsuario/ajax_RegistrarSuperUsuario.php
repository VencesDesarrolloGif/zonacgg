<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
$log = new KLogger ( "ajax_RegistrarSuperUsuario.log" , KLogger::DEBUG );
$log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));

try {
    $UsuarioSU = $_POST ["Usuario"];
    $Contrasenia = $_POST ["Contrasenia"];
    $NumeroE1 = $_POST ["NumeroE"];
    $ExplodeEmp = explode("-", $NumeroE1);
    $EmpEntidad = $ExplodeEmp[0];
    $EmpConsecutivo = $ExplodeEmp[1];
    $EmpCategoria = $ExplodeEmp[2];
    $usuario             = $_SESSION ["userLog"]["usuario"];
    $estatusSuperUsuario="1";/* Indica El estatus del usuario indicando que esta activo
    1=Activo
    0=Bloqueo
    2=Reactivado Siguiendo el cataolog estua empleado
    */
    $estatusREvisionSU="0";// indica que aun no esta revisado por el encargado del usuario 
    //$log->LogInfo("Valor de la variable ExplodeEmp " . var_export ($ExplodeEmp, true));
    //$log->LogInfo("Valor de la variable EmpEntidad " . var_export ($EmpEntidad, true));
    //$log->LogInfo("Valor de la variable EmpConsecutivo " . var_export ($EmpConsecutivo, true));
    $sql = "INSERT into SuperUsuarios(UsuarioS, contraseniaS, empleadoEntidadSuperU, empleadoConsecutivoSuperU, empleadoCategoriaSuperU, UsuarioCreacionSuperU, FechaCreacionSuperU, EstatusSuperU, EstarusVerificacionSuperU) values ('$UsuarioSU',md5('$Contrasenia'),'$EmpEntidad','$EmpConsecutivo','$EmpCategoria','$usuario',now(),'$estatusSuperUsuario','$estatusREvisionSU')";     
    $log->LogInfo("Valor de la variable sql " . var_export ($sql, true));
        $res = mysqli_query($conexion, $sql);  
    if ($res !== true) {
        $response["status"] = "error";
        $response["message"]='error al registrar la matriz';
        return;
    }else{
        $response["status"]= "success";
        $response["message"]='La Asignación Se Realizó Correctamente';
    }

}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
