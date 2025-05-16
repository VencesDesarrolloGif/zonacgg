<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response      = array("status" => "success");
//$log           = new KLogger("ajaxObtenerEmpleadosPorEstatus.log", KLogger::DEBUG);  
$fechaPeriodo1 = getValueFromPost("fechaAltaPeriodo1");
$fechaPeriodo2 = getValueFromPost("fechaAltaPeriodo2");
try {
    $listaEmpleadosCuadro = $negocio->negocio_obtenerDatosCuadroAntig($fechaPeriodo1, $fechaPeriodo2);
    //$log->LogInfo("Valor de la variable \$response punto: " . var_export ($listaEmpleadosCuadro, true));
    $aguinaldo = 15 / 365;
    $unidad    = 1;
    $a=1;
    for ($i = 0; $i < count($listaEmpleadosCuadro); $i++) {        
        $empleadoId        = $listaEmpleadosCuadro[$i]["numeroEmpleadoC"];
        $nombreEmpleado    = $listaEmpleadosCuadro[$i]["nombreCompletoC"];
        $fechaIngreso      = $listaEmpleadosCuadro[$i]["fechaAlta"];
        $fechabajaimss     = $listaEmpleadosCuadro[$i]["fechaBaja"];
        $numeroImss        = $listaEmpleadosCuadro[$i]["empleadoNumeroSeguroSocial"];
        $salarioDiario     = $listaEmpleadosCuadro[$i]["sdiMovimiento"];
        $registroPatronal  = $listaEmpleadosCuadro[$i]["registroMovimiento"];
        $estatusEmpleado   = $listaEmpleadosCuadro[$i]["descMovimientoImss"]; //descripcionEstatusEmpleado//verificar por si es el estatus y aparte la descripcion del movimiento
        $diasTranscurridos = $listaEmpleadosCuadro[$i]["diasTranscurridos"];
        $estatusimss       = $listaEmpleadosCuadro[$i]["empleadoEstatusImss"];
        $razonSocial       = $listaEmpleadosCuadro[$i]["razonSocial"];
        $loteImss          = $listaEmpleadosCuadro[$i]["loteImss"];


        $siguiente=$listaEmpleadosCuadro[0];
        $y=$i+1;
        $x=count($listaEmpleadosCuadro);
        // $log->LogInfo("Valor de la variable i punto: " . var_export ($i, true));
         //$log->LogInfo("Valor de la variable a punto: " . var_export ($a, true));

        if($y<$x){
            $siguiente=$listaEmpleadosCuadro[$y];
        }else{
            $a=0;
        }

        
  
        if ($estatusimss != 7 && ($empleadoId!=$siguiente["numeroEmpleadoC"] || $a==0)) {           
                $listaEmpleadosCuadro[$i]["accion_editar"] = "<a href='javascript:editarDatosImss(\"" . $empleadoId . "\",\"" . $nombreEmpleado . "\",\"" . $fechaIngreso . "\",\"" . $salarioDiario . "\",\"" . $registroPatronal . "\",\"" . $fechabajaimss . "\",\"" . $diasTranscurridos . "\"    );'>
            <img src='img/editarEmpleado.png' /></a>";            

        } else { $listaEmpleadosCuadro[$i]["accion_editar"] = "";}
        $diasTranscurridos = $listaEmpleadosCuadro[$i]["diasTranscurridos"];

        if ($diasTranscurridos <= 365) {
            $primaVacacional = 3;
        
        } elseif ($diasTranscurridos >= 366 and $diasTranscurridos <= 730) {
        
            $primaVacacional = 3.5;
        
        } elseif ($diasTranscurridos >= 731 and $diasTranscurridos <= 1095) {
        
            $primaVacacional = 4;
        } elseif ($diasTranscurridos >= 1096 and $diasTranscurridos <= 1460) {
        
            $primaVacacional = 4.5;
        
        } elseif ($diasTranscurridos >= 1461 and $diasTranscurridos <= 1825) {
        
            $primaVacacional = 5;
        
        } elseif ($diasTranscurridos >= 1826 and $diasTranscurridos <= 3650) { 
        
            $primaVacacional = 5.5;
        
        } elseif ($diasTranscurridos >= 3651 and $diasTranscurridos <= 5475) {
        
            $primaVacacional = 6;
        
        } elseif ($diasTranscurridos >= 5476 and $diasTranscurridos <= 7300) {
        
            $primaVacacional = 6.5;
        
        } elseif ($diasTranscurridos >= 7301 and $diasTranscurridos <= 9125) {
        
            $primaVacacional = 7;
        
        } elseif ($diasTranscurridos >= 9126 and $diasTranscurridos <= 10950) {
        
            $primaVacacional = 7.5;
        
        } elseif ($diasTranscurridos >= 10951 and $diasTranscurridos <= 12775) {
        
            $primaVacacional = 8;
        
        }
        $listaEmpleadosCuadro[$i]["prima_vacacional"] = $primaVacacional;
        $factor_integracion                           = $listaEmpleadosCuadro[$i]["FIntegracionMovimiento"];
        $sbc                                          = $listaEmpleadosCuadro[$i]["SBCMovimiento"];  
        $sbc1 = round($sbc, 2);
        $sbc2 = number_format($sbc1, 2, '.', '');
        $listaEmpleadosCuadro[$i]["SBCMovimiento"] = $sbc2;     
    }
    $response["data"] = $listaEmpleadosCuadro;
    //$log->LogInfo("Valor de variable de estatusEmpleado que viene de form" . var_export ($estatusEmpleado, true));
    // $log->LogInfo("Valor de la variable \$response punto: " . var_export($response, true));
} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No se pudo obtener Empleados";
}
echo json_encode($response);
