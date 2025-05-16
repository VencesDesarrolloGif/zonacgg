<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
//$log = new KLogger ( "ajax_AgregarentidadAMatriz.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
$response= array();
$response["status"]     = "success";

$IdEntidad      = $_POST["IdEntidad"];
$IdMatriz       = $_POST["IdMatriz"];
$entidad        = $_POST["entidad"];
$usuario        = $_SESSION ["userLog"]["usuario"];
$Estatusinicial = "1";
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
try{

    $sql1 = "insert into matricesEntidades(IdMatrizPrincipal, IdEntidadAsignada, nombreEntidadAsignada, UsuarioRegistroEntidad, FechaRegistroEntidad, EstatusEntidadesMatriz) values ('$IdMatriz','$IdEntidad','$entidad','$usuario',now(),'$Estatusinicial')";
    //$log->LogInfo("Ejecutando matricesEntidades  insert: " . $sql1);
    $res1 = mysqli_query($conexion, $sql1);  
    if ($res1 !== true) {
        $response["status"] = "error";
        $response["message"]='error al registrar la matriz';
        return;
    }else{
        //se actualiza asistencia
        $response["message"]='Se Realizó Correctamente El Registro ';
    }
    //$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
}catch (Exception $e) {
    $response["message"] = "Error al iniciar sesion";
}

echo json_encode($response);
?> 