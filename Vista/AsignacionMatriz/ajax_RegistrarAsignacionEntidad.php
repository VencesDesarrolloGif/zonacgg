<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
//$log = new KLogger ( "ajax_RegistrarAsignacionEntidad.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
$response = array();
$datos    = array();
$response["status"]     = "success";

$IdMatriz            = $_POST["IdMatriz"];
$NumeroEmpleado      = $_POST["NumeroEmpleado"];
$UsuarioAsignacion   = $_POST["Usuario"];
$usuario             = $_SESSION ["userLog"]["usuario"];
$Estatusinicial      = "1";
$empleadoidd         = explode("-", $NumeroEmpleado);
$empleadoEntidad     = $empleadoidd[0];
$empleadoConsecutivo = $empleadoidd[1];
$empleadoCategoria   = $empleadoidd[2];

try{

    $sql = "insert into asignacionMatriz(IdEntidadAsignacion, IdConsecutivoAsignacion, IdCategoriaAsignacion, IdMatrizAsignacion, usuarioAsignacion, IdUsuarioRegistroAsignacion, FechaRegistroAsignacion, estatusAsigacionMatriz) values ('$empleadoEntidad','$empleadoConsecutivo','$empleadoCategoria','$IdMatriz','$UsuarioAsignacion','$usuario',now(),'$Estatusinicial')";
    $res = mysqli_query($conexion, $sql);  
    if ($res !== true) {
        $response["status"] = "error";
        $response["message"]='error al registrar la matriz';
        return;
    }else{
        //se actualiza asistencia
        $response["message"]='La Asignación Se Realizó Correctamente';
    }

    $sql1 = "UPDATE matrices set EstatusAsignacion='$Estatusinicial'
            where IdMatriz='$IdMatriz'";

   // $log->LogInfo("Ejecutando asignacionMatriz  insert: " . $sql1);
    $res1 = mysqli_query($conexion, $sql1);  
    if ($res1 !== true) {
        $response["status"] = "error";
        $response["message"]='error al registrar la matriz';
        return;
    }else{
        //se actualiza asistencia
        $response["message"]='La Asignación Se Realizó Correctamente';
    }
}catch (Exception $e) {
    $response["status"] = "error";
    $response["message"] = "Error al Registrar Matriz";
}
echo json_encode($response);
?> 