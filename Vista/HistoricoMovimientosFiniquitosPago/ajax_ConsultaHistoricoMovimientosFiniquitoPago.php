<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
$log = new KLogger ( "ajax_ConsultaHistoricoMovimientosFiniquitoPago.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));
$fechaInicioHisMov1 = $_POST['fechaInicioHisMov'];
$fechaFinHisMov1 = $_POST['fechaFinHisMov'];
$fechaInicioHisMov = $fechaInicioHisMov1." 00:00:00";
$fechaFinHisMov= $fechaFinHisMov1." 23:59:59";
$NumEmpleadoCosHistoMov = $_POST['NumEmpleadoCosHistoMov'];
$opcion = $_POST['opcion'];
try {
    $sql = "SELECT concat_ws('-',f.entidadEmpFiniquito,f.consecutivoEmpFiniquito,f.categoriaEmpFiniquito) as NumeroEmpleado, concat_ws(' ', e.nombreEmpleado,e.apellidoPaterno,e.apellidoMaterno) as NombreEmpleado,f.fechaAlta as FechaAlta, f.fechaBaja as FechaBaja,concat_ws('-',ee.entidadFederativaId,ee.empleadoConsecutivoId,ee.empleadoCategoriaId) as NumerodminBaja, concat_ws(' ', ee.nombreEmpleado,ee.apellidoPaterno,ee.apellidoMaterno) as NombreAdminBaja,cefp.DescripcionFiniquitoPago as EstatusOrigen,cefpp.DescripcionFiniquitoPago as EstatusDestino,hmfp.fechamovimiento,hmfp.idEstatusActual AS idEstatusAnterior,hmfp.idEstatusNuevo,f.nameDocComprobante,ef.nombreEntidadFederativa,f.estatusPagoFiniquito as estatusActual,f.idFiniquito,f.fechaEditDocComprobante
             from historicomovimientosFiniquitosPago hmfp 
             left join finiquitos f on (f.idFiniquito=hmfp.idFiniquito)
             left join empleados e on (f.entidadEmpFiniquito=e.entidadFederativaId and f.consecutivoEmpFiniquito=e.empleadoConsecutivoId and f.categoriaEmpFiniquito=e.empleadoCategoriaId)
             left join empleados ee on (f.EntidadAdminBaja=ee.entidadFederativaId and f.ConsecutivoAdminBaja=ee.empleadoConsecutivoId and f.CategoriaAdminBaja=ee.empleadoCategoriaId)
             LEFT JOIN entidadesfederativas ef on (ef.idEntidadFederativa=f.idEntidadTrabajo)
             left join Catalogo_EstatusFiniquitoPago cefp on (cefp.idFiniquitoPago=hmfp.idEstatusActual) 
             left join Catalogo_EstatusFiniquitoPago cefpp on (cefpp.idFiniquitoPago=hmfp.idEstatusNuevo)";
    if($opcion =="1"){
        $sql.= " where fechamovimiento BETWEEN '$fechaInicioHisMov' AND '$fechaFinHisMov'";
    }else{
        $sql.= " where concat_ws('-',f.entidadEmpFiniquito,f.consecutivoEmpFiniquito,f.categoriaEmpFiniquito) = '$NumEmpleadoCosHistoMov'";
    }
    $sql.= " UNION SELECT concat_ws('-',f.entidadEmpFiniquito,f.consecutivoEmpFiniquito,f.categoriaEmpFiniquito) as NumeroEmpleado, concat_ws(' ', e.nombreEmpleado,e.apellidoPaterno,e.apellidoMaterno) as NombreEmpleado, f.fechaAlta as FechaAlta, f.fechaBaja as FechaBaja, concat_ws('-',ee.entidadFederativaId,ee.empleadoConsecutivoId,ee.empleadoCategoriaId) as NumerodminBaja, concat_ws(' ', ee.nombreEmpleado,ee.apellidoPaterno,ee.apellidoMaterno) as NombreAdminBaja, 'FINIQUITO LIBERADO DE LAS 6 FIRMAS' as EstatusOrigen, 'PROCESO DE FIRMA DEL FINIQUITO LU (FINIQUITO TERMINADO RECIENTEMENTE)' as EstatusDestino, 'Sin Fecha' as fechamovimiento , 'Sin Estatus Actual' as idEstatusAnterior, 'Sin Estatus Nuevo' as idEstatusNuevo, f.nameDocComprobante, ef.nombreEntidadFederativa, f.estatusPagoFiniquito as estatusActual,f.idFiniquito,f.fechaEditDocComprobante
             from finiquitos f 
             left join empleados e on (f.entidadEmpFiniquito=e.entidadFederativaId and f.consecutivoEmpFiniquito=e.empleadoConsecutivoId and f.categoriaEmpFiniquito=e.empleadoCategoriaId)
             left join empleados ee on (f.EntidadAdminBaja=ee.entidadFederativaId and f.ConsecutivoAdminBaja=ee.empleadoConsecutivoId and f.CategoriaAdminBaja=ee.empleadoCategoriaId)
             LEFT JOIN entidadesfederativas ef on (ef.idEntidadFederativa=f.idEntidadTrabajo)";
    if($opcion =="1"){
        $sql.= " where fechaBaja BETWEEN '$fechaInicioHisMov' AND '$fechaFinHisMov'";
    }else{
        $sql.= " where concat_ws('-',f.entidadEmpFiniquito,f.consecutivoEmpFiniquito,f.categoriaEmpFiniquito) = '$NumEmpleadoCosHistoMov'";
    }
    $sql.= "  AND f.estatusFiniquito ='1' AND f.estatusPagoFiniquito='1' AND f.EntidadAdminBaja IS NOT NULL";
    // $sql.= " order by ";
    $log->LogInfo("Valor de la variable sql " . var_export ($sql, true));
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
        // $log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
        for($i = 0; $i < count($datos); $i++){
            $idEstatusActual = $datos[$i]["estatusActual"];
            $idEstatusAnterior = $datos[$i]["idEstatusAnterior"];
            $EstatusOrigen1 = $datos[$i]["EstatusOrigen"];
            $EstatusDestino1 = $datos[$i]["EstatusDestino"];
            $nameDocComprobante = $datos[$i]["nameDocComprobante"];
            $idEstatusNuevo = $datos[$i]["idEstatusNuevo"];
            $idFiniquito = $datos[$i]["idFiniquito"];
            $fechaEditDocComprobante = $datos[$i]["fechaEditDocComprobante"];
            $log->LogInfo("Valor de la variable fechaEditDocComprobante " . var_export ($fechaEditDocComprobante, true));


            $NumeroEmpleado = $datos[$i]["NumeroEmpleado"];
            $NombreEmpleado = $datos[$i]["NombreEmpleado"];

            if($idEstatusAnterior=="1" || $idEstatusAnterior=="2"){
                $color1="255,0,0";
            }else if($idEstatusAnterior=="3" || $idEstatusAnterior=="4"){
                $color1="255,155,0";
            }else if($idEstatusAnterior=="5"){
                $color1="4,139,20";
            }else if($idEstatusAnterior=='Sin Estatus Actual'){
                $color1="15,195,235";
            }

            if($idEstatusNuevo=="1" || $idEstatusNuevo=="2" || $idEstatusNuevo=="Sin Estatus Nuevo"){
                $color="255,0,0";
            }else if($idEstatusNuevo=="3" || $idEstatusNuevo=="4"){
                $color="255,155,0";
            }else if($idEstatusNuevo=="5"){
                $color="4,139,20";
            }

           
            $datos[$i]["EstatusAnterior"]="<span style='color: rgb(".$color1.");'>".$EstatusOrigen1."</span>";
            $datos[$i]["EstatusActual"]="<span style='color: rgb(".$color.");'>".$EstatusDestino1."</span>";
            if($idEstatusNuevo=="5"){
                $datos[$i]["docComprovante"] = "<i  title='Abrir pdf' class='fa fa-file-pdf-o' style='font-size:40px;color:red' onclick='abrirPdfcomprobanteFinanzas(\"" . $nameDocComprobante . "\",\"" . $NumeroEmpleado . "\")'></i>";
                $datos[$i]["edicionDocComprovante"] = "<img src='../vista/img/editarHoja.png' width='45px' onclick='abrirModalFirma(" . json_encode($idFiniquito) . "," . json_encode($nameDocComprobante) . "," . json_encode($NumeroEmpleado) . "," . json_encode($NombreEmpleado) . ")'>";

                if ($fechaEditDocComprobante==null || $fechaEditDocComprobante=="null" || $fechaEditDocComprobante==NULL) {
                    $datos[$i]["fechaEditDocComprobante"]="<a style='cursor: pointer;' data-toggle='tab'>Sin Ediciones</a> ";
                }
            }else{
                $datos[$i]["docComprovante"]="<span >No Aplica</span>";
                $datos[$i]["edicionDocComprovante"] = "<a style='cursor: pointer;' data-toggle='tab'>No Aplica</a> ";
                $datos[$i]["fechaEditDocComprobante"] = "<a style='cursor: pointer;' data-toggle='tab'>No Aplica</a> ";
            }

    }
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
