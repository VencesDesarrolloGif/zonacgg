<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";

$negocio = new Negocio();

verificarInicioSesion($negocio);
// $log              = new KLogger("ajaxCalculoEma.log", KLogger::DEBUG);


$response = array("status" => "success");
$registroConsulta = $_POST["registro"];
$mes      = $_POST["mes"];
$anio     = $_POST["anio"];
$mesActual= date('m');
$anioActual=date('Y');

$fecha    = $anio . "-" . $mes;
$aux      = date('Y-m-d', strtotime("{$fecha} + 1 month"));
$last_day = date('Y-m-d', strtotime("{$aux} -1  day"));

if($mes==$mesActual && $anio==$anioActual){
    $last_day=date('Y-m-d');
}

// $log->LogInfo("Valor de variable mesConsulta: " . var_export ($last_day, true));

setlocale(LC_TIME, 'spanish');  
$nombre=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000)); 
$nombreMes=strtoupper($nombre);

$dtLast       = new DateTime($last_day);
$mesConsulta  = $dtLast->format('m');
$anioConsulta = $dtLast->format('Y');
$diasDelMes   = $dtLast->format('d');

$fechaPeriodo1 = $anioConsulta . "-" . $mesConsulta . "-01";
$fechaPeriodo2 = $last_day;
$datos=array();




