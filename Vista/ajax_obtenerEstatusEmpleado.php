<?php
session_start();
require_once("../libs/logger/KLogger.php"); 
require "conexion.php";
// $log = new KLogger("ajax_obtenerEstatusEmpleado.log", KLogger::DEBUG); 
$response = array();
$response["status"]= "error";
$TotalEstatus= array();
$datosDierectorio= array();
$numeroEmpleado = $_POST["numeroEmpleado"]; 
$empleadoConDirectorio = "0";
try {

    $sql = "SELECT ifnull(e.empleadoEstatusId,'0') as empleadoEstatusId,ifnull(e.estatusEmpleadoOperaciones,'0') as estatusEmpleadoOperaciones,ifnull(d.empleadoEstatusImss,'0') as empleadoEstatusImss from empleados e
            left join datosimss d On (e.entidadFederativaId=d.empladoEntidadImss and e.empleadoConsecutivoId=d.empleadoConsecutivoImss and e.empleadoCategoriaId=d.empleadoCategoriaImss)
            where concat_ws('-',e.entidadFederativaId,e.empleadoConsecutivoId,e.empleadoCategoriaId) = '$numeroEmpleado'";
    $res = mysqli_query($conexion, $sql);
    while($reg = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
          $TotalEstatus[]=$reg;
    }
    $empleadoEstatusId          = $TotalEstatus[0]["empleadoEstatusId"];
    $estatusEmpleadoOperaciones = $TotalEstatus[0]["estatusEmpleadoOperaciones"];
    $empleadoEstatusImss        = $TotalEstatus[0]["empleadoEstatusImss"];
    if(($empleadoEstatusId == "1" || $empleadoEstatusId == "2") && ($estatusEmpleadoOperaciones == "1" || $estatusEmpleadoOperaciones == "4") && ($empleadoEstatusImss == "3" || $empleadoEstatusImss == "8")){
        $response["status"] = "success";
        $response["accion"] = "2";
    }else if($empleadoEstatusId == "0"  && $estatusEmpleadoOperaciones == "0" && ($empleadoEstatusImss == "7" || $empleadoEstatusImss == "8") ){
        $response["status"] = "success";
        $response["accion"] = "2";
        $empleadoConDirectorio = "1";
    }else{
        if($estatusEmpleadoOperaciones == "3" && ($empleadoEstatusId == "1" || $empleadoEstatusId == "2") && ($empleadoEstatusImss == "3" || $empleadoEstatusImss == "8")){
            $response["status"] = "success";
            $response["accion"] = "0"; 
        }else{ 
            $response["status"] = "success";
            $response["accion"] = "1";  
        }
    }
    if($empleadoConDirectorio=="1"){
        $sql = "SELECT * from directorio where concat_ws('-',entidadEmpleadoDirectorio,consecutivoEmpleadoDirectorio,categoriaEmpleadoDirectorio) ='$numeroEmpleado'";
        $res = mysqli_query($conexion, $sql);
        while($reg = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
            $datosDierectorio[]=$reg;
        }
        $datosdirectorio1 = count($datosDierectorio);// indica que no tiene directorio por lo cual se manda mensaje para que lo llenen antes de realizar el reingreso
        if($datosdirectorio1 == "0" || $datosdirectorio1==0){
            $response["datosDirectorio"] = "1";
        }else{
            $response["datosDirectorio"] = "0";
        }
    }else{
        $response["datosDirectorio"] = "0";
    }
    // $log->LogInfo("Valor de la variable datosdirectorio1: " . var_export ($datosdirectorio1, true));                                                                      
}catch(Exception $e) {
    $response["mensaje"]= "Error al Consultar Estatus Del Empleado";
}
echo json_encode($response);
