<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";

$negocio = new Negocio();

verificarInicioSesion($negocio);

$response = array("status" => "success");

$puntoServicio = $_POST["puntoServicio"];

$fechaConsulta2    = $_POST["fecha2"];

$fechaConsulta1    = $_POST["fecha1"];

$puestoServ    = $_POST["puesto"];

$roloperativo    = $_POST["roloperativo"];





$anioConsulta=date("Y", strtotime($fechaConsulta2));  

$mesConsulta=date("m", strtotime($fechaConsulta2));  

$fecha1Date=DATE($fechaConsulta1);
$dtF1         = new DateTime($fecha1Date);

$fecha2Date=DATE($fechaConsulta2);
$dtF2         = new DateTime($fecha2Date);
//$log              = new KLogger("ajaxCalculoEma.log", KLogger::DEBUG);

//$log->LogInfo("Valor de variable fechaPeriodo2: " . var_export ($fechaPeriodo2, true));
try {

    $listaEmpleados = $negocio->negocio_obtenerEmpleadosEmaPunto($puestoServ,$puntoServicio, $fechaConsulta1, $fechaConsulta2,$roloperativo);
    $datosParaImss  = $negocio->negocio_obtenerValoresImss($anioConsulta);


    $aguinaldo      = 15 / 365;
    $unidad         = 1;

    $prcCyvPatron    = $datosParaImss["tblImss"][6]["Patron"];
    $prcCyvPatronVal = substr($prcCyvPatron, 0, -1);
    $prcCyvPatronVal = str_replace(' ', '', $prcCyvPatronVal);

    $prcCyvObrero    = $datosParaImss["tblImss"][6]["Obrero"];
    $prcCyvObreroVal = substr($prcCyvObrero, 0, -1);
    $prcCyvObreroVal = str_replace(' ', '', $prcCyvObreroVal);

    $retiroPrct   = $datosParaImss["tblImss"][5]["Patron"];
    $retiroPrctVal = substr($retiroPrct, 0, -1);
    $retiroPrctVal = str_replace(' ', '', $retiroPrctVal);

    $viviendaPatron=$datosParaImss["tblImss"][8]["Patron"];
    $viviendaPatronVal = substr($viviendaPatron, 0, -1);
    $viviendaPatronVal = str_replace(' ', '', $viviendaPatronVal);

    $totalDiasInfo=0;
    $totalSuma1=0.0;
    $totalInfonavit=0.0;


    $valoresInfo=array();
    //$log->LogInfo("Valor de la variable total Empleados: " . var_export (count($listaEmpleados), true));


    //$log->LogInfo("Valor de la variable \$last_day punto: " . var_export ($last_day, true));

    for($i=0;$i< count($listaEmpleados);$i++){
        $empleadoId        = $listaEmpleados[$i]["numeroEmpleado"];
        $nombreEmpleado    = $listaEmpleados[$i]["nombreCompleto"];
        $fechaAlta         = $listaEmpleados[$i]["fechaImss"];
        $fechaBaja         = $listaEmpleados[$i]["fechaBajaImss"];
        $salarioDiario     = $listaEmpleados[$i]["salarioDiario"];
        $estatusImss       = $listaEmpleados[$i]["empleadoEstatusImss"];
        $diasTranscurridos = $listaEmpleados[$i]["diasTranscurridos"];
        $estatusRH=$listaEmpleados[$i]["empleadoEstatusId"];
        $nss=$listaEmpleados[$i]["nss"];        



        if($estatusRH=='2'){
           $listaEmpleados[$i]["fechaBajaImss"]=""; 
        }

        $dateAlta       = date($fechaAlta);
        $dtAlta         = new DateTime($dateAlta);
        $anioAlta       = $dtAlta->format('Y');
        $mesAlta        = $dtAlta->format('m');
        $diacomparacion = $dtAlta->format('d');

        $dateBaja = date($fechaBaja);
        $dtBaja   = new DateTime($dateBaja);
        $anioBaja = $dtBaja->format('Y');
        $mesBaja  = $dtBaja->format('m');
        $diaBaja  = $dtBaja->format('d');

        $diasInfo = 0;

        
        $dt1         = new DateTime($fechaConsulta1);
        $dt2         = new DateTime($fechaConsulta2);      
        if ($estatusImss == '7') {
            if ($dateBaja <= $fecha2Date && $dateBaja >= $fecha1Date && $dateAlta <= $fecha2Date && $dateAlta >= $fecha1Date) {
                $diasInfo = $dtAlta->diff($dtBaja);
                $diasInfo = $diasInfo->days + 1;
            } else if($dateAlta <= $fecha2Date && $dateAlta >= $fecha1Date){
                $diasInfo = $dtAlta->diff($dtF2);
                $diasInfo = $diasInfo->days + 1;
            }else if($dateBaja <= $fecha2Date && $dateBaja >= $fecha1Date){
                $diasInfo = $dtF1->diff($dtBaja);
                $diasInfo = $diasInfo->days + 1;
            }else{
                $diasInfo = $dtF1->diff($dtF2);
                $diasInfo = $diasInfo->days + 1;
            }
        } else if ($estatusImss == '3') {
            if ($dateAlta <= $fecha2Date && $dateAlta >= $fecha1Date) {
                $diasInfo = $dtAlta->diff($dtF2);
                $diasInfo = $diasInfo->days + 1;
            } else {
                $diasInfo = $dtF1->diff($dtF2);
                $diasInfo = $diasInfo->days + 1;
            }
        }

        

        $totalDiasInfo+=$diasInfo;
        if ($diasTranscurridos <= 365) {
            $primaVacacional = 3;
        
        } else if ($diasTranscurridos >= 366 and $diasTranscurridos <= 730) {
        
            $primaVacacional = 3.5;
        
        } else if ($diasTranscurridos >= 731 and $diasTranscurridos <= 1095) {
        
            $primaVacacional = 4;
        } else if ($diasTranscurridos >= 1096 and $diasTranscurridos <= 1460) {
        
            $primaVacacional = 4.5; 
        
        } else if ($diasTranscurridos >= 1461 and $diasTranscurridos <= 1825) {
        
            $primaVacacional = 5;
        
        } else if ($diasTranscurridos >= 1826 and $diasTranscurridos <= 3650) {
        
            $primaVacacional = 5.5;
        
        } else if ($diasTranscurridos >= 3651 and $diasTranscurridos <= 5475) {
        
            $primaVacacional = 6;
        
        } else if ($diasTranscurridos >= 5476 and $diasTranscurridos <= 7300) {
        
            $primaVacacional = 6.5;
        
        } else if ($diasTranscurridos >= 7301 and $diasTranscurridos <= 9125) {
        
            $primaVacacional = 7;
        
        } else if ($diasTranscurridos >= 9126 and $diasTranscurridos <= 10950) {
        
            $primaVacacional = 7.5;
        
        } else if ($diasTranscurridos >= 10951 and $diasTranscurridos <= 12775) {
        
            $primaVacacional = 8;
        
        }

        $factorIntegracion = $unidad + ($primaVacacional / 365) + $aguinaldo;
        $sdi               = $factorIntegracion * $salarioDiario;
        $sdi = bcdiv($sdi, '1', 2);


        $retiro=($sdi*$diasInfo*$retiroPrctVal)/100;
        $retiro = round($retiro, 2);        

        //CESANTIA Y VEJEZ

        $cyvPatronal=($sdi*$diasInfo*$prcCyvPatronVal)/100;
        $cyvPatronal = round($cyvPatronal, 2);        

        $cyvObrero=($sdi*$diasInfo*$prcCyvObreroVal)/100;
        $cyvObrero = round($cyvObrero, 2);        


        $suma1=$retiro+$cyvPatronal+$cyvObrero;  

        $totalSuma1+=$suma1;      

        $vivienda=($sdi*$diasInfo*$viviendaPatronVal)/100;
        $vivienda = round($vivienda, 2);        

        $suma2=$vivienda;
        $totalInfonavit+=$suma2;

        //$log->LogInfo("Valor de variable totalSuma1: " . var_export ($totalSuma1, true));

    }

    $valoresInfo["totalDias"]=$totalDiasInfo;
    $valoresInfo["totalSuma1"]=$totalSuma1;
    $valoresInfo["totalInfonavit"]=$totalInfonavit;

    $response["valoresInfo"] = $valoresInfo;

    //$log->LogInfo("Valor de variable de estatusEmpleado que viene de form" . var_export ($estatusEmpleado, true));

    //$log->LogInfo("Valor de la variable \$response punto: " . var_export ($response, true));

} catch (Exception $e) {
    $response["status"]  = "error";
    $response["message"] = "Error: " . $e->getMessage();
}

echo json_encode($response);
