<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
//$log = new KLogger ( "ajax_ActualizarPeticionCapacitacion.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
$response= array();
$response["status"]     = "success";
 
$idpeticion             = $_POST["idpeticion"];
$accion                 = $_POST["accion"];
$empleadoEntidadId      = $_POST["empleadoEntidadId"];
$empleadoConsecutivoId  = $_POST["empleadoConsecutivoId"];
$empleadoTipoId         = $_POST["empleadoTipoId"];
$incidenciaId           = $_POST["incidenciaId"];
$asistenciaFecha        = $_POST["asistenciaFecha"];
$comentariogrl          = $_POST["comentariogrl"];
$usuario                = $_SESSION ["userLog"]["usuario"];
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
try{

    $sql = "UPDATE peticionesturnoscapacitacion 
            SET estatusPeticion='$accion',
            fechaAccion=now(),
            usuarioCapturaPeticion='$usuario',
            comentarioAccion='$comentariogrl'
            WHERE idPeticion='$idpeticion'";
    
    //$log->LogInfo("Ejecutando getListaEmpleadosByPeriodoGeneral: " . $sql);
    
    $res = mysqli_query($conexion, $sql);  
    //$log->LogInfo("Valor de la variable res: " . var_export ($res, true));
    if ($res !== true) {
        $response["status"] = "error";
        $response["message"]='error al actualizar petición';
        return;
    }else{
        //se actualiza asistencia
        $response["message"]='Se actualizó correctamente la petición';
    }
    if($accion == "2"){
        $sql1 = "UPDATE asistencia 
            SET Capacitacion='1'
            where empleadoEntidad='$empleadoEntidadId'
            and empleadoConsecutivo='$empleadoConsecutivoId'
            and empleadoTipo='$empleadoTipoId'
            and fechaAsistencia='$asistenciaFecha'
            and incidenciaAsistenciaId='$incidenciaId'";
    
      //$log->LogInfo("Ejecutando getListaEmpleadosByPeriodoGeneral: " . $sql1);
    
        $res1 = mysqli_query($conexion, $sql1);  
        if ($res1 !== true) {
            $response["status"] = "error";
            $response["message"]='error al actualizar petición En asistencia Capacitacion';
            return;
        }else{
            //se actualiza asistencia
            $response["message"]='Se actualizó correctamente la petición';
        }
    }
    //$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
}catch (Exception $e) {
    $response["message"] = "Error al iniciar sesion";
}

echo json_encode($response);
?> 