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

$roloperativo=$_POST["roloperativo"];


$anioConsulta=date("Y", strtotime($fechaConsulta2));  

$mesConsulta=date("m", strtotime($fechaConsulta2));  

$fecha1Date=DATE($fechaConsulta1);
$dtF1         = new DateTime($fecha1Date);

$fecha2Date=DATE($fechaConsulta2);
$dtF2         = new DateTime($fecha2Date);
//$log              = new KLogger("ajaxCalculoEma.log", KLogger::DEBUG);


try {

    $listaEmpleados = $negocio->negocio_obtenerEmpleadosEmaPunto($puestoServ,$puntoServicio, $fechaConsulta1, $fechaConsulta2,$roloperativo);
    $datosParaImss  = $negocio->negocio_obtenerValoresImssEmaPunto($anioConsulta);
    $aguinaldo      = 15 / 365;
    $unidad         = 1;

    //DATOS DE PORCENTAJES EN TABLA IMSS
    $valorUma     = $datosParaImss["uma"];    
    $cfStr        = $datosParaImss["tblImss"][0]["Patron"];
    $cfPorcentaje = substr($cfStr, 0, -1);
    $cfPorcentaje = str_replace(' ', '', $cfPorcentaje);
    $excPatStr    = $datosParaImss["tblImss"][1]["Patron"];
    $porcExcPat   = substr($excPatStr, 0, -1);
    $porcExcPat   = str_replace(' ', '', $porcExcPat);
    $excObrStr    = $datosParaImss["tblImss"][1]["Obrero"];
    $porcExcObr   = substr($excObrStr, 0, -1);
    $porcExcObr   = str_replace(' ', '', $porcExcObr);

    $presEnDPatStr = $datosParaImss["tblImss"][2]["Patron"];
    $porPEnDPat    = substr($presEnDPatStr, 0, -1);
    $porPEnDPat    = str_replace(' ', '', $porPEnDPat);

    $presEnDObrStr = $datosParaImss["tblImss"][2]["Obrero"];
    $porPEnDObr    = substr($presEnDObrStr, 0, -1);
    $porPEnDObr    = str_replace(' ', '', $porPEnDObr);

    $gastosMPPatStr = $datosParaImss["tblImss"][3]["Patron"];
    $porGMPatron    = substr($gastosMPPatStr, 0, -1);
    $porGMPatron    = str_replace(' ', '', $porGMPatron);    

    $gastosMPObrStr = $datosParaImss["tblImss"][3]["Obrero"];
    $porGMObrero    = substr($gastosMPObrStr, 0, -1);
    $porGMObrero    = str_replace(' ', '', $porGMObrero);    

    $invYvidaPatSTR=$datosParaImss["tblImss"][4]["Patron"];
    $invYvidaPat    = substr($invYvidaPatSTR, 0, -1);
    $invYvidaPat    = str_replace(' ', '', $invYvidaPat);  

    $invYvidaObrSTR=$datosParaImss["tblImss"][4]["Obrero"];
    $invYvidaObr    = substr($invYvidaObrSTR, 0, -1);
    $invYvidaObr    = str_replace(' ', '', $invYvidaObr); 

    $guardYPenStr=$datosParaImss["tblImss"][7]["Patron"];
    $porGuardYPen    = substr($guardYPenStr, 0, -1);
    $porGuardYPen    = str_replace(' ', '', $porGuardYPen); 
    $totalDiasImss=0;
    $totalPagoSua=0.0;

    $valoresSua=array();
    for ($i = 0; $i < count($listaEmpleados); $i++) {
//$log->LogInfo("Valor de variable $listaEmpleados: " . var_export ($listaEmpleados[$i], true));
       
        $empleadoId        = $listaEmpleados[$i]["numeroEmpleado"];
        $nombreEmpleado    = $listaEmpleados[$i]["nombreCompleto"];
        $fechaAlta         = $listaEmpleados[$i]["fechaImss"];
        $fechaBaja         = $listaEmpleados[$i]["fechaBajaImss"];
        $salarioDiario     = $listaEmpleados[$i]["salarioDiario"];
        $estatusImss       = $listaEmpleados[$i]["empleadoEstatusImss"];
        $diasTranscurridos = $listaEmpleados[$i]["diasTranscurridos"];
        $registro = $listaEmpleados[$i]["registroPatronal"];

        //EL VALOR DE PRIMA CAMBIA POR REGISTRO PATRONAL
     
        $valorPrimaRT= $negocio->negocio_obtenerPrimaRTEmpleado($registro,$mesConsulta,$anioConsulta);

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

        $diasImss = 0;

        if ($estatusImss == '7') {
            if ($dateBaja <= $fecha2Date && $dateBaja >= $fecha1Date && $dateAlta <= $fecha2Date && $dateAlta >= $fecha1Date) {
                $diasImss = $dtAlta->diff($dtBaja);
                $diasImss = $diasImss->days + 1;
            } else if($dateAlta <= $fecha2Date && $dateAlta >= $fecha1Date){
                $diasImss = $dtAlta->diff($dtF2);
                $diasImss = $diasImss->days + 1;
            }else if($dateBaja <= $fecha2Date && $dateBaja >= $fecha1Date){
                $diasImss = $dtF1->diff($dtBaja);
                $diasImss = $diasImss->days + 1;
            }else{
                $diasImss = $dtF1->diff($dtF2);
                $diasImss = $diasImss->days + 1;
            }
        } else if ($estatusImss == '3') {
            if ($dateAlta <= $fecha2Date && $dateAlta >= $fecha1Date) {
                $diasImss = $dtAlta->diff($dtF2);
                $diasImss = $diasImss->days + 1;
            } else {
                $diasImss = $dtF1->diff($dtF2);
                $diasImss = $diasImss->days + 1;
            }
        }

        $totalDiasImss+=$diasImss;
        
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
        

        $cuotaFija = $valorUma * $diasImss * $cfPorcentaje;
        $cuotaFija = $cuotaFija / 100;
        $cuotaFija = round($cuotaFija, 2);
        
        $excPatron = 0.00;
        $excObrero = 0.00;
        $banExc=0;
        if ($sdi > (3 * $valorUma)) {
            $banExc=1;
            $restaSdi  = $sdi - (3 * $valorUma);
            $excPatron = $restaSdi * $diasImss * $porcExcPat;
            $excPatron = bcdiv($excPatron, '1', 2);
            $excPatron = $excPatron / 100;
            $excObrero = $restaSdi * $diasImss * $porcExcObr;
            $excObrero = bcdiv($excObrero, '1', 2);
            $excObrero = $excObrero / 100;
        }
        if($banExc==0){
            $excPatron = '0.00';
            $excObrero = '0.00';
        }
      

        $prestDinPatron = $porPEnDPat * $sdi * $diasImss;
        $prestDinPatron = $prestDinPatron / 100;
        $prestDinPatron = bcdiv($prestDinPatron, '1', 2);
        

        $prestDinObrero = $porPEnDObr * $sdi * $diasImss;
        $prestDinObrero = $prestDinObrero / 100;
        $prestDinObrero = bcdiv($prestDinObrero, '1', 2);



        $gastosMedicosPatron  = $porGMPatron * $sdi * $diasImss;
        $gastosMedicosPatron = $gastosMedicosPatron / 100;
        //$gastosMedicosPatron1=bcdiv($gastosMedicosPatron1, '1', 4);
        $gastosMedicosPatron = round($gastosMedicosPatron, 2);

        $gastosMedicosObrero  = $porGMObrero * $sdi * $diasImss;
        $gastosMedicosObrero = $gastosMedicosObrero / 100;
        //$gastosMedicosObrero1=bcdiv($gastosMedicosObrero1, '1', 4);
        $gastosMedicosObrero = round($gastosMedicosObrero, 2);

        $riesgoTrabajo  = $valorPrimaRT * $sdi * $diasImss;
        $riesgoTrabajo = $riesgoTrabajo / 100;
        //$gastosMedicosObrero1=bcdiv($gastosMedicosObrero1, '1', 4);
        $riesgoTrabajo = round($riesgoTrabajo, 2);        

        $invYvPatron  = $invYvidaPat * $sdi * $diasImss;
        $invYvPatron = $invYvPatron / 100;
        //$gastosMedicosObrero1=bcdiv($gastosMedicosObrero1, '1', 4);
        $invYvPatron = round($invYvPatron, 2);
        

        $invYvObrero  = $invYvidaObr * $sdi * $diasImss;
        $invYvObrero = $invYvObrero / 100;
        //$gastosMedicosObrero1=bcdiv($gastosMedicosObrero1, '1', 4);
        $invYvObrero = round($invYvObrero, 2);
    

        $guarderiasYPen  = $porGuardYPen * $sdi * $diasImss;
        $guarderiasYPen = $guarderiasYPen / 100;
        //$gastosMedicosObrero1=bcdiv($gastosMedicosObrero1, '1', 4);
        $guarderiasYPen = round($guarderiasYPen, 2);    

        $sumaPatronal=$excPatron+$prestDinPatron+$cuotaFija+$gastosMedicosPatron+$invYvPatron+$riesgoTrabajo+$guarderiasYPen;
        $sumaObrera=$excObrero+$prestDinObrero+$gastosMedicosObrero+$invYvObrero;

        $listaEmpleados[$i]["sumaPatron"] = $sumaPatronal;
        $listaEmpleados[$i]["sumaObrero"] = $sumaObrera;

        $subTotal=$sumaPatronal+$sumaObrera;

        $totalPagoSua+=$subTotal;




        //ENTIDAD TRABAJO, PUNTO DE SERVICIO Y CLIENTE.....
        
        //$log->LogInfo("Valor de variable empleado: " . var_export ($empleadoId, true));
        //$log->LogInfo("Valor de variable G.M.P.Pat= ".var_export ($ab, true)." G.M.P.Obr= ".var_export ($cd, true));

    }

    $valoresSua["totalDias"]=$totalDiasImss;
    $valoresSua["totalPago"]=$totalPagoSua;







    $response["valoresEma"] = $valoresSua;

    //$log->LogInfo("Valor de variable de estatusEmpleado que viene de form" . var_export ($estatusEmpleado, true));

    //$log->LogInfo("Valor de la variable \$response punto: " . var_export ($response, true));

} catch (Exception $e) {
    $response["status"]  = "error";
    $response["message"] = "Error: " . $e->getMessage();
}

echo json_encode($response);
