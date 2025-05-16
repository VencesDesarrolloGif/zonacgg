<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
// $log              = new KLogger("ajaxCalculoProvisionEma.log", KLogger::DEBUG);
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
//$log->LogInfo("Valor de variable mesConsulta: " . var_export ($last_day, true));
setlocale(LC_TIME, 'spanish');  
$nombre=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000)); 
$nombreMes=strtoupper($nombre);
$dtLast       = new DateTime($last_day);
$mesConsulta  = $dtLast->format('m');
$anioConsulta = $dtLast->format('Y');
$diasDelMes   = $dtLast->format('d');
$fechaPeriodo1= $anioConsulta . "-" . $mesConsulta . "-01";
$fechaPeriodo2= $last_day;
$datos=array();

$diasImssTotal=0;
$sdiTotal=0;
$incapacidadesTotal=0;
$ausentismosTotal  =0;
$cuotaFijaTotal=0;
$excPatronTotal=0;
$excObreroTotal=0;
$prestDinPatronTotal=0;
$prestDinObreroTotal=0;
$gastosMedicosPatronTotal=0;
$gastosMedicosObreroTotal=0;
$riesgoTrabajoTotal=0;
$invYvPatronTotal=0;
$invYvObreroTotal=0;
$guarderiasYPenTotal=0;
$sumaPatronalTotal=0;
$sumaObreraTotal=0;
$subTotalTotal=0;
try{
    if($registroConsulta=="TODOS"){
       $listaregistrospatronales = $negocio->negocio_traeCatalogoRegistrosPatronales();
        for($j = 0; $j < count($listaregistrospatronales); $j++){
            $registroConsulta=$listaregistrospatronales[$j]["idcatalogoRegistrosPatronales"];
            $listaEmpleados = $negocio->negocio_obtenerEmpleadosEma($registroConsulta, $fechaPeriodo1, $fechaPeriodo2);
            $datosParaImss  = $negocio->negocio_obtenerValoresImssEma($registroConsulta,$mesConsulta,$anio);

            $aguinaldo      = 15 / 365;
            $unidad         = 1;

            //DATOS DE PORCENTAJES EN TABLA IMSS
            //$log->LogInfo("Valor de variable valorPrimaRT: " . var_export ($valorPrimaRT, true));
            $valorUma     = $datosParaImss["uma"];
            $valorPrimaRT = $datosParaImss["primaRiesgo"];
            $cfStr        = $datosParaImss["tblImss"][0]["Patron"];
            $cfPorcentaje = substr($cfStr, 0, -1);
            $cfPorcentaje = str_replace(' ', '', $cfPorcentaje);
            $excPatStr    = $datosParaImss["tblImss"][1]["Patron"];
            $porcExcPat   = substr($excPatStr, 0, -1);
            $porcExcPat   = str_replace(' ', '', $porcExcPat);
            $excObrStr    = $datosParaImss["tblImss"][1]["Obrero"];
            $porcExcObr   = substr($excObrStr, 0, -1);
            $porcExcObr   = str_replace(' ', '', $porcExcObr);

            $presEnDPatStr= $datosParaImss["tblImss"][2]["Patron"];
            $porPEnDPat   = substr($presEnDPatStr, 0, -1);
            $porPEnDPat   = str_replace(' ', '', $porPEnDPat);

            $presEnDObrStr= $datosParaImss["tblImss"][2]["Obrero"];
            $porPEnDObr   = substr($presEnDObrStr, 0, -1);
            $porPEnDObr   = str_replace(' ', '', $porPEnDObr);

            $gastosMPPatStr= $datosParaImss["tblImss"][3]["Patron"];
            $porGMPatron   = substr($gastosMPPatStr, 0, -1);
            $porGMPatron   = str_replace(' ', '', $porGMPatron);    

            $gastosMPObrStr= $datosParaImss["tblImss"][3]["Obrero"];
            $porGMObrero   = substr($gastosMPObrStr, 0, -1);
            $porGMObrero   = str_replace(' ', '', $porGMObrero);    

            $invYvidaPatSTR=$datosParaImss["tblImss"][4]["Patron"];
            $invYvidaPat   = substr($invYvidaPatSTR, 0, -1);
            $invYvidaPat   = str_replace(' ', '', $invYvidaPat);  

            $invYvidaObrSTR=$datosParaImss["tblImss"][4]["Obrero"];
            $invYvidaObr   = substr($invYvidaObrSTR, 0, -1);
            $invYvidaObr   = str_replace(' ', '', $invYvidaObr); 

            $guardYPenStr = $datosParaImss["tblImss"][7]["Patron"];
            $porGuardYPen = substr($guardYPenStr, 0, -1);
            $porGuardYPen = str_replace(' ', '', $porGuardYPen); 
            
            for ($i = 0; $i < count($listaEmpleados); $i++) {
                $fechaAlta         = $listaEmpleados[$i]["fechaImss"];
                $fechaBaja         = $listaEmpleados[$i]["fechaBajaImss"];
                $salarioDiario     = $listaEmpleados[$i]["salarioDiario"];
                $estatusImss       = $listaEmpleados[$i]["empleadoEstatusImss"];
                $diasTranscurridos = $listaEmpleados[$i]["diasTranscurridos"];
                $estatusRH         = $listaEmpleados[$i]["empleadoEstatusId"];

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

                if ($estatusImss == '7'){
                    if ($mesConsulta == $mesAlta && $anioConsulta==$anioBaja && $anioConsulta==$anioAlta && $mesBaja == $mesConsulta){
                        $diasImss = $dtAlta->diff($dtBaja);
                        $diasImss = $diasImss->days + 1;
                    }else if($anioConsulta==$anioBaja && $mesBaja == $mesConsulta){
                             $diasImss = $diaBaja;
                    }else if($mesConsulta == $mesAlta && $anioConsulta==$anioAlta){
                             $diasImss = $dtAlta->diff($dtLast);
                             $diasImss = $diasImss->days + 1;
                    }else{
                        $diasImss= $diasDelMes;
                    }
                }else if($estatusImss == '3') {
                    if ($mesConsulta == $mesAlta && $anioAlta==$anioConsulta) {
                        $diasImss = $dtAlta->diff($dtLast);
                        $diasImss = $diasImss->days + 1;
                    } else {
                        $diasImss = $diasDelMes;
                    }
                }
        
                //$listaEmpleados[$i]["diasImss"] =(int)$diasImss;
                $diasImssTotal= $diasImssTotal+(int)$diasImss;
                // $log->LogInfo("Valor de diasImss : " . var_export ($diasImss, true));
                // $log->LogInfo("Valor de  diasImssTotal: " . var_export ($diasImssTotal, true));
                
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
                $sdi = $factorIntegracion * $salarioDiario;
                $sdi = bcdiv($sdi, '1', 2);

                $listaEmpleados[$i]["sdi"] = $sdi;
                $sdiTotal= $sdiTotal+$sdi;
            //$log->LogInfo("Valor de  sdiTotal: " . var_export ($sdiTotal, true));

                $incapacidades= '0';
                $ausentismos  = '0';

                $listaEmpleados[$i]["incapacidades"]= $incapacidades;
                $incapacidadesTotal= $incapacidadesTotal+$incapacidades;
            //$log->LogInfo("Valor de  incapacidadesTotal: " . var_export ($incapacidadesTotal, true));


                $listaEmpleados[$i]["ausentismos"]  = $ausentismos;
                $ausentismosTotal= $ausentismosTotal+$ausentismos;
            //$log->LogInfo("Valor de  ausentismosTotal: " . var_export ($ausentismosTotal, true));



                $cuotaFija = $valorUma * $diasImss * $cfPorcentaje;
                $cuotaFija = $cuotaFija / 100;
                $cuotaFija = round($cuotaFija, 2);

                $listaEmpleados[$i]["cuotaFija"] = $cuotaFija;
                $cuotaFijaTotal= $cuotaFijaTotal+$cuotaFija;
            //$log->LogInfo("Valor de  cuotaFijaTotal: " . var_export ($cuotaFijaTotal, true));

                $excPatron = 0.00;
                $excObrero = 0.00;
                $banExc=0;

                if($sdi > (3 * $valorUma)){
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
                $excPatronTotal= $excPatronTotal+$excPatron;
            //$log->LogInfo("Valor de  excPatronTotal: " . var_export ($excPatronTotal, true));

                $listaEmpleados[$i]["excObrero"] = $excObrero;
                $excObreroTotal= $excObreroTotal+$excObrero;
            //$log->LogInfo("Valor de  excObreroTotal: " . var_export ($excObreroTotal, true));

                $prestDinPatron = $porPEnDPat * $sdi * $diasImss;
                $prestDinPatron = $prestDinPatron / 100;
                $prestDinPatron = bcdiv($prestDinPatron, '1', 2);
                $listaEmpleados[$i]["prestDinPatron"] = $prestDinPatron;
                $prestDinPatronTotal= $prestDinPatronTotal+$prestDinPatron;
            //$log->LogInfo("Valor de  prestDinPatronTotal: " . var_export ($prestDinPatronTotal, true));

                $prestDinObrero = $porPEnDObr * $sdi * $diasImss;
                $prestDinObrero = $prestDinObrero / 100;
                $prestDinObrero = bcdiv($prestDinObrero, '1', 2);
                $listaEmpleados[$i]["prestDinObrero"] = $prestDinObrero;
                $prestDinObreroTotal= $prestDinObreroTotal+$prestDinObrero;
            //$log->LogInfo("Valor de  prestDinObreroTotal: " . var_export ($prestDinObreroTotal, true));

                $gastosMedicosPatron = $porGMPatron * $sdi * $diasImss;
                $gastosMedicosPatron = $gastosMedicosPatron / 100;
                $gastosMedicosPatron = round($gastosMedicosPatron, 2);
                $listaEmpleados[$i]["gastosMedicosPatron"] = $gastosMedicosPatron;
                $gastosMedicosPatronTotal= $gastosMedicosPatronTotal+$gastosMedicosPatron;
            //$log->LogInfo("Valor de  gastosMedicosPatronTotal: " . var_export ($gastosMedicosPatronTotal, true));


                $gastosMedicosObrero = $porGMObrero * $sdi * $diasImss;
                $gastosMedicosObrero = $gastosMedicosObrero / 100;
                $gastosMedicosObrero = round($gastosMedicosObrero, 2);
                $listaEmpleados[$i]["gastosMedicosObrero"] = $gastosMedicosObrero;
                $gastosMedicosObreroTotal= $gastosMedicosObreroTotal+$gastosMedicosObrero;
            //$log->LogInfo("Valor de  gastosMedicosObreroTotal: " . var_export ($gastosMedicosObreroTotal, true));


                $riesgoTrabajo = $valorPrimaRT * $sdi * $diasImss;
                $riesgoTrabajo = $riesgoTrabajo / 100;
                $riesgoTrabajo = round($riesgoTrabajo, 2);
                $listaEmpleados[$i]["riesgoTrabajo"] = $riesgoTrabajo;
                $riesgoTrabajoTotal= $riesgoTrabajoTotal+$riesgoTrabajo;
           // $log->LogInfo("Valor de  riesgoTrabajoTotal: " . var_export ($riesgoTrabajoTotal, true));

                $invYvPatron = $invYvidaPat * $sdi * $diasImss;
                $invYvPatron = $invYvPatron / 100;
                $invYvPatron = round($invYvPatron, 2);
                $listaEmpleados[$i]["invYvPatron"] = $invYvPatron;
                $invYvPatronTotal= $invYvPatronTotal+$invYvPatron;
            //$log->LogInfo("Valor de  invYvPatronTotal: " . var_export ($invYvPatronTotal, true));

                $invYvObrero = $invYvidaObr * $sdi * $diasImss;
                $invYvObrero = $invYvObrero / 100;
                $invYvObrero = round($invYvObrero, 2);
                $listaEmpleados[$i]["invYvObrero"] = $invYvObrero;
                $invYvObreroTotal= $invYvObreroTotal+$invYvObrero;
            //$log->LogInfo("Valor de  invYvObreroTotal: " . var_export ($invYvObreroTotal, true));

                $guarderiasYPen = $porGuardYPen * $sdi * $diasImss;
                $guarderiasYPen = $guarderiasYPen / 100;
                $guarderiasYPen = round($guarderiasYPen, 2);
                $listaEmpleados[$i]["guarderiasYPen"] = $guarderiasYPen;
                $guarderiasYPenTotal= $guarderiasYPenTotal+$guarderiasYPen;
            //$log->LogInfo("Valor de  guarderiasYPenTotal: " . var_export ($guarderiasYPenTotal, true));

                $sumaPatronal=$excPatron+$prestDinPatron+$cuotaFija+$gastosMedicosPatron+$invYvPatron+$riesgoTrabajo+$guarderiasYPen;
                $sumaObrera=$excObrero+$prestDinObrero+$gastosMedicosObrero+$invYvObrero;

                $listaEmpleados[$i]["sumaPatron"] = $sumaPatronal;
                $sumaPatronalTotal= $sumaPatronalTotal+$sumaPatronal;
            //$log->LogInfo("Valor de  sumaPatronalTotal: " . var_export ($sumaPatronalTotal, true));

                $listaEmpleados[$i]["sumaObrero"] = $sumaObrera;
                $sumaObreraTotal= $sumaObreraTotal+$sumaObrera;
            //$log->LogInfo("Valor de  sumaObreraTotal: " . var_export ($sumaObreraTotal, true));


                $subTotal=$sumaPatronal+$sumaObrera;
                $listaEmpleados[$i]["subtotal"] = $subTotal;
                $subTotalTotal= $subTotalTotal+$subTotal;
            //$log->LogInfo("Valor de  subTotalTotal: " . var_export ($subTotalTotal, true));
            // $log->LogInfo("Valor de variable registroConsulta: " . var_export ($registroConsulta, true));

            }//for i
        //$datos["lista"][$j]=$listaEmpleados;
        }//FOR J
        $response["datos"]=$datos;
}else{
      $listaEmpleados= $negocio->negocio_obtenerEmpleadosEma($registroConsulta, $fechaPeriodo1, $fechaPeriodo2);
      $datosParaImss = $negocio->negocio_obtenerValoresImssEma($registroConsulta,$mesConsulta,$anio);
      $aguinaldo     = 15 / 365;
      $unidad        = 1;

      //DATOS DE PORCENTAJES EN TABLA IMSS
      $valorUma     = $datosParaImss["uma"];
      $valorPrimaRT = $datosParaImss["primaRiesgo"];
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

      $gastosMPPatStr= $datosParaImss["tblImss"][3]["Patron"];
      $porGMPatron   = substr($gastosMPPatStr, 0, -1);
      $porGMPatron   = str_replace(' ', '', $porGMPatron);    

      $gastosMPObrStr= $datosParaImss["tblImss"][3]["Obrero"];
      $porGMObrero   = substr($gastosMPObrStr, 0, -1);
      $porGMObrero   = str_replace(' ', '', $porGMObrero);    

      $invYvidaPatSTR= $datosParaImss["tblImss"][4]["Patron"];
      $invYvidaPat   = substr($invYvidaPatSTR, 0, -1);
      $invYvidaPat   = str_replace(' ', '', $invYvidaPat);  

      $invYvidaObrSTR= $datosParaImss["tblImss"][4]["Obrero"];
      $invYvidaObr   = substr($invYvidaObrSTR, 0, -1);
      $invYvidaObr   = str_replace(' ', '', $invYvidaObr); 

      $guardYPenStr  =$datosParaImss["tblImss"][7]["Patron"];
      $porGuardYPen  = substr($guardYPenStr, 0, -1);
      $porGuardYPen  = str_replace(' ', '', $porGuardYPen); 

      for($i = 0; $i < count($listaEmpleados); $i++){
          $fechaAlta         = $listaEmpleados[$i]["fechaImss"];
          $fechaBaja         = $listaEmpleados[$i]["fechaBajaImss"];
          $salarioDiario     = $listaEmpleados[$i]["salarioDiario"];
          $estatusImss       = $listaEmpleados[$i]["empleadoEstatusImss"];
          $diasTranscurridos = $listaEmpleados[$i]["diasTranscurridos"];
          $estatusRH=$listaEmpleados[$i]["empleadoEstatusId"];

        if($estatusRH=='2'){
           $listaEmpleados[$i]["fechaBajaImss"]=""; 
          }
          $dateAlta = date($fechaAlta);
          $dtAlta   = new DateTime($dateAlta);
          $anioAlta = $dtAlta->format('Y');
          $mesAlta  = $dtAlta->format('m');
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
          }else if ($estatusImss == '3') {
              if ($mesConsulta == $mesAlta && $anioAlta==$anioConsulta) {
                  $diasImss = $dtAlta->diff($dtLast);
                  $diasImss = $diasImss->days + 1;
              }else {
                  $diasImss = $diasDelMes;
              }
          }
        
          $listaEmpleados[$i]["diasImss"] =(int)$diasImss;
          $diasImssTotal= $diasImssTotal+(int)$diasImss;
        //$log->LogInfo("Valor de  diasImssTotal: " . var_export ($diasImssTotal, true));

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
          $sdi = $factorIntegracion * $salarioDiario;
          $sdi = bcdiv($sdi, '1', 2);

          $listaEmpleados[$i]["sdi"] = $sdi;
          $sdiTotal= $sdiTotal+$sdi;
        //$log->LogInfo("Valor de  sdiTotal: " . var_export ($sdiTotal, true));
          $incapacidades= '0';
          $ausentismos  = '0';

          $listaEmpleados[$i]["incapacidades"]= $incapacidades;
          $incapacidadesTotal= $incapacidadesTotal+$incapacidades;
        //$log->LogInfo("Valor de  incapacidadesTotal: " . var_export ($incapacidadesTotal, true));

          $listaEmpleados[$i]["ausentismos"]  = $ausentismos;
          $ausentismosTotal= $ausentismosTotal+$ausentismos;
        //$log->LogInfo("Valor de  ausentismosTotal: " . var_export ($ausentismosTotal, true));

          $cuotaFija = $valorUma * $diasImss * $cfPorcentaje;
          $cuotaFija = $cuotaFija / 100;
          $cuotaFija = round($cuotaFija, 2);

          $listaEmpleados[$i]["cuotaFija"] = $cuotaFija;
          $cuotaFijaTotal= $cuotaFijaTotal+$cuotaFija;
        //$log->LogInfo("Valor de  cuotaFijaTotal: " . var_export ($cuotaFijaTotal, true));

          $excPatron = 0.00;
          $excObrero = 0.00;
          $banExc=0;
            
          if($sdi > (3 * $valorUma)){
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
          $excPatronTotal= $excPatronTotal+$excPatron;
        //$log->LogInfo("Valor de  excPatronTotal: " . var_export ($excPatronTotal, true));


          $listaEmpleados[$i]["excObrero"] = $excObrero;
           $excObreroTotal= $excObreroTotal+$excObrero;
        //$log->LogInfo("Valor de  excObreroTotal: " . var_export ($excObreroTotal, true));

          $prestDinPatron = $porPEnDPat * $sdi * $diasImss;
          $prestDinPatron = $prestDinPatron / 100;
          $prestDinPatron = bcdiv($prestDinPatron, '1', 2);
          $listaEmpleados[$i]["prestDinPatron"] = $prestDinPatron;
          $restDinPatronTotal= $prestDinPatronTotal+$prestDinPatron;
        //$log->LogInfo("Valor de  prestDinPatronTotal: " . var_export ($prestDinPatronTotal, true));

          $prestDinObrero = $porPEnDObr * $sdi * $diasImss;
          $prestDinObrero = $prestDinObrero / 100;
          $prestDinObrero = bcdiv($prestDinObrero, '1', 2);
          $listaEmpleados[$i]["prestDinObrero"] = $prestDinObrero;
          $prestDinObreroTotal= $prestDinObreroTotal+$prestDinObrero;
        //$log->LogInfo("Valor de  prestDinObreroTotal: " . var_export ($prestDinObreroTotal, true));

          $gastosMedicosPatron = $porGMPatron * $sdi * $diasImss;
          $gastosMedicosPatron = $gastosMedicosPatron / 100;
          $gastosMedicosPatron = round($gastosMedicosPatron, 2);
          $listaEmpleados[$i]["gastosMedicosPatron"] = $gastosMedicosPatron;
          $gastosMedicosPatronTotal= $gastosMedicosPatronTotal+$gastosMedicosPatron;
        //$log->LogInfo("Valor de  gastosMedicosPatronTotal: " . var_export ($gastosMedicosPatronTotal, true));

          $gastosMedicosObrero = $porGMObrero * $sdi * $diasImss;
          $gastosMedicosObrero = $gastosMedicosObrero / 100;
          $gastosMedicosObrero = round($gastosMedicosObrero, 2);
          $listaEmpleados[$i]["gastosMedicosObrero"] = $gastosMedicosObrero;
          $gastosMedicosObreroTotal= $gastosMedicosObreroTotal+$gastosMedicosObrero;
        //$log->LogInfo("Valor de  gastosMedicosObreroTotal: " . var_export ($gastosMedicosObreroTotal, true));

          $riesgoTrabajo = $valorPrimaRT * $sdi * $diasImss;
          $riesgoTrabajo = $riesgoTrabajo / 100;
          $riesgoTrabajo = round($riesgoTrabajo, 2);
          $listaEmpleados[$i]["riesgoTrabajo"] = $riesgoTrabajo;
          $riesgoTrabajoTotal= $riesgoTrabajoTotal+$riesgoTrabajo;
        //$log->LogInfo("Valor de  riesgoTrabajoTotal: " . var_export ($riesgoTrabajoTotal, true));

          $invYvPatron = $invYvidaPat * $sdi * $diasImss;
          $invYvPatron = $invYvPatron / 100;
          $invYvPatron = round($invYvPatron, 2);
          $listaEmpleados[$i]["invYvPatron"] = $invYvPatron;
          $invYvPatronTotal= $invYvPatronTotal+$invYvPatron;
        //$log->LogInfo("Valor de  invYvPatronTotal: " . var_export ($invYvPatronTotal, true));

          $invYvObrero = $invYvidaObr * $sdi * $diasImss;
          $invYvObrero = $invYvObrero / 100;
          $invYvObrero = round($invYvObrero, 2);
          $listaEmpleados[$i]["invYvObrero"] = $invYvObrero;
          $invYvObreroTotal= $invYvObreroTotal+$invYvObrero;
        //$log->LogInfo("Valor de  invYvObreroTotal: " . var_export ($invYvObreroTotal, true));

          $guarderiasYPen = $porGuardYPen * $sdi * $diasImss;
          $guarderiasYPen = $guarderiasYPen / 100;
          $guarderiasYPen = round($guarderiasYPen, 2);
          $listaEmpleados[$i]["guarderiasYPen"] = $guarderiasYPen;
          $guarderiasYPenTotal= $guarderiasYPenTotal+$guarderiasYPen;
        //$log->LogInfo("Valor de  guarderiasYPenTotal: " . var_export ($guarderiasYPenTotal, true));

          $sumaPatronal=$excPatron+$prestDinPatron+$cuotaFija+$gastosMedicosPatron+$invYvPatron+$riesgoTrabajo+$guarderiasYPen;
          $sumaObrera  =$excObrero+$prestDinObrero+$gastosMedicosObrero+$invYvObrero;

          $listaEmpleados[$i]["sumaPatron"] = $sumaPatronal;
          $sumaPatronalTotal= $sumaPatronalTotal+$sumaPatronal;
        //$log->LogInfo("Valor de  sumaPatronalTotal: " . var_export ($sumaPatronalTotal, true));

          $listaEmpleados[$i]["sumaObrero"] = $sumaObrera;
          $sumaObreraTotal= $sumaObreraTotal+$sumaObrera;
        //$log->LogInfo("Valor de  sumaObreraTotal: " . var_export ($sumaObreraTotal, true));

          $subTotal=$sumaPatronal+$sumaObrera;
          $listaEmpleados[$i]["subtotal"] = $subTotal;
          $subTotalTotal= $subTotalTotal+$subTotal;
        //$log->LogInfo("Valor de  subTotalTotal: " . var_export ($subTotalTotal, true));
        }
    }

        $listaEmpleados["diasImssTotal"] =$diasImssTotal;
        $listaEmpleados["sdiTotal"] =$sdiTotal;
        $listaEmpleados["incapacidadesTotal"]= $incapacidadesTotal;
        $listaEmpleados["ausentismosTotal"]= $ausentismosTotal;

        $cuotaFijaTotalDecimales = round($cuotaFijaTotal, 2); //con 2 decimales
        $listaEmpleados["cuotaFijaTotal"] = $cuotaFijaTotalDecimales;


        $excPatronTotalDecimales = round($excPatronTotal, 2); //con 2 decimales
        $listaEmpleados["excPatronTotal"] = $excPatronTotalDecimales;
        
        $excObreroTotalDecimales = round($excObreroTotal, 2); //con 2 decimales
        $listaEmpleados["excObreroTotal"] = $excObreroTotalDecimales;
        
        $prestDinPatronTotalDecimales = round($prestDinPatronTotal, 2); //con 2 decimales
        $listaEmpleados["prestDinPatronTotal"]=$prestDinPatronTotalDecimales;
        
        $prestDinObreroTotalDecimales = round($prestDinObreroTotal, 2); //con 2 decimales
        $listaEmpleados["prestDinObreroTotal"]=$prestDinObreroTotalDecimales;
        
        $gastosMedicosPatronTotalDecimales = round($gastosMedicosPatronTotal, 2); //con 2 decimales
        $listaEmpleados["gastosMedicosPatronTotal"]=$gastosMedicosPatronTotalDecimales;
        
        $gastosMedicosObreroTotalDecimales = round($gastosMedicosObreroTotal, 2); //con 2 decimales
        $listaEmpleados["gastosMedicosObreroTotal"]=$gastosMedicosObreroTotalDecimales;
        
        $riesgoTrabajoTotalDecimales = round($riesgoTrabajoTotal, 2); //con 2 decimales
        $listaEmpleados["riesgoTrabajoTotal"] =$riesgoTrabajoTotalDecimales;

        $invYvPatronTotalDecimales = round($invYvPatronTotal, 2); //con 2 decimales
        $listaEmpleados["invYvPatronTotal"]   =$invYvPatronTotalDecimales;

        $invYvObreroTotalDecimales = round($invYvObreroTotal, 2); //con 2 decimales
        $listaEmpleados["invYvObreroTotal"]   =$invYvObreroTotalDecimales;

        $guarderiasYPenTotalDecimales = round($guarderiasYPenTotal, 2); //con 2 decimales
        $listaEmpleados["guarderiasYPenTotal"]=$guarderiasYPenTotalDecimales;

        $sumaPatronalTotalDecimales = round($sumaPatronalTotal, 2); //con 2 decimales
        $listaEmpleados["sumaPatronalTotal"]= $sumaPatronalTotalDecimales;

        $sumaObreraTotalDecimales = round($sumaObreraTotal, 2); //con 2 decimales
        $listaEmpleados["sumaObreraTotal"]= $sumaObreraTotalDecimales;

        $subTotalTotalDecimales = round($subTotalTotal, 2); //con 2 decimales
        $listaEmpleados["subTotalTotal"]= $subTotalTotalDecimales;



        $response["datos"]=$listaEmpleados;
        // $log->LogInfo("Valor de  response: " . var_export ($response, true));

}catch(Exception $e) {
       $response["status"]  = "error";
       $response["message"] = "Error: " . $e->getMessage();
}

echo json_encode($response);