try {

//$registroConsulta="TODOS";
if($registroConsulta=="TODOS"){
    $listaregistrospatronales = $negocio->negocio_traeCatalogoRegistrosPatronales();
            for($j = 0; $j < count($listaregistrospatronales); $j++){
                $registroConsulta=$listaregistrospatronales[$j]["idcatalogoRegistrosPatronales"];
                    $listaEmpleados = $negocio->negocio_obtenerEmpleadosEma($registroConsulta, $fechaPeriodo1, $fechaPeriodo2);
                    $datosParaImss  = $negocio->negocio_obtenerValoresImssEma($registroConsulta,$mesConsulta,$anio);

    $aguinaldo      = 15 / 365;
    $unidad         = 1;

    //DATOS DE PORCENTAJES EN TABLA IMSS
    $valorUma     = $datosParaImss["uma"];
    $valorPrimaRT = $datosParaImss["primaRiesgo"];
    //$log->LogInfo("Valor de variable valorPrimaRT: " . var_export ($valorPrimaRT, true));
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
    for ($i = 0; $i < count($listaEmpleados); $i++) {
        $empleadoId        = $listaEmpleados[$i]["numeroEmpleado"];
        $nombreEmpleado    = $listaEmpleados[$i]["nombreCompleto"];
        $fechaAlta         = $listaEmpleados[$i]["fechaImss"];
        $fechaBaja         = $listaEmpleados[$i]["fechaBajaImss"];
        $salarioDiario     = $listaEmpleados[$i]["salarioDiario"];
        $estatusImss       = $listaEmpleados[$i]["empleadoEstatusImss"];
        $diasTranscurridos = $listaEmpleados[$i]["diasTranscurridos"];
        $estatusRH=$listaEmpleados[$i]["empleadoEstatusId"];


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

        $diasImss = 0;

        if ($estatusImss == '7') {
            if ($mesConsulta == $mesAlta && $anioConsulta==$anioBaja && $anioConsulta==$anioAlta && $mesBaja == $mesConsulta) {
                $diasImss = $dtAlta->diff($dtBaja);
                $diasImss = $diasImss->days + 1;
            } else if( $anioConsulta==$anioBaja && $mesBaja == $mesConsulta){
                $diasImss = $diaBaja;
            }else if ($mesConsulta == $mesAlta && $anioConsulta==$anioAlta){
               $diasImss = $dtAlta->diff($dtLast);
               $diasImss = $diasImss->days + 1;
            }else{
                $diasImss= $diasDelMes;
            }
        } else if ($estatusImss == '3') {
            if ($mesConsulta == $mesAlta && $anioAlta==$anioConsulta) {
                $diasImss = $dtAlta->diff($dtLast);
                $diasImss = $diasImss->days + 1;
            } else {
                $diasImss = $diasDelMes;
            }
        }
        
        $listaEmpleados[$i]["diasImss"] =(int)$diasImss;
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

        $listaEmpleados[$i]["sdi"] = $sdi;
        $incapacidades     = '0';
        $ausentismos       = '0';

        $listaEmpleados[$i]["incapacidades"] = $incapacidades;
        $listaEmpleados[$i]["ausentismos"] = $ausentismos;

        $cuotaFija = $valorUma * $diasImss * $cfPorcentaje;
        $cuotaFija = $cuotaFija / 100;
        $cuotaFija = round($cuotaFija, 2);

        $listaEmpleados[$i]["cuotaFija"] = $cuotaFija;
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

         $listaEmpleados[$i]["excPatron"] = $excPatron;
         $listaEmpleados[$i]["excObrero"] = $excObrero;

        $prestDinPatron = $porPEnDPat * $sdi * $diasImss;
        $prestDinPatron = $prestDinPatron / 100;
        $prestDinPatron = bcdiv($prestDinPatron, '1', 2);

        $listaEmpleados[$i]["prestDinPatron"] = $prestDinPatron;

        $prestDinObrero = $porPEnDObr * $sdi * $diasImss;
        $prestDinObrero = $prestDinObrero / 100;
        $prestDinObrero = bcdiv($prestDinObrero, '1', 2);

        $listaEmpleados[$i]["prestDinObrero"] = $prestDinObrero;

        $gastosMedicosPatron  = $porGMPatron * $sdi * $diasImss;
        $gastosMedicosPatron = $gastosMedicosPatron / 100;
        //$gastosMedicosPatron1=bcdiv($gastosMedicosPatron1, '1', 4);
        $gastosMedicosPatron = round($gastosMedicosPatron, 2);

        $listaEmpleados[$i]["gastosMedicosPatron"] = $gastosMedicosPatron;

        $gastosMedicosObrero  = $porGMObrero * $sdi * $diasImss;
        $gastosMedicosObrero = $gastosMedicosObrero / 100;
        //$gastosMedicosObrero1=bcdiv($gastosMedicosObrero1, '1', 4);
        $gastosMedicosObrero = round($gastosMedicosObrero, 2);

        $listaEmpleados[$i]["gastosMedicosObrero"] = $gastosMedicosObrero;

        $riesgoTrabajo  = $valorPrimaRT * $sdi * $diasImss;
        $riesgoTrabajo = $riesgoTrabajo / 100;
        //$gastosMedicosObrero1=bcdiv($gastosMedicosObrero1, '1', 4);
        $riesgoTrabajo = round($riesgoTrabajo, 2);

        $listaEmpleados[$i]["riesgoTrabajo"] = $riesgoTrabajo;

        $invYvPatron  = $invYvidaPat * $sdi * $diasImss;
        $invYvPatron = $invYvPatron / 100;
        //$gastosMedicosObrero1=bcdiv($gastosMedicosObrero1, '1', 4);
        $invYvPatron = round($invYvPatron, 2);

        $listaEmpleados[$i]["invYvPatron"] = $invYvPatron;

        $invYvObrero  = $invYvidaObr * $sdi * $diasImss;
        $invYvObrero = $invYvObrero / 100;
        //$gastosMedicosObrero1=bcdiv($gastosMedicosObrero1, '1', 4);
        $invYvObrero = round($invYvObrero, 2);

        $listaEmpleados[$i]["invYvObrero"] = $invYvObrero;

        $guarderiasYPen  = $porGuardYPen * $sdi * $diasImss;
        $guarderiasYPen = $guarderiasYPen / 100;
        //$gastosMedicosObrero1=bcdiv($gastosMedicosObrero1, '1', 4);
        $guarderiasYPen = round($guarderiasYPen, 2);

        $listaEmpleados[$i]["guarderiasYPen"] = $guarderiasYPen;

        $sumaPatronal=$excPatron+$prestDinPatron+$cuotaFija+$gastosMedicosPatron+$invYvPatron+$riesgoTrabajo+$guarderiasYPen;
        $sumaObrera=$excObrero+$prestDinObrero+$gastosMedicosObrero+$invYvObrero;

        $listaEmpleados[$i]["sumaPatron"] = $sumaPatronal;
        $listaEmpleados[$i]["sumaObrero"] = $sumaObrera;

        $subTotal=$sumaPatronal+$sumaObrera;

        $listaEmpleados[$i]["subtotal"] = $subTotal;
       

        //ENTIDAD TRABAJO, PUNTO DE SERVICIO Y CLIENTE.....
        
        // $log->LogInfo("Valor de variable registroConsulta: " . var_export ($registroConsulta, true));
        //$log->LogInfo("Valor de variable G.M.P.Pat= ".var_export ($ab, true)." G.M.P.Obr= ".var_export ($cd, true));

    }
    //$log->LogInfo("Valor de variable  : " . var_export ($listaEmpleados, true));
        $datos["lista"][$j]=$listaEmpleados;
    }
    $response["datos"]=$datos;
 
}else{
    $listaEmpleados = $negocio->negocio_obtenerEmpleadosEma($registroConsulta, $fechaPeriodo1, $fechaPeriodo2);
    $datosParaImss  = $negocio->negocio_obtenerValoresImssEma($registroConsulta,$mesConsulta,$anio);
    $aguinaldo      = 15 / 365;
    $unidad         = 1;

    //DATOS DE PORCENTAJES EN TABLA IMSS
    $valorUma     = $datosParaImss["uma"];
    $valorPrimaRT = $datosParaImss["primaRiesgo"];
    //$log->LogInfo("Valor de variable valorPrimaRT: " . var_export ($valorPrimaRT, true));
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

    for ($i = 0; $i < count($listaEmpleados); $i++) {
        $empleadoId        = $listaEmpleados[$i]["numeroEmpleado"];
        $nombreEmpleado    = $listaEmpleados[$i]["nombreCompleto"];
        $fechaAlta         = $listaEmpleados[$i]["fechaImss"];
        $fechaBaja         = $listaEmpleados[$i]["fechaBajaImss"];
        $salarioDiario     = $listaEmpleados[$i]["salarioDiario"];
        $estatusImss       = $listaEmpleados[$i]["empleadoEstatusImss"];
        $diasTranscurridos = $listaEmpleados[$i]["diasTranscurridos"];
        $estatusRH=$listaEmpleados[$i]["empleadoEstatusId"];


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

        $diasImss = 0;

        if ($estatusImss == '7') {
            if ($mesConsulta == $mesAlta && $anioConsulta==$anioBaja && $anioConsulta==$anioAlta && $mesBaja == $mesConsulta) {
                $diasImss = $dtAlta->diff($dtBaja);
                $diasImss = $diasImss->days + 1;
            } else if( $anioConsulta==$anioBaja && $mesBaja == $mesConsulta){
                $diasImss = $diaBaja;
            }else if ($mesConsulta == $mesAlta && $anioConsulta==$anioAlta){
               $diasImss = $dtAlta->diff($dtLast);
               $diasImss = $diasImss->days + 1;
            }else{
                $diasImss= $diasDelMes;
            }
        } else if ($estatusImss == '3') {
            if ($mesConsulta == $mesAlta && $anioAlta==$anioConsulta) {
                $diasImss = $dtAlta->diff($dtLast);
                $diasImss = $diasImss->days + 1;
            } else {
                $diasImss = $diasDelMes;
            }
        }
        
        $listaEmpleados[$i]["diasImss"] =(int)$diasImss;
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

        $listaEmpleados[$i]["sdi"] = $sdi;
        $incapacidades     = '0';
        $ausentismos       = '0';

        $listaEmpleados[$i]["incapacidades"] = $incapacidades;
        $listaEmpleados[$i]["ausentismos"] = $ausentismos;

        $cuotaFija = $valorUma * $diasImss * $cfPorcentaje;
        $cuotaFija = $cuotaFija / 100;
        $cuotaFija = round($cuotaFija, 2);

        $listaEmpleados[$i]["cuotaFija"] = $cuotaFija;
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

         $listaEmpleados[$i]["excPatron"] = $excPatron;
         $listaEmpleados[$i]["excObrero"] = $excObrero;

        $prestDinPatron = $porPEnDPat * $sdi * $diasImss;
        $prestDinPatron = $prestDinPatron / 100;
        $prestDinPatron = bcdiv($prestDinPatron, '1', 2);

        $listaEmpleados[$i]["prestDinPatron"] = $prestDinPatron;

        $prestDinObrero = $porPEnDObr * $sdi * $diasImss;
        $prestDinObrero = $prestDinObrero / 100;
        $prestDinObrero = bcdiv($prestDinObrero, '1', 2);

        $listaEmpleados[$i]["prestDinObrero"] = $prestDinObrero;

        $gastosMedicosPatron  = $porGMPatron * $sdi * $diasImss;
        $gastosMedicosPatron = $gastosMedicosPatron / 100;
        //$gastosMedicosPatron1=bcdiv($gastosMedicosPatron1, '1', 4);
        $gastosMedicosPatron = round($gastosMedicosPatron, 2);

        $listaEmpleados[$i]["gastosMedicosPatron"] = $gastosMedicosPatron;

        $gastosMedicosObrero  = $porGMObrero * $sdi * $diasImss;
        $gastosMedicosObrero = $gastosMedicosObrero / 100;
        //$gastosMedicosObrero1=bcdiv($gastosMedicosObrero1, '1', 4);
        $gastosMedicosObrero = round($gastosMedicosObrero, 2);

        $listaEmpleados[$i]["gastosMedicosObrero"] = $gastosMedicosObrero;

        $riesgoTrabajo  = $valorPrimaRT * $sdi * $diasImss;
        $riesgoTrabajo = $riesgoTrabajo / 100;
        //$gastosMedicosObrero1=bcdiv($gastosMedicosObrero1, '1', 4);
        $riesgoTrabajo = round($riesgoTrabajo, 2);

        $listaEmpleados[$i]["riesgoTrabajo"] = $riesgoTrabajo;

        $invYvPatron  = $invYvidaPat * $sdi * $diasImss;
        $invYvPatron = $invYvPatron / 100;
        //$gastosMedicosObrero1=bcdiv($gastosMedicosObrero1, '1', 4);
        $invYvPatron = round($invYvPatron, 2);

        $listaEmpleados[$i]["invYvPatron"] = $invYvPatron;

        $invYvObrero  = $invYvidaObr * $sdi * $diasImss;
        $invYvObrero = $invYvObrero / 100;
        //$gastosMedicosObrero1=bcdiv($gastosMedicosObrero1, '1', 4);
        $invYvObrero = round($invYvObrero, 2);

        $listaEmpleados[$i]["invYvObrero"] = $invYvObrero;

        $guarderiasYPen  = $porGuardYPen * $sdi * $diasImss;
        $guarderiasYPen = $guarderiasYPen / 100;
        //$gastosMedicosObrero1=bcdiv($gastosMedicosObrero1, '1', 4);
        $guarderiasYPen = round($guarderiasYPen, 2);

        $listaEmpleados[$i]["guarderiasYPen"] = $guarderiasYPen;

        $sumaPatronal=$excPatron+$prestDinPatron+$cuotaFija+$gastosMedicosPatron+$invYvPatron+$riesgoTrabajo+$guarderiasYPen;
        $sumaObrera=$excObrero+$prestDinObrero+$gastosMedicosObrero+$invYvObrero;

        $listaEmpleados[$i]["sumaPatron"] = $sumaPatronal;
        $listaEmpleados[$i]["sumaObrero"] = $sumaObrera;

        $subTotal=$sumaPatronal+$sumaObrera;

        $listaEmpleados[$i]["subtotal"] = $subTotal;




        //ENTIDAD TRABAJO, PUNTO DE SERVICIO Y CLIENTE.....
        
        //$log->LogInfo("Valor de variable empleado: " . var_export ($empleadoId, true));
        //$log->LogInfo("Valor de variable G.M.P.Pat= ".var_export ($ab, true)." G.M.P.Obr= ".var_export ($cd, true));

    }
    $response["datos"]=$listaEmpleados;

}
    

    //$log->LogInfo("Valor de variable de estatusEmpleado que viene de form" . var_export ($estatusEmpleado, true));

    //$log->LogInfo("Valor de la variable \$response punto: " . var_export ($response, true));

} catch (Exception $e) {
    $response["status"]  = "error";
    $response["message"] = "Error: " . $e->getMessage();
}

echo json_encode($response);
