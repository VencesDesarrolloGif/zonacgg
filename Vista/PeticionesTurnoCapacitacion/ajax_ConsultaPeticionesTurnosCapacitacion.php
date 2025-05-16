<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
$log = new KLogger ( "ajax_ConsultaPeticionesTurnosCapacitacion.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));
try {
    $sql = "SELECT ptc.entidadEmpCap,ptc.consecutivoEmpCap,ptc.categoriaEmpCap,ptc.idPuntoServEmpCap,ptc.entidadSupCap,
        ptc.consecutivoSupCap,ptc.categoriaSupCap,ptc.fechaTurnoCap,ctp.descripcionTipoPeriodo,ptc.idPuestoEmpCap,
        cps.idClientePunto,ptc.idPlantillaEmpCap,emp.empleadoLineaNegocioId,ptc.idPeticion,ef.nombreEntidadFederativa,
        concat_ws('-',ptc.entidadEmpCap,ptc.consecutivoEmpCap,ptc.categoriaEmpCap) as numeroEmpleado,cp.descripcionPuesto,
        concat_ws(' ',emp.nombreEmpleado,emp.apellidoPaterno,emp.apellidoMaterno) as nombreEmpleado,cps.puntoServicio,                
        concat_ws('-',ptc.entidadSupCap,ptc.consecutivoSupCap,ptc.categoriaSupCap) as numeroSupervisor,
        concat_ws(' ',empSup.nombreEmpleado,empSup.apellidoPaterno,empSup.apellidoMaterno) as nombresupervisor,ptc.idPlantillaCap
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
            WHERE ptc.estatusPeticion='1'";      
    
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    for($i = 0; $i < count($datos); $i++){
        $idPeticionTurno          = $datos[$i]["idPeticion"]; 
        $empleadoEntidadId        = $datos[$i]["entidadEmpCap"]; 
        $empleadoConsecutivoId    = $datos[$i]["consecutivoEmpCap"]; 
        $empleadoTipoId           = $datos[$i]["categoriaEmpCap"]; 
        $empleadoPuntoServicioId = $datos[$i]["idPuntoServEmpCap"]; 
        $supervisorEntidadId      = $datos[$i]["entidadSupCap"]; 
        $supervisorConsecutivoId  = $datos[$i]["consecutivoSupCap"]; 
        $supervisorTipoId         = $datos[$i]["categoriaSupCap"]; 
        $incidenciaId             = "14"; // se indica el 14 ingrear asistencia de Capacitacion
        $asistenciaFecha          = $datos[$i]["fechaTurnoCap"]; 
        $comentariIncidencia1      = "Incidencia Por Capacitacion"; // Se coloca el comentario fijo para indicar que fue proveniente de capacitacion
        $tipoPeriodo              = $datos[$i]["descripcionTipoPeriodo"]; 
        $puestoCubiertoId         = $datos[$i]["idPuestoEmpCap"]; 
        $idCliente                = $datos[$i]["idClientePunto"]; 
        $valordia                 = "1"; // se coloca el 1 para indicar que la incidencia es de dia
        $plantilladeservicio1     = $datos[$i]["idPlantillaEmpCap"]; 
        $idlineanegocioPunto      = $datos[$i]["empleadoLineaNegocioId"]; 
        $idPlantillaServicio      = $datos[$i]["idPlantillaCap"]; 

        $comentariIncidencia = str_replace(" ", "$", $comentariIncidencia1);
        $plantilladeservicio = str_replace(" ", "$", $plantilladeservicio1);
        //SE MANDA EL 2 YA QUE ES EL ESTATUS DE ACEPTAR Y EL 3 DE RECHAZAR:
        $datos[$i]["accion"]="<img style='width: 24%' title='Aceptar' src='img/Ok.png' class='cursorImg' id='btnAceptarTurno' onclick=Registrarsistencia123('$empleadoEntidadId','$empleadoConsecutivoId','$empleadoTipoId','$empleadoPuntoServicioId','$supervisorEntidadId','$supervisorConsecutivoId','$supervisorTipoId','$incidenciaId','$asistenciaFecha','$comentariIncidencia','$tipoPeriodo','$puestoCubiertoId','$idCliente','$valordia','$plantilladeservicio','$idlineanegocioPunto','$idPeticionTurno','2','$idPlantillaServicio')><img style='width: 24%' title='Rechazar'src='img/rechazarImss.png' class='cursorImg' id='btnRechazar' onclick=rechazarPeticion('$idPeticionTurno','3')>"; 

    }
$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
