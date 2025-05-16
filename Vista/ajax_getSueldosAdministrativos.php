<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_getSueldosEmpleados.log" , KLogger::DEBUG );
try {
    $lista = $negocio->getSueldosEmpleadosAdministrativos();
    //$log->LogInfo("Valor de variable de lista:" . var_export ($lista, true));
    for ($i = 0; $i < count($lista); $i++) {
        $numeroEmpleado             = $lista[$i]["numeroEmpleado"];
        $nombreEmpleado             = $lista[$i]["nombreEmpleado"];
        $fechaIngresoEmpleado       = $lista[$i]["fechaIngresoEmpleado"];
        $descripcionEstatusEmpleado = $lista[$i]["descripcionEstatusEmpleado"];
        $descripcionPuesto          = $lista[$i]["descripcionPuesto"];
        $descripcionTurno           = $lista[$i]["descripcionTurno"];
        $puntoServicio              = strtoupper($lista[$i]["puntoServicio"]);
        $nombreEntidadFederativa    = $lista[$i]["nombreEntidadFederativa"];
        $sueldoEmpleado             = $lista[$i]["sueldoEmpleado"];
        $cuotaDiaria                = $lista[$i]["cuotaDiaria"];
        $bonoAsistencia             = $lista[$i]["bonoAsistencia"];
        $bonoPuntualidad            = $lista[$i]["bonoPuntualidad"];
        $entidadFederativaId        = $lista[$i]["entidadFederativaId"];
        $empleadoConsecutivoId      = $lista[$i]["empleadoConsecutivoId"];
        $empleadoCategoriaId        = $lista[$i]["empleadoCategoriaId"];
        $lista[$i]["edicion"]       = "<img src='img/edit.png' class='cursorImg' onclick='showModalEdicionSueldoAdministrativos(\"" . $numeroEmpleado . "\",\"" . $nombreEmpleado . "\",\"" . $fechaIngresoEmpleado . "\",\"" . $descripcionPuesto . "\",\"" . $descripcionTurno . "\",\"" . $puntoServicio . "\",\"" . $nombreEntidadFederativa . "\",\"" . $sueldoEmpleado . "\",\"" . $bonoAsistencia . "\",\"" . $bonoPuntualidad . "\",\"" . $cuotaDiaria . "\");'>";
    }
    $response["data"] = $lista;
    //$log->LogInfo("Valor de variable de lista2:" . var_export ($lista, true));
} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No se pudo obtener lista de sueldos de empleados";
}

echo json_encode($response);
