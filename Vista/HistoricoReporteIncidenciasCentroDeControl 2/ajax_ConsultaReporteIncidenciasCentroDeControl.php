<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
//$log = new KLogger ( "ajax_ConsultaReporteIncidenciasCentroDeControl.log" , KLogger::DEBUG );
$usuario = $_SESSION ["userLog"]["usuario"];
$rol = $_SESSION ["userLog"]["rol"];
try {
    if($rol != "Centro De Control"){
        $sql = "SELECT ti.idTipoIncidenciaCC as IdTipoIncidencia, ti.descripcionTipoIncidenciaCC as DescripcionTipoIncidencia,concat_ws('-',us.SupEntidadIncidenciaCC, us.SupConsecutivoIncidenciaCC, us.SupCategoriaIncidenciaCC) as NumeroSupervisor, us.NombreSupIncidenciaCC as NombreSupervisor,concat_ws('-',ri.EmpEntidadIncidenciaCC,ri.EmpConsecutivoIncidenciaCC,ri.EmpCategoriaIncidenciaCC) as NumeroEmpleado,concat_ws(' ',e.nombreEmpleado,e.apellidoPaterno,e.apellidoMaterno ) as NombreEmpelado, ef.nombreEntidadFederativa as EntidadFederativa,ri.ExistePuntoIncidenciaCC as Existepunto,ifnull(cps.puntoServicio,0) as PuntoServicio,ri.PuntoServicioIncidenciaCC as PuntoServicioText,ri.FechaIncidenciaCC,ceri.descripcionEstatus as Estatus,us.EstatusRevisionIncidenciaCC as IdIncidecniaEstatus, ri.idinciIdenciaCC as idIncidencia,ri.FechaRegistroIncidenciaCC as FechaEdicion,er.idinciIdenciaCCEdit as IdIncidenciaOrigina,er.idIncrementEdit as IdEdicion,er.FechaRegIncidenciaCCEdit as FechaOriginal,ri.EmpleadoRegistroIncidenciaCC as NumAdiminFirma, ri.idEspecificacion,ifnull(descripcionEspecificacionIncidenciaCC,'SIN ESPECIFICACIÓN') as descripcionEsp
        from usuarios u
        left join usuario_empleado ue ON(u.usuario=ue.usuario)
        left join ReporteIncidenciaSupervisoresCentroControl us ON (us.SupEntidadIncidenciaCC=ue.entidadEmpleadoUsuario and us.SupConsecutivoIncidenciaCC=ue.consecutivoEmpleadoUsuario and us.SupCategoriaIncidenciaCC=ue.categoriaEmpleadoUsuario)
        left join ReporteIncidenciaCentroControl ri ON (ri.idinciIdenciaCC=us.idIncidenciaSupCC)
        left join CatalogoTipoIncidenciaCentroC ti ON (ri.idIncidenciaCC=ti.idTipoIncidenciaCC)
        left join empleados e ON (e.entidadFederativaId=ri.EmpEntidadIncidenciaCC and e.empleadoConsecutivoId=ri.EmpConsecutivoIncidenciaCC and e.empleadoCategoriaId=ri.EmpCategoriaIncidenciaCC)
        left join entidadesfederativas ef ON (ri.IdEntidadIncidenciaCC=ef.idEntidadFederativa)
        left join catalogopuntosservicios cps ON (cps.idPuntoServicio=ri.IdPuntoIncidenciaCC)
        left join catalogoestatusreporteincidenciacc ceri ON (ceri.idEstatusReporteIncCC=us.EstatusRevisionIncidenciaCC)
        left join edicionreporteincidenciacc er On (er.idinciIdenciaCCEdit=ri.idinciIdenciaCC and er.idIncrementEdit=(select min(idIncrementEdit) from edicionreporteincidenciacc where idinciIdenciaCCEdit=ri.idinciIdenciaCC))
        left join CatalogoEspecificacionIncidenciaCentroC ce on ri.idEspecificacion=ce.idEspecificacionIncidenciaCC
        where u.usuario='$usuario'
        and us.EstatusRevisionIncidenciaCC='3'";

    }else{
        $sql = " SELECT ti.idTipoIncidenciaCC as IdTipoIncidencia, ti.descripcionTipoIncidenciaCC as DescripcionTipoIncidencia,'SIN NUMERO DE SUPERVISOR' as NumeroSupervisor, 'SIN NOMBRE DE SUPERVISOR' as NombreSupervisor,concat_ws('-',ri.EmpEntidadIncidenciaCC,ri.EmpConsecutivoIncidenciaCC,ri.EmpCategoriaIncidenciaCC) as NumeroEmpleado,concat_ws(' ',e.nombreEmpleado,e.apellidoPaterno,e.apellidoMaterno ) as NombreEmpelado, ef.nombreEntidadFederativa as EntidadFederativa,ri.ExistePuntoIncidenciaCC as Existepunto,ifnull(cps.puntoServicio,0) as PuntoServicio,ri.PuntoServicioIncidenciaCC as PuntoServicioText,ri.FechaIncidenciaCC,ceri.descripcionEstatus as Estatus,ri.idEstatusReporteIncidenciaCC as IdIncidecniaEstatus, ri.idinciIdenciaCC as idIncidencia,ri.FechaRegistroIncidenciaCC as FechaEdicion,er.idinciIdenciaCCEdit as IdIncidenciaOrigina,er.idIncrementEdit as IdEdicion,er.FechaRegIncidenciaCCEdit as FechaOriginal,ri.EmpleadoRegistroIncidenciaCC as NumAdiminFirma, ri.idEspecificacion,ifnull(descripcionEspecificacionIncidenciaCC,'SIN ESPECIFICACIÓN') as descripcionEsp
                from ReporteIncidenciaCentroControl ri
                left join CatalogoTipoIncidenciaCentroC ti ON (ri.idIncidenciaCC=ti.idTipoIncidenciaCC)
                left join empleados e ON (e.entidadFederativaId=ri.EmpEntidadIncidenciaCC and e.empleadoConsecutivoId=ri.EmpConsecutivoIncidenciaCC and e.empleadoCategoriaId=ri.EmpCategoriaIncidenciaCC)
                left join entidadesfederativas ef ON (ri.IdEntidadIncidenciaCC=ef.idEntidadFederativa)
                left join catalogopuntosservicios cps ON (cps.idPuntoServicio=ri.IdPuntoIncidenciaCC)
                left join catalogoestatusreporteincidenciacc ceri ON (ceri.idEstatusReporteIncCC=ri.idEstatusReporteIncidenciaCC)
                left join edicionreporteincidenciacc er On (er.idinciIdenciaCCEdit=ri.idinciIdenciaCC and er.idIncrementEdit=(select min(idIncrementEdit) from edicionreporteincidenciacc where idinciIdenciaCCEdit=ri.idinciIdenciaCC))
                left join CatalogoEspecificacionIncidenciaCentroC ce on ri.idEspecificacion=ce.idEspecificacionIncidenciaCC
                group by ri.idinciIdenciaCC";
        }
        //$log->LogInfo("Valor de la variable sql " . var_export ($sql, true));
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    for($i = 0; $i < count($datos); $i++){
        $idIncidencia      = $datos[$i]["idIncidencia"]; 
        $Estatus      = $datos[$i]["Estatus"]; 
        $IdIncidecniaEstatus      = $datos[$i]["IdIncidecniaEstatus"]; 
        $Existepunto      = $datos[$i]["Existepunto"]; 
        $PuntoServicio      = $datos[$i]["PuntoServicio"];
        $PuntoServicioText      = $datos[$i]["PuntoServicioText"];
        $FechaEdicion      = $datos[$i]["FechaEdicion"];
        $FechaOriginal     = $datos[$i]["FechaOriginal"];
        if($FechaOriginal =="" || $FechaOriginal =="null" || $FechaOriginal =="NULL" || $FechaOriginal ==null || $FechaOriginal ==NULL){
            $datos[$i]["FechaEdicion"] = "<span>Sin Edición</span>";
            $datos[$i]["FechaOriginal"] = $FechaEdicion; 
        }
        if($Existepunto == "1"){
            $datos[$i]["Punto"]= $PuntoServicio;
        }else{
            $datos[$i]["Punto"]= $PuntoServicioText;
        } 
        if($rol == "Centro De Control"){
            if($IdIncidecniaEstatus =="1"){
                $datos[$i]["Estatus"]= "<a onclick='MostrarEstatusSupervisoresParaCC(".$idIncidencia.")' style='cursor: pointer;color: orange;' data-toggle='tab'>".$Estatus."</a> ";
            }else if($IdIncidecniaEstatus =="2"){
                $datos[$i]["Estatus"]= "<a onclick='MostrarEstatusSupervisoresParaCC(".$idIncidencia.")' style='cursor: pointer;color: red;' data-toggle='tab'>".$Estatus."</a> ";
            }else{
                $datos[$i]["Estatus"]= "<a onclick='MostrarEstatusSupervisoresParaCC(".$idIncidencia.")' style='cursor: pointer;color: green;' data-toggle='tab'>".$Estatus."</a> ";
            }
            
        }
                
        $datos[$i]["accion"]= "<img style='width: 45%' title='Mostrar Documento Revisado'src='img/pdf.jpg' class='cursorImg' id='btnRechazar' onclick=abrirPdfReporteIncidenciaCC11('$idIncidencia')>";

        $datos[$i]["Edit"]= "<img style='width: 45%' title='Editar Documento'src='img/editarHoja.png' class='cursorImg' onclick=ResetearInformacionInicial('$idIncidencia')>";


    }
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
