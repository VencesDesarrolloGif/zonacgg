<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
// $log = new KLogger ( "ajax_getPeriodosanuales.log" , KLogger::DEBUG );
$empleadoEntidadId=$_POST["empleadoEntidadId"];
$empleadoConsecutivoId=$_POST["empleadoConsecutivoId"];
$empleadoTipoId=$_POST["empleadoTipoId"];
try {
   /* $obtenerFechaIngreso = $negocio->obtenerFechaAltaEmpleado($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId);
    $FechaAltaEmpleado = $obtenerFechaIngreso[0]["FechaAltaEmpleado"];
    $FechaExplode = explode("-", $FechaAltaEmpleado);
    $AnioAlta = $FechaExplode[0];

    $FechaActual = date("Y-m-d");
    $ExplodeFechaAtual = explode("-", $FechaActual);
    $anio2 = $ExplodeFechaAtual[0]; */

    $obtenerFechaIngreso = $negocio->obtenerFechaAltaEmpleadoTablaEmpleados($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId);
    $FechaAltaEmpleado = $obtenerFechaIngreso[0]["FechaAltaEmpleado"];
    $FechaExplode = explode("-", $FechaAltaEmpleado);
    $AnioAlta = $FechaExplode[0];

    $FechaAltaEmpleadoImss = $obtenerFechaIngreso[0]["FechaAltaEmpleadoImss"];
    $FechaimssExplode = explode("-", $FechaAltaEmpleadoImss);
    $AnioAltaImss = $FechaimssExplode[0];

    $FechaActual = date("Y-m-d");
    $ExplodeFechaAtual = explode("-", $FechaActual);
    $anio2 = $ExplodeFechaAtual[0];

    if($AnioAlta<$AnioAltaImss){
        $AnioAltaE = $AnioAlta;
    }else if($AnioAlta==$AnioAltaImss){
        if($FechaAltaEmpleado<$FechaAltaEmpleadoImss){
            $AnioAltaE = $AnioAlta;
        }else{
            $AnioAltaE = $AnioAltaImss;
        }
    }else{
        $AnioAltaE = $AnioAltaImss; 
    }

    $diferenciaDeAnios= ($anio2-$AnioAlta)+1;

    for($i=0; $i<$diferenciaDeAnios;$i++){
        $sum = $i;
        $datos[$i]["IdAnio"] = $sum;
        $datos[$i]["Aniversario"] = "Aniversario N°" . $sum ;
    }
// $log->LogInfo("Valor de datos" . var_export ($datos, true));


    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No Se Obtuvieron Puestos";
}
echo json_encode($response);
