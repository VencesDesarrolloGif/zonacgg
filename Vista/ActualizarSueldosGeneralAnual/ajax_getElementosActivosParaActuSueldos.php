<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
//$log = new KLogger ( "ajax_getElementosActivosParaActuSueldos.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
try {
    $AnioActual = date('Y');
//$log->LogInfo("Valor de la variable AnioActual " . var_export ($AnioActual, true));
    $sql = "SELECT e.entidadFederativaId, e.empleadoConsecutivoId, e.empleadoCategoriaId,concat_ws('-',e.entidadFederativaId, e.empleadoConsecutivoId, e.empleadoCategoriaId) as  NumeroEmpleado, concat_ws(' ',e.apellidoPaterno,e.apellidoMaterno,e.nombreEmpleado) as NombreEmpelado, e.fechaIngresoEmpleado,cl.descripcionLineaNegocio,ef.nombreEntidadFederativa,cp.descripcionPuesto,d.registroPatronal,d.salarioDiario,datediff(now(), d.fechaImss) as diasTranscurridos,d.fechaImss,d.numeroLote
        from empleados e
        left join datosimss d On (e.entidadFederativaId=d.empladoEntidadImss and e.empleadoConsecutivoId=d.empleadoConsecutivoImss and e.empleadoCategoriaId = d.empleadoCategoriaImss)
        left join entidadesfederativas ef On (e.idEntidadTrabajo=ef.idEntidadFederativa)
        left join catalogopuestos cp On(e.empleadoIdPuesto=cp.idPuesto)
        left join catalogolineanegocio cl On (e.empleadoLineaNegocioId=cl.idLineaNegocio)
        where (e.empleadoEstatusId='1' or e.empleadoEstatusId='2')
        and d.empleadoEstatusImss='3'
        and (d.SueldoAnual is null or d.SueldoAnual!='$AnioActual')
        order by d.salarioDiario";
        //$log->LogInfo("Valor de la variable sql " . var_export ($sql, true));
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    $response["status"]= "success";
    $response["datos"] = $datos;
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
