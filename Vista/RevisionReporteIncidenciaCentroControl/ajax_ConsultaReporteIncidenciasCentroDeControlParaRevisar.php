<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
//$log = new KLogger ( "ajax_ConsultaReporteIncidenciasCentroDeControlParaRevisar.log" , KLogger::DEBUG );
$usuario = $_SESSION ["userLog"]["usuario"];
$rol = $_SESSION ["userLog"]["rol"];
try {
        $sql = "SELECT ti.idTipoIncidenciaCC as IdTipoIncidencia, ti.descripcionTipoIncidenciaCC as DescripcionTipoIncidencia,concat_ws('-',us.SupEntidadIncidenciaCC, us.SupConsecutivoIncidenciaCC, us.SupCategoriaIncidenciaCC) as NumeroSupervisor, us.NombreSupIncidenciaCC as NombreSupervisor,concat_ws('-',ri.EmpEntidadIncidenciaCC,ri.EmpConsecutivoIncidenciaCC,ri.EmpCategoriaIncidenciaCC) as NumeroEmpleado,concat_ws(' ',e.nombreEmpleado,e.apellidoPaterno,e.apellidoMaterno ) as NombreEmpelado, ef.nombreEntidadFederativa as EntidadFederativa,ri.ExistePuntoIncidenciaCC as Existepunto,ifnull(cps.puntoServicio,0) as PuntoServicio,ri.PuntoServicioIncidenciaCC as PuntoServicioText,ri.FechaIncidenciaCC,ceri.descripcionEstatus as Estatus,us.EstatusRevisionIncidenciaCC as IdIncidecniaEstatus, ri.idinciIdenciaCC as idIncidencia,us.idSupervisorInciIdenciaCC as IdTablaSupervisor
        from usuarios u
        left join usuario_empleado ue ON(u.usuario=ue.usuario)
        left join ReporteIncidenciaSupervisoresCentroControl us ON (us.SupEntidadIncidenciaCC=ue.entidadEmpleadoUsuario and us.SupConsecutivoIncidenciaCC=ue.consecutivoEmpleadoUsuario and us.SupCategoriaIncidenciaCC=ue.categoriaEmpleadoUsuario)
        left join ReporteIncidenciaCentroControl ri ON (ri.idinciIdenciaCC=us.idIncidenciaSupCC)
        left join CatalogoTipoIncidenciaCentroC ti ON (ri.idIncidenciaCC=ti.idTipoIncidenciaCC)
        left join empleados e ON (e.entidadFederativaId=ri.EmpEntidadIncidenciaCC and e.empleadoConsecutivoId=ri.EmpConsecutivoIncidenciaCC and e.empleadoCategoriaId=ri.EmpCategoriaIncidenciaCC)
        left join entidadesfederativas ef ON (ri.IdEntidadIncidenciaCC=ef.idEntidadFederativa)
        left join catalogopuntosservicios cps ON (cps.idPuntoServicio=ri.IdPuntoIncidenciaCC)
        left join catalogoestatusreporteincidenciacc ceri ON (ceri.idEstatusReporteIncCC=us.EstatusRevisionIncidenciaCC)
        where u.usuario='$usuario'
        and us.EstatusRevisionIncidenciaCC='2'";
        //$log->LogInfo("Valor de la variable sql " . var_export ($sql, true));
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    for($i = 0; $i < count($datos); $i++){
        $idIncidencia      = $datos[$i]["idIncidencia"]; 
        $IdTablaSupervisor      = $datos[$i]["IdTablaSupervisor"]; 
        $Estatus      = $datos[$i]["Estatus"]; 
        $IdIncidecniaEstatus      = $datos[$i]["IdIncidecniaEstatus"]; 
        $Existepunto      = $datos[$i]["Existepunto"]; 
        $descripcionestatusPeticion  = "aaaaa";
        $PuntoServicio      = $datos[$i]["PuntoServicio"];
        $PuntoServicioText      = $datos[$i]["PuntoServicioText"];

        if($Existepunto == "1"){
            $datos[$i]["Punto"]= $PuntoServicio;
        }else{
            $datos[$i]["Punto"]= $PuntoServicioText;
        }         
        $datos[$i]["accion"]= "<img style='width: 45%' title='Revisar Reporte De Incidencia'src='img/pdf.jpg' class='cursorImg' id='btnRechazar' onclick=abrirPdfReporteIncidenciaCC('$idIncidencia','$IdTablaSupervisor')>";

    }
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
