<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
//$log = new KLogger ( "ajax_ConsultaElementosParaVetar.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));
$fechaInici   = $_POST["fechaInici"];
$fechaTermino = $_POST["fechaTermino"];
$bandera      = $_POST["bandera"];
try {
    $sql = "SELECT concat_ws('-',e.entidadFederativaId,e.empleadoConsecutivoId,e.empleadoCategoriaId) as NumeroEmpleado , concat_ws(' ',e.apellidoPaterno,e.apellidoMaterno,e.nombreEmpleado) as NombreEmpleado,e.fechaIngresoEmpleado as FechaIngreso,e.fechaBajaEmpleado as FechaBaja,ef.nombreEntidadFederativa as EntidadDeTrabajo,ps.puntoServicio as PuntosServicio,concat_ws('-',ep.entidadFederativaId,ep.empleadoConsecutivoId,ep.empleadoCategoriaId) as NumeroSupervisor, concat_ws('-',ep.apellidoPaterno,ep.apellidoMaterno,ep.nombreEmpleado) as NombreSupervisor
            FROM empleados e
            left join entidadesfederativas ef ON (ef.idEntidadFederativa=e.idEntidadTrabajo)
            left join catalogopuntosservicios ps ON (ps.idPuntoServicio=e.empleadoIdPuntoServicio)
            left join empleados ep ON (ep.entidadFederativaId=e.idEntidadResponsableAsistencia and ep.empleadoConsecutivoId=e.consecutivoResponsableAsistencia and ep.empleadoCategoriaId=e.tipoResponsableAsistencia)
            where e.empleadoEstatusId='0'
            and e.EstatusReingreso='1'";
    if($bandera =="1"){
        $sql.=" and e.fechaBajaEmpleado between '$fechaInici' and '$fechaTermino'";
    }      
    
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    for($i = 0; $i < count($datos); $i++){
        $numeroEmpleado = $datos[$i]["NumeroEmpleado"];
        $nombreEmpelado1 = $datos[$i]["NombreEmpleado"];
        $nombreEmpelado = str_replace(" ", "%", $nombreEmpelado1);
        $datos[$i]["accion"]="<img style='width: 45%' title='Betar Al Empleado'src='img/rechazarImss.png' class='cursorImg' id='btnRechazar' onclick=BetarElemento('$numeroEmpleado','$nombreEmpelado')>";
    }
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
