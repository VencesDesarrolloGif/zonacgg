<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
//$log = new KLogger ( "ajax_ConsultaEstatusSupervisoresCentroDeControl.log" , KLogger::DEBUG );
$idIncidencia = $_POST['idIncidencia'];
try {
    $sql = " SELECT concat_ws('-',SupEntidadIncidenciaCC,SupConsecutivoIncidenciaCC,SupCategoriaIncidenciaCC) as NumeroSupervisor,NombreSupIncidenciaCC as NombreSupervisor,FechaEdicionSupIncidenciaCC as FechaRevision,EstatusRevisionIncidenciaCC as EstatusRevision from ReporteIncidenciaSupervisoresCentroControl
        where idIncidenciaSupCC='$idIncidencia'";
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    for($i = 0; $i < count($datos); $i++){
        $EstatusRevision = $datos[$i]["EstatusRevision"]; 

        if($EstatusRevision == "2"){
            $datos[$i]["Estatus"]= "NO REVISADA";
        }else{
            $datos[$i]["Estatus"]= "REVISADA";
        } 
    }
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
