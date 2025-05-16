<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
// $log = new KLogger ( "ajax_ConsultaEdicionesReporteIncidenciasCentroDeControl.log" , KLogger::DEBUG );
$usuario = $_SESSION ["userLog"]["usuario"];
$fecha1= $_POST['inicioFecha'];
$fecha2= $_POST['finFecha'];

$fechaConsulta1= $fecha1." 00:00:00" ;
$fechaConsulta2= $fecha2." 23:59:59" ;
try {
    $sql = "SELECT idinciIdenciaCCEdit,ti.descripcionTipoIncidenciaCC as DescripcionTipoIncidencia, concat_ws('-',us.SupEntidadIncidenciaCC, us.SupConsecutivoIncidenciaCC, us.SupCategoriaIncidenciaCC) AS NumeroSupervisor,us.NombreSupIncidenciaCC AS NombreSupervisor,concat_ws('-',ri.EmpEntidadIncidenciaCC,ri.EmpConsecutivoIncidenciaCC,ri.EmpCategoriaIncidenciaCC) AS NumeroEmpleado,concat_ws(' ',emp.nombreEmpleado,emp.apellidoPaterno,emp.apellidoMaterno ) AS NombreEmpelado,upper(ef.nombreEntidadFederativa) AS EntidadFederativa,ri.ExistePuntoIncidenciaCC AS Existepunto,ifnull(cps.puntoServicio,0) AS PuntoServicio,ri.PuntoServicioIncidenciaCC AS PuntoServicioText,eri.FechaDeEdición,descripcionEstatus,EmpleadoEditRegIncidenciaCC
            FROM edicionreporteincidenciacc eri
            LEFT JOIN ReporteIncidenciaCentroControl ri ON (ri.idinciIdenciaCC=eri.idinciIdenciaCCEdit)
            LEFT JOIN CatalogoTipoIncidenciaCentroC ti ON (ri.idIncidenciaCC=ti.idTipoIncidenciaCC)
            LEFT JOIN ReporteIncidenciaSupervisoresCentroControl us ON (us.idIncidenciaSupCC=eri.idinciIdenciaCCEdit)
            LEFT JOIN empleados e ON (e.entidadFederativaId=us.SupEntidadIncidenciaCC AND e.empleadoConsecutivoId=us.SupConsecutivoIncidenciaCC AND e.empleadoCategoriaId=us.SupCategoriaIncidenciaCC)
            LEFT JOIN empleados emp ON (emp.entidadFederativaId=ri.EmpEntidadIncidenciaCC AND emp.empleadoConsecutivoId=ri.EmpConsecutivoIncidenciaCC AND emp.empleadoCategoriaId=ri.EmpCategoriaIncidenciaCC)
            LEFT JOIN entidadesfederativas ef ON (ri.IdEntidadIncidenciaCC=ef.idEntidadFederativa)
            LEFT JOIN catalogopuntosservicios cps ON (cps.idPuntoServicio=ri.IdPuntoIncidenciaCC)
            LEFT JOIN catalogoestatusreporteincidenciacc cei on (cei.idEstatusReporteIncCC= eri.idEstatusReporteEdit)
            WHERE (FechaDeEdición >='$fechaConsulta1' AND FechaDeEdición<='$fechaConsulta2')
            GROUP BY eri.FechaDeEdición";

        // $log->LogInfo("Valor de la variable sql " . var_export ($sql, true));
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    for($i = 0; $i < count($datos); $i++){

        $Existepunto        = $datos[$i]["Existepunto"]; 
        $PuntoServicio      = $datos[$i]["PuntoServicio"];
        $PuntoServicioText  = $datos[$i]["PuntoServicioText"];

        if($Existepunto == "1"){
            $datos[$i]["Punto"]= $PuntoServicio;
        }else{
            $datos[$i]["Punto"]= $PuntoServicioText;
        } 
            }
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
