<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
//$log = new KLogger ( "ajax_DesAsignarMatriz.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
$response = array();
$datos    = array();
$response["status"]     = "success";

$IdMatriz            = $_POST["IdMatriz"];
$NumeroEmpleado      = $_POST["NumeroEmpleado"];
$UsuarioAsignacion   = $_POST["Usuario"];
$usuario             = $_SESSION ["userLog"]["usuario"];
$EstatusDesAsignar   = "0";
$empleadoidd         = explode("-", $NumeroEmpleado);
$empleadoEntidad     = $empleadoidd[0];
$empleadoConsecutivo = $empleadoidd[1];
$empleadoCategoria   = $empleadoidd[2];

try{

    $sql = "UPDATE asignacionMatriz set estatusAsigacionMatriz='$EstatusDesAsignar',IdUsuarioEdicionAsignacion='$usuario',FechaEdicionAsignacion=now()
            where IdEntidadAsignacion='$empleadoEntidad'
            and IdConsecutivoAsignacion='$empleadoConsecutivo'
            and IdCategoriaAsignacion='$empleadoCategoria'
            and estatusAsigacionMatriz='1'
            and IdMatrizAsignacion='$IdMatriz'
            AND usuarioAsignacion='$UsuarioAsignacion'";

    //$log->LogInfo("Ejecutando asignacionMatriz  insert: " . $sql);
    $res = mysqli_query($conexion, $sql);  
    if ($res !== true) {
        $response["status"] = "error";
        $response["message"]='error al registrar la matriz';
        return;
    }else{
        //se actualiza asistencia
        $response["message"]='Se Quito La Asignación Correctamente';
    }

    $sql1 = "UPDATE matrices set EstatusAsignacion='$EstatusDesAsignar'
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
    $response["message"] = "Error al Registrar Matriz";
}
echo json_encode($response);
?> 