<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
//$log = new KLogger ( "ajax_ConsultaPeticionesTurnosCapacitacion.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));
try {
    $sql = "SELECT concat_ws('-',ptc.entidadEmpCap,ptc.consecutivoEmpCap,ptc.categoriaEmpCap) as numeroEmpleado,
                   concat_ws(' ',emp.nombreEmpleado,emp.apellidoPaterno,emp.apellidoMaterno) as nombreEmpleado,
                   ef.nombreEntidadFederativa,cps.puntoServicio,cp.descripcionPuesto,
                   concat_ws('-',ptc.entidadSupCap,ptc.consecutivoSupCap,ptc.categoriaSupCap) as numeroSupervisor,
                    concat_ws(' ',empSup.nombreEmpleado,empSup.apellidoPaterno,empSup.apellidoMaterno) as nombresupervisor,
                    ptc.fechaTurnoCap,ptc.comentarioAccion,ptc.fechaAccion,ptc.usuarioCapturaPeticion,ptc.estatusPeticion,cec.descripcion
            FROM peticionesturnoscapacitacion ptc
            LEFT JOIN empleados emp on (emp.entidadFederativaId = ptc.entidadEmpCap 
                                        and emp.empleadoConsecutivoId = ptc.consecutivoEmpCap 
                                        and emp.empleadoCategoriaId = ptc.categoriaEmpCap)
            LEFT JOIN entidadesfederativas ef on (ef.idEntidadFederativa = ptc.entidadSupCap)
            LEFT JOIN catalogopuntosservicios cps on (cps.idPuntoServicio = ptc.idPuntoServEmpCap)
            LEFT JOIN catalogopuestos cp on (cp.idPuesto = ptc.idPuestoEmpCap)
            LEFT JOIN empleados empSup on (empSup.entidadFederativaId = ptc.entidadSupCap 
                                           and empSup.empleadoConsecutivoId = ptc.consecutivoSupCap 
                                           and empSup.empleadoCategoriaId = ptc.categoriaSupCap)
            left join catalogotipoperiodo ctp on (ctp.tipoPeriodoId=emp.tipoPeriodo)
            left join catalogo_estatusturnocapacitacion cec on (cec.idestatusTurnoCap=ptc.estatusPeticion)";      
    
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    for($i = 0; $i < count($datos); $i++){
        $estatusPeticion      = $datos[$i]["estatusPeticion"]; 
        $descripcionestatusPeticion      = $datos[$i]["descripcion"]; 
        if($estatusPeticion == "2" or $estatusPeticion == "5"){
            $datos[$i]["accion"]= "<label style='color:green'>".$descripcionestatusPeticion."</label>";
        }else if($estatusPeticion == "3" or $estatusPeticion == "4"){
            $datos[$i]["accion"]= "<label style='color:red'>".$descripcionestatusPeticion."</label>";
        }else{
            $datos[$i]["accion"]= "<label style='color:orange'>".$descripcionestatusPeticion."</label>";
        } 

    }
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
