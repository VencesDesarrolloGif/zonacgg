<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
$log = new KLogger ( "obtener_empleadosParaAlta.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));
function asegurarUTF8($valor) {
    if (!mb_check_encoding($valor, 'UTF-8')) {
        // Si no está en UTF-8, intentar convertir desde ISO-8859-1 (Latin1)
        $valor = mb_convert_encoding($valor, 'UTF-8', 'ISO-8859-1');
    }
    return $valor;
}
try {
    $sql = "SELECT concat_ws('-',e.entidadFederativaId,e.empleadoConsecutivoId,e.empleadoCategoriaId) as NumeroEmpleado, concat_ws(' ',e.nombreEmpleado,e.apellidoPaterno,e.apellidoMaterno) as NombreEmpleadoo,e.fotoEmpleado,ef.nombreEntidadFederativa as Entidad,cp.descripcionPuesto as puesto,e.fechaIngresoEmpleado as FechaIngreso,ct.descripcionTurno as Turno,ps.puntoServicio as Punto,p.requisicionId as plantilla
            from empleados e
            left join datosimss i on (e.entidadFederativaId=i.empladoEntidadImss and e.empleadoConsecutivoId=i.empleadoConsecutivoImss and e.empleadoCategoriaId=i.empleadoCategoriaImss)
            left join entidadesfederativas ef on (ef.idEntidadFederativa = e.idEntidadTrabajo)
            left join catalogopuestos cp on (e.empleadoIdPuesto = cp.idPuesto)
            left join catalogoturnos ct on (ct.idTipoTurno = e.empleadoIdTurno)
            left join catalogopuntosservicios ps on (ps.idPuntoServicio = e.empleadoIdPuntoServicio)
			left join plantilla p on (e.entidadFederativaId=p.empleadoEntidadPlantilla and e.empleadoConsecutivoId=p.empleadoConsecutivoPlantilla and e.empleadoCategoriaId=p.empleadoCategoriaPlantilla)
            where i.idRechazado=1
            and i.empleadoEstatusImss=1
            and e.empleadoEstatusId != 0";
   
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    for($i = 0; $i < count($datos); $i++){
        $numeroEmpleado = $datos[$i]["NumeroEmpleado"];
        $nombreEmpleado = $datos[$i]["NombreEmpleadoo"];
        $fotoEmpleado = $datos[$i]["fotoEmpleado"];
        $numeroEmpleado = asegurarUTF8($numeroEmpleado);
        $nombreEmpleado = asegurarUTF8($nombreEmpleado);
        $fotoEmpleado = asegurarUTF8($fotoEmpleado);
        $numeroE = json_encode($numeroEmpleado, JSON_UNESCAPED_UNICODE);
        $nombreE = json_encode($nombreEmpleado, JSON_UNESCAPED_UNICODE);
        $foto = json_encode($fotoEmpleado, JSON_UNESCAPED_UNICODE);
        $datos[$i]["Foto"] = "<img src='thumbs/".htmlspecialchars($fotoEmpleado, ENT_QUOTES, 'UTF-8')."' class='imss-foto'>";
        $funcion = "ConfirmarEmpleado($numeroE,$nombreE,1)";
        $funcion1 = "ConfirmarEmpleado($numeroE,$nombreE,2)";
        $datos[$i]["Acciones"] = "<img style='width 25%' title='Confirmar Empleado' src='img/ok.PNG' class='cursorImg' id='btnRechazar' onclick='".htmlspecialchars($funcion, ENT_QUOTES, 'UTF-8')."'>";
        $datos[$i]["Acciones1"] = "<img style='width 25%' title='No emitir alta definitivamente' src='img/eliminar.PNG' class='cursorImg' id='btnRechazar' onclick='".htmlspecialchars($funcion1, ENT_QUOTES, 'UTF-8')."'>";

    }
    $response["status"]= "success";
    $response["datos"] = $datos;
    $log->LogInfo("Valor de la variable response " . var_export ($response, true));
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
