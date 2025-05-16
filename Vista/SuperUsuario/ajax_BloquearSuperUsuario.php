<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
//$log = new KLogger ( "ajax_BloquearSuperUsuario.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));

try {
    $UsuarioSU = $_POST ["usuario"];
    $NumeroE1 = $_POST ["NumeroEmpleadoBLoqueo"];
    $ExplodeEmp = explode("-", $NumeroE1);
    $EmpEntidad = $ExplodeEmp[0];
    $EmpConsecutivo = $ExplodeEmp[1];
    $EmpCategoria = $ExplodeEmp[2];
    $usuario             = $_SESSION ["userLog"]["usuario"];
    $estatusSuperUsuario="0";/* Indica El estatus del usuario indicando que esta bloqueado
    1=Activo
    0=Bloqueo
    2=Reactivado Siguiendo el cataolog estua empleado
    */
    $sql = "UPDATE superusuarios set UsuarioBoqueoSuperU='$usuario',FechaBoqueoSuperU=now(),EstatusSuperU='$estatusSuperUsuario'
            where UsuarioS='$UsuarioSU'
            and empleadoEntidadSuperU='$EmpEntidad'
            and empleadoConsecutivoSuperU='$EmpConsecutivo'
            and empleadoCategoriaSuperU='$EmpCategoria'";     
        $res = mysqli_query($conexion, $sql);  
    if ($res !== true) {
        $response["status"] = "error";
        $response["message"]='error al ACTUALIZAR el super usuario';
        return;
    }else{
        $response["status"]= "success";
        $response["message"]='El bloqueo Se Realizó Correctamente';
    }
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
