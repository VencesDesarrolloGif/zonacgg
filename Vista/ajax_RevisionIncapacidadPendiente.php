<?php
session_start();
require "conexion.php";
require_once("../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
// $log = new KLogger ( "ajax_RevisionIncapacidadPendiente.log" , KLogger::DEBUG ); 
// $log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
$empleadoEntidadId=$_POST["empleadoEntidadId"];
$empleadoConsecutivoId=$_POST["empleadoConsecutivoId"];
$empleadoTipoId=$_POST["empleadoTipoId"];
try {
    $sql = "SELECT ifnull(st2,'2') as ST2, ifnull(foliosincapacidades.folioIncapacidad,'sin_folio') as Folio,ifnull(foliosincapacidades.Dictamen,'0') as dictamen, ifnull(st7,'2') as ST7,ifnull(foliosincapacidades.tipoIncapacidad,'1') as inc
            from asistencia
            left join foliosincapacidades on (foliosincapacidades.folioIncapacidad=asistencia.folioIncapacidad)
            where empleadoEntidad = '$empleadoEntidadId'
            and empleadoConsecutivo = '$empleadoConsecutivoId'
            and empleadoTipo = '$empleadoTipoId'
            and fechaAsistencia = (SELECT max(fechaAsistencia) from asistencia where empleadoEntidad = '$empleadoEntidadId' and empleadoConsecutivo = '$empleadoConsecutivoId' and empleadoTipo = '$empleadoTipoId')";      
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }
    // $log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
    $response["status"]= "success";
    $incapacidad = $datos[0]["inc"];
    if($incapacidad == "2" || $incapacidad == 2){
        $response["st2"] = $datos[0]["ST2"];
        $response["folio"] = $datos[0]["Folio"];
        $response["dictamen"] = $datos[0]["dictamen"];
        $response["st7"] = $datos[0]["ST7"];
    }else{
        $response["st2"] = "2";
        $response["folio"] = "sin_folio";
        $response["dictamen"] = "0";
        $response["st7"] = "2";    
    }
    
}catch (Exception $e) {
    $response["mensaje"] = "Error al Obtener Matrices";}
echo json_encode($response);
