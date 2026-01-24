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
function asegurarUTF8($valor) {
    if (!mb_check_encoding($valor, 'UTF-8')) {
        // Si no está en UTF-8, intentar convertir desde ISO-8859-1 (Latin1)
        $valor = mb_convert_encoding($valor, 'UTF-8', 'ISO-8859-1');
    }
    return $valor;
}
try {
    $sql = "SELECT concat_ws('-',e.entidadFederativaId,e.empleadoConsecutivoId,e.empleadoCategoriaId) as NumeroEmpleado, concat_ws(' ',e.nombreEmpleado,e.apellidoPaterno,e.apellidoMaterno) as NombreEmpleadoo,e.nombreEmpleado,e.apellidoPaterno,e.apellidoMaterno,e.empleadoNumeroSeguroSocial,e.fotoEmpleado,e.fechaIngresoEmpleado
            from empleados e
            left join datosimss i on (e.entidadFederativaId=i.empladoEntidadImss and e.empleadoConsecutivoId=i.empleadoConsecutivoImss and e.empleadoCategoriaId=i.empleadoCategoriaImss)
            where i.idRechazado=3
            and i.empleadoEstatusImss=1
            and e.empleadoEstatusId != 0";
   
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    for($i = 0; $i < count($datos); $i++){
        $fecha = $datos[$i]["fechaIngresoEmpleado"];
        $numeroEmpleado = $datos[$i]["NumeroEmpleado"];
        $nombreEmpleado = $datos[$i]["nombreEmpleado"];
        $apellidoPaterno = $datos[$i]["apellidoPaterno"];
        $apellidoMaterno = $datos[$i]["apellidoMaterno"];
        $empleadoNumeroSeguroSocial = $datos[$i]["empleadoNumeroSeguroSocial"];
        $fotoEmpleado = $datos[$i]["fotoEmpleado"];

        $fecha = asegurarUTF8($fecha);
        $numeroEmpleado = asegurarUTF8($numeroEmpleado);
        $nombreEmpleado = asegurarUTF8($nombreEmpleado);
        $apellidoPaterno = asegurarUTF8($apellidoPaterno);
	    $apellidoMaterno = asegurarUTF8($apellidoMaterno);
        $empleadoNumeroSeguroSocial = asegurarUTF8($empleadoNumeroSeguroSocial);
        $fotoEmpleado = asegurarUTF8($fotoEmpleado);
        
        // Ahora sí hacer json_encode
        $fechaE = json_encode($fecha, JSON_UNESCAPED_UNICODE);
        $numeroE = json_encode($numeroEmpleado, JSON_UNESCAPED_UNICODE);
        $nombreE = json_encode($nombreEmpleado, JSON_UNESCAPED_UNICODE);
        $apellidoP = json_encode($apellidoPaterno, JSON_UNESCAPED_UNICODE);
        $apellidoM = json_encode($apellidoMaterno, JSON_UNESCAPED_UNICODE);
        $ss = json_encode($empleadoNumeroSeguroSocial, JSON_UNESCAPED_UNICODE);
        $foto = json_encode($fotoEmpleado, JSON_UNESCAPED_UNICODE);
        $datos[$i]["Foto"] = "<img src='thumbs/".htmlspecialchars($fotoEmpleado, ENT_QUOTES, 'UTF-8')."' class='imss-foto'>";
        $funcion = "CorregirEmpleado($numeroE,$nombreE, $apellidoP, $apellidoM, $ss, $foto ,$fechaE)";
        $datos[$i]["Acciones"] = "<img style='width 25%' title='Editar Empleado' src='img/icon-solicitud.PNG' class='cursorImg' id='btnRechazar' onclick='".htmlspecialchars($funcion, ENT_QUOTES, 'UTF-8')."'>";

    }
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
