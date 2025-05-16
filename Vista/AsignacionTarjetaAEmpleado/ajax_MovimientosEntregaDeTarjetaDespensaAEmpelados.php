<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
//$log = new KLogger ( "ajax_MovimientosEntregaDeTarjetaDespensaAEmpelados.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));
$Bandera = $_POST["Bandera"];
$Sucursal = $_POST["SucursalReporteTarjetaDes"];
$FechaInicio1 = $_POST["FechaInicioReporteTarjetaDes"];
$FechaFin1 = $_POST["FechaFinReporteTarjetaDes"];
$FechaInicio = $FechaInicio1." 00:00:01";   
$FechaFin = $FechaFin1." 23:59:59";
try {
    $sql = "SELECT t.idIutTarjeta,ef.nombreSucursal as Sucursal,concat_ws('-',t.EntidadEmpleadoTarjeta,t.ConsecutivoEmpleadoTarjeta,t.TipoEmpleadoTarjeta) as NumeroEmpleado,concat_ws(' ',e.nombreEmpleado,e.apellidoPaterno,e.apellidoMaterno) as NombreEmpleado,t.NumeroFirmaAsignoAElemento as NumeroAsigno,concat_ws(' ',emp.nombreEmpleado,emp.apellidoPaterno,emp.apellidoMaterno) as NombreAsigno,t.ContraseniaFirmaAsignoAlElemento,t.usuarioQueAsignoAlElemento,et.descripcionEstatus as EstatusTarjeta,t.FechaASignacionEmpleado
            FROM tarjetadespensa t
            left join catalogo_estatustarjetadespensa et ON (et.idEstatusTarjeta=t.idEstatusTarjeta)
            left join sucursalesinternas ef ON (ef.idSucursalI=t.idEntidadAsignada)
            left join empleados e ON (e.entidadFederativaId=t.EntidadEmpleadoTarjeta and e.empleadoConsecutivoId=t.ConsecutivoEmpleadoTarjeta and e.empleadoCategoriaId=t.TipoEmpleadoTarjeta)
            left join empleados emp ON (concat_ws('-',emp.entidadFederativaId,emp.empleadoConsecutivoId,emp.empleadoCategoriaId)=t.NumeroFirmaAsignoAElemento)
            where t.IdEstatusAsignacionEmpleado is not null";
    if($Bandera=="1"){
        $sql.= " and t.idEntidadAsignada='$Sucursal'";
    }else if($Bandera=="2"){
        $sql.= " and t.idEntidadAsignada='$Sucursal' and t.FechaASignacionEmpleado  between '$FechaInicio' and '$FechaFin'";
    }else if($Bandera=="3"){
        $sql.= " and t.FechaASignacionEmpleado between '$FechaInicio' and '$FechaFin'";
    }
    //$log->LogInfo("Ejecutando matricesEntidades  sql: " . $sql);
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }
    //$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
