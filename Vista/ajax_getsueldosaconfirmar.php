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
    $lista = $negocio->getSueldosaConfirmar();
    //$log->LogInfo("Valor de variable de lista:" . var_export ($lista, true));
    for ($i = 0; $i < count($lista); $i++) {
        $numeroEmpleado        = $lista[$i]["numeroEmpleado"];
        $nombreEmpleado        = $lista[$i]["nombreEmpleado"];
        $fechaPeticion         = $lista[$i]["fechaPeticion"];
        $descripcionPuesto     = $lista[$i]["descripcionPuesto"];
        $puntoServicio         = $lista[$i]["puntoServicio"];
        $sueldoAnterior        = $lista[$i]["sueldoAnterior"];
        $cuotaanterior         = $lista[$i]["cuotaanterior"];
        $nuevoSueldo           = $lista[$i]["nuevoSueldo"];
        $cuotanueva            = $lista[$i]["cuotanueva"];
        $IdHistoricoSueldo     = $lista[$i]["IdHistoricoSueldo"];
        $entidadFederativaId   = $lista[$i]["entidadFederativaId"];
        $empleadoConsecutivoId = $lista[$i]["empleadoConsecutivoId"];
        $empleadoCategoriaId   = $lista[$i]["empleadoCategoriaId"];
        $descripcionLineaNegocio = $lista[$i]["descripcionLineaNegocio"];
        $nombreEntidadFederativa = $lista[$i]["nombreEntidadFederativa"];
        $descripcionEstatusEmpleado = $lista[$i]["descripcionEstatusEmpleado"];
        $edicion               = $lista[$i]["edicion"]               = "&nbsp; <img src='img/cancelar.png' title='CANCELAR' class='cursorImg' onclick='confirmarocancelaraumentosueldo(\"" . $entidadFederativaId . "\",\"" . $empleadoConsecutivoId . "\",\"" . $empleadoCategoriaId . "\",\"" . $cuotanueva . "\",\"" . $nuevoSueldo . "\",\"" . $IdHistoricoSueldo . "\",0);'>
          &nbsp;&nbsp;&nbsp; <img src='img/Ok-icon1.png' title='CONFIRMAR' class='cursorImg' onclick='confirmarocancelaraumentosueldo(\"" . $entidadFederativaId . "\",\"" . $empleadoConsecutivoId . "\",\"" . $empleadoCategoriaId . "\",\"" . $cuotanueva . "\",\"" . $nuevoSueldo . "\",\"" . $IdHistoricoSueldo . "\",1);'>";
    }
    $response["data"] = $lista;
    //$log->LogInfo("Valor de variable de lista2:" . var_export ($lista, true));
} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No se pudo obtener lista de sueldos de empleados";
}
echo json_encode($response);


