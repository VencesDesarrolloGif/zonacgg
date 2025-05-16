<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$log = new KLogger("ajaxCalculoProvisionEBA.log", KLogger::DEBUG);
$response  = array("status" => "success");
$mes       = date("m");
$anioActual= date("Y");
$registro  = $_POST["registro"];
$anio      = $_POST["anio"];
$bimestre  = $_POST["bimestre"];
$fecha     = $anio . "-" . $bimestre[1];
$aux       = date('Y-m-d', strtotime("{$fecha} + 1 month"));
$last_day  = date('Y-m-d', strtotime("{$aux} -1  day"));
$fechaPeriodo1=$anioActual."-".$bimestre[0]."-01";
$fechaPeriodo2=$last_day;
//$log->LogInfo("Valor de  _POST: " . var_export ($_POST, true));
if(($mes == $bimestre[0] || $mes == $bimestre[1]) && $anio==$anioActual){    
    $fechaPeriodo2=date("Y-m-d");    
}

$datos=array();
$datosProvisionEBA=array();
$diasInfonavitTotal=0;
$sdiTotal=0;
$incapacidadesTotal=0;
$ausentismosTotal=0;
$retiroTotal=0;
$cesantiaPatTotal=0;
$cesantiaObrTotal=0;
$suma1Total=0;
$aportacionConCreditoTotal=0;
$aportacionSinCreditoTotal=0;
$amortizacionTotal=0;
$suma2Total=0;
$creditoTotal=0;
try {
    if($registro=="TODOS"){
       $listaregistrospatronales = $negocio->negocio_traeCatalogoRegistrosPatronales();
        $response["datosRegistroPEBA"]=$listaregistrospatronales;
        
        for($j = 0; $j < count($listaregistrospatronales)+1; $j++){
            if($j == count($listaregistrospatronales)){
                $listaEmpleados[$j]["registrosP"]=""; 
                $listaEmpleados[$j]["diasImssTotalSumaT"]="";
                $listaEmpleados[$j]["diasInfonavitTotalEBA"]="";
                $listaEmpleados[$j]["sdiTotalSumaT"]="";
                $listaEmpleados[$j]["incapacidadesTotalSumaT"]="";
                $listaEmpleados[$j]["ausentismosTotalSumaT"]="";
                $listaEmpleados[$j]["cuotaFijaTotalSumaT"]="";
                $listaEmpleados[$j]["excPatronTotalSumaT"]="";
                $listaEmpleados[$j]["excObreroTotalSumaT"]="";
                $listaEmpleados[$j]["prestDinPatronTotalSumaT"]="";
                $listaEmpleados[$j]["prestDinObreroTotalSumaT"]="";
                $listaEmpleados[$j]["gastosMedicosPatronTotalSumaT"]="";
                $listaEmpleados[$j]["gastosMedicosObreroTotalSumaT"]="";
                $listaEmpleados[$j]["riesgoTrabajoTotalSumaT"]="";
                $listaEmpleados[$j]["invYvPatronTotalSumaT"]="";
                $listaEmpleados[$j]["invYvObreroTotalSumaT"]="";
                $listaEmpleados[$j]["guarderiasYPenTotalSumaT"]="";
                $listaEmpleados[$j]["sumaPatronalTotalSumaT"]="";
                $listaEmpleados[$j]["sumaObreraTotalSumaT"]="";
                $listaEmpleados[$j]["subTotalTotalSumaT"]="";
                $listaEmpleados[$j]["sdiTotalEBA"]="";
                $listaEmpleados[$j]["incapacidadesTotalEBA"]="";
                $listaEmpleados[$j]["ausentismosTotalEBA"]="";
                $listaEmpleados[$j]["retiroTotalEBA"]="";
                $listaEmpleados[$j]["cesantiaPatTotalEBA"]="";
                $listaEmpleados[$j]["cesantiaObrTotalEBA"]="";
                $listaEmpleados[$j]["suma1TotalEBA"]="";
                $listaEmpleados[$j]["aportacionConCreditoTotalEBA"]="";
                $listaEmpleados[$j]["aportacionSinCreditoTotalEBA"]="";
                $listaEmpleados[$j]["amortizacionTotalEBA"]="";
                $listaEmpleados[$j]["suma2TotalEBA"]="";
                $listaEmpleados[$j]["sumaTotalAmbasEbas"]="";
            }else{

            $registro=$listaregistrospatronales[$j]["idcatalogoRegistrosPatronales"];
            $listaEmpleados  = $negocio->negocio_obtenerEmpleadosEva($registro, $fechaPeriodo1, $fechaPeriodo2);
            $datosParaImss   = $negocio->negocio_obtenerValoresImss($anio);
            
            $aguinaldo       = 15 / 365;
            $unidad          = 1;
            $prcCyvPatron    = $datosParaImss["tblImss"][6]["Patron"];
            $prcCyvPatronVal = substr($prcCyvPatron, 0, -1);
            $prcCyvPatronVal = str_replace(' ', '', $prcCyvPatronVal);
            $prcCyvObrero    = $datosParaImss["tblImss"][6]["Obrero"];
            $prcCyvObreroVal = substr($prcCyvObrero, 0, -1);
            $prcCyvObreroVal = str_replace(' ', '', $prcCyvObreroVal);
            $retiroPrct      = $datosParaImss["tblImss"][5]["Patron"];
            $retiroPrctVal   = substr($retiroPrct, 0, -1);
            $retiroPrctVal   = str_replace(' ', '', $retiroPrctVal);
            $viviendaPatron  = $datosParaImss["tblImss"][8]["Patron"];
            $viviendaPatronVal = substr($viviendaPatron, 0, -1);
            $viviendaPatronVal = str_replace(' ', '', $viviendaPatronVal);
            
            for($i=0;$i< count($listaEmpleados);$i++){
                $empladoEntidad        = $listaEmpleados[$i]["empladoEntidadImss"];
                $empleadoConsecutivo        = $listaEmpleados[$i]["empleadoConsecutivoImss"];
                $empleadoCategoria        = $listaEmpleados[$i]["empleadoCategoriaImss"];
                $Amortizacionporempleado = $negocio->negocio_obtenerAmortizacionEmpleadosEva($empladoEntidad,$empleadoConsecutivo,$empleadoCategoria, $fechaPeriodo1, $fechaPeriodo2);
                $Amortizacion = $Amortizacionporempleado[0]["Amortizacion"];
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
                $diasInfo = 0;
                $dt1         = new DateTime($fechaPeriodo1);
                $dt2         = new DateTime($fechaPeriodo2);   
                if ($estatusImss == '7') {
                    if((($mesBaja == $bimestre[0] || $mesBaja == $bimestre[1]) && ($mesAlta == $bimestre[0] || $mesAlta == $bimestre[1])) && $anioAlta==$anio){
                        $diasInfo = $dtAlta->diff($dtBaja);
                        $diasInfo = $diasInfo->days + 1;
                    }else if(($mesAlta == $bimestre[0] || $mesAlta == $bimestre[1]) && $anioAlta==$anio){
                        $diasInfo= $dtAlta->diff($dt2);
                        $diasInfo = $diasInfo->days + 1;
                    }else if(($mesBaja == $bimestre[0] || $mesBaja == $bimestre[1])){
                        $diasInfo= $dt1->diff($dtBaja);
                        $diasInfo = $diasInfo->days + 1;
                    }else{
                        $diasInfo= $dt1->diff($dt2);
                        $diasInfo = $diasInfo->days + 1;
                    }  
                }else if ($estatusImss == '3') {
                    if(($mesAlta == $bimestre[0] || $mesAlta == $bimestre[1]) && $anioAlta==$anio){
                        $diasInfo = $dtAlta->diff($dt2);
                        $diasInfo = $diasInfo->days + 1;
                    }else{
                        $diasInfo = $dt1->diff($dt2);
                        $diasInfo = $diasInfo->days + 1;
                    }
                } 
                $listaEmpleados[$i]["diasInfonavit"] = $diasInfo;
                $diasInfonavitTotal= $diasInfonavitTotal+$diasInfo;
                // $log->LogInfo("Valor de  j: " . var_export ($j, true)); //revisar no llega solo el primero, lo demas esta bien
                // $log->LogInfo("Valor de  diasInfonavitTotal: " . var_export ($diasInfonavitTotal, true)); //revisar no llega solo el primero, lo demas esta bien

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
                 $sdiTotal= $sdiTotal+$sdi;
            //$log->LogInfo("Valor de  sdiTotal: " . var_export ($sdiTotal, true)); 

                 $incapacidades     = '0';
                 $ausentismos       = '0';
                 $listaEmpleados[$i]["incapacidades"] = $incapacidades;
                 $incapacidadesTotal= $incapacidadesTotal+$incapacidades;
            //$log->LogInfo("Valor de  incapacidadesTotal: " . var_export ($incapacidadesTotal, true));

                 $listaEmpleados[$i]["ausentismos"] = $ausentismos;
                 $ausentismosTotal= $ausentismosTotal+$ausentismos;
            //$log->LogInfo("Valor de  ausentismosTotal: " . var_export ($ausentismosTotal, true));

                 $retiro=($sdi*$diasInfo*$retiroPrctVal)/100;
                 $retiro = round($retiro, 2);
                 $listaEmpleados[$i]["retiro"] = $retiro;
                 $retiroTotal= $retiroTotal+$retiro;
            //$log->LogInfo("Valor de  retiroTotal: " . var_export ($retiroTotal, true));

                 //CESANTIA Y VEJEZ
                 $cyvPatronal=($sdi*$diasInfo*$prcCyvPatronVal)/100;
                 $cyvPatronal = round($cyvPatronal, 2);
                 $listaEmpleados[$i]["cesantiaPat"] = $cyvPatronal;
                 $cesantiaPatTotal= $cesantiaPatTotal+$cyvPatronal;
            //$log->LogInfo("Valor de  cesantiaPatTotal: " . var_export ($cesantiaPatTotal, true));

                 $cyvObrero=($sdi*$diasInfo*$prcCyvObreroVal)/100;
                 $cyvObrero = round($cyvObrero, 2);
                 $listaEmpleados[$i]["cesantiaObr"] = $cyvObrero;
                 $cesantiaObrTotal= $cesantiaObrTotal+$cyvObrero;
            //$log->LogInfo("Valor de  cesantiaObrTotal: " . var_export ($cesantiaObrTotal, true));

                 $suma1=$retiro+$cyvPatronal+$cyvObrero;
                 $listaEmpleados[$i]["suma1"] = $suma1;
                 $suma1Total= $suma1Total+$suma1;
            //$log->LogInfo("Valor de  suma1Total: " . var_export ($suma1Total, true));

                 $vivienda=($sdi*$diasInfo*$viviendaPatronVal)/100;
                 $vivienda = round($vivienda, 2);
                
                if($Amortizacion=="0"){
                    $listaEmpleados[$i]["aportacionConCredito"] = 0;
                    $listaEmpleados[$i]["aportacionSinCredito"] = $vivienda;
                }else{
                    $listaEmpleados[$i]["aportacionConCredito"] = $vivienda;
                    $listaEmpleados[$i]["aportacionSinCredito"] = 0;
                }

                $aportacionConCreditoTotal= $aportacionConCreditoTotal+$listaEmpleados[$i]["aportacionConCredito"];
            //$log->LogInfo("Valor de  aportacionConCreditoTotal: " . var_export ($aportacionConCreditoTotal, true));

                $aportacionSinCreditoTotal= $aportacionSinCreditoTotal+$listaEmpleados[$i]["aportacionSinCredito"];
            //$log->LogInfo("Valor de  aportacionSinCreditoTotal: " . var_export ($aportacionSinCreditoTotal, true));


                //$listaEmpleados[$i]["aportacion"] = $vivienda;
                $suma2=$vivienda;
                $listaEmpleados[$i]["suma2"] = $suma2;
                $suma2Total= $suma2Total+$suma2;
            //$log->LogInfo("Valor de  suma2Total: " . var_export ($suma2Total, true));
                
                $listaEmpleados[$i]["amortizacion"] = $Amortizacion;
                $amortizacionTotal= $amortizacionTotal+$Amortizacion;
            //$log->LogInfo("Valor de  amortizacionTotal: " . var_export ($amortizacionTotal, true));
               //$log->LogInfo("Valor de variable registro: " . var_export ($registro, true)); 
            }//termina for i
         // $log->LogInfo("Valor de variable j: " . var_export ($j, true));

            $datosProvisionEBA[$registro]["diasInfonavitTotal"]=$diasInfonavitTotal;
            $datosProvisionEBA[$registro]["sdiTotal"]=$sdiTotal;
            $datosProvisionEBA[$registro]["incapacidadesTotal"]=$incapacidadesTotal;
            $datosProvisionEBA[$registro]["ausentismosTotal"]=$ausentismosTotal;
            $datosProvisionEBA[$registro]["retiroTotal"]=$retiroTotal;
            $datosProvisionEBA[$registro]["cesantiaPatTotal"]=$cesantiaPatTotal;
            $datosProvisionEBA[$registro]["cesantiaObrTotal"]=$cesantiaObrTotal;
            $datosProvisionEBA[$registro]["suma1Total"]=$suma1Total;
            $datosProvisionEBA[$registro]["aportacionConCreditoTotal"]=$aportacionConCreditoTotal;
            $datosProvisionEBA[$registro]["aportacionSinCreditoTotal"]=$aportacionSinCreditoTotal;
            $datosProvisionEBA[$registro]["amortizacionTotal"]=$amortizacionTotal;
            $datosProvisionEBA[$registro]["suma2Total"]=$suma2Total + $amortizacionTotal;
            $datosProvisionEBA[$registro]["creditoTotal"]=$creditoTotal;
            $datosProvisionEBA[$registro]["sumaTotalAmbasEbas"]=$suma1Total + $suma2Total + $amortizacionTotal;




            //$datos["lista"][$j]=$listaEmpleados;
            $diasInfonavitTotal=0;
            $sdiTotal=0;
            $incapacidadesTotal=0;
            $ausentismosTotal=0;
            $retiroTotal=0;
            $cesantiaPatTotal=0;
            $cesantiaObrTotal=0;
            $suma1Total=0;
            $aportacionConCreditoTotal=0;
            $aportacionSinCreditoTotal=0;
            $amortizacionTotal=0;
            $suma2Total=0;
            $creditoTotal=0;
        }
        }//for j
        //$response["datos"]=$datos;
        $response["datosProvisionEBA"]=$datosProvisionEBA;

}else{
    $listaEmpleados = $negocio->negocio_obtenerEmpleadosEva($registro, $fechaPeriodo1, $fechaPeriodo2);
    $datosParaImss  = $negocio->negocio_obtenerValoresImss($anio);
    $aguinaldo      = 15 / 365;
    $unidad         = 1;
    $prcCyvPatron   = $datosParaImss["tblImss"][6]["Patron"];
    $prcCyvPatronVal= substr($prcCyvPatron, 0, -1);
    $prcCyvPatronVal= str_replace(' ', '', $prcCyvPatronVal);

    $prcCyvObrero   = $datosParaImss["tblImss"][6]["Obrero"];
    $prcCyvObreroVal= substr($prcCyvObrero, 0, -1);
    $prcCyvObreroVal= str_replace(' ', '', $prcCyvObreroVal);

    $retiroPrct   = $datosParaImss["tblImss"][5]["Patron"];
    $retiroPrctVal= substr($retiroPrct, 0, -1);
    $retiroPrctVal= str_replace(' ', '', $retiroPrctVal);

    $viviendaPatron=$datosParaImss["tblImss"][8]["Patron"];
    $viviendaPatronVal = substr($viviendaPatron, 0, -1);
    $viviendaPatronVal = str_replace(' ', '', $viviendaPatronVal);
    //$log->LogInfo("Valor de la variable \$last_day punto: " . var_export ($last_day, true));
    //$log->LogInfo("Valor de la variable \$last_day punto: " . var_export ($last_day, true));

    for($i=0;$i< count($listaEmpleados);$i++){
        $empladoEntidad     = $listaEmpleados[$i]["empladoEntidadImss"];
        $empleadoConsecutivo= $listaEmpleados[$i]["empleadoConsecutivoImss"];
        $empleadoCategoria  = $listaEmpleados[$i]["empleadoCategoriaImss"];
        $fechaAlta          = $listaEmpleados[$i]["fechaImss"];
        $fechaBaja          = $listaEmpleados[$i]["fechaBajaImss"];
        $salarioDiario      = $listaEmpleados[$i]["salarioDiario"];
        $estatusImss        = $listaEmpleados[$i]["empleadoEstatusImss"];
        $diasTranscurridos  = $listaEmpleados[$i]["diasTranscurridos"];
        $estatusRH          = $listaEmpleados[$i]["empleadoEstatusId"];
        $Amortizacionporempleado= $negocio->negocio_obtenerAmortizacionEmpleadosEva($empladoEntidad,$empleadoConsecutivo,$empleadoCategoria, $fechaPeriodo1, $fechaPeriodo2);
        $Amortizacion      = $Amortizacionporempleado[0]["Amortizacion"];

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
        
        $dt1 = new DateTime($fechaPeriodo1);
        $dt2 = new DateTime($fechaPeriodo2);      
        if ($estatusImss == '7') {        
            if((($mesBaja == $bimestre[0] || $mesBaja == $bimestre[1]) && ($mesAlta == $bimestre[0] || $mesAlta == $bimestre[1])) && $anioAlta==$anio){
                 $diasInfo = $dtAlta->diff($dtBaja);
                 $diasInfo = $diasInfo->days + 1;
            }else if(($mesAlta == $bimestre[0] || $mesAlta == $bimestre[1]) && $anioAlta==$anio){
                      $diasInfo = $dtAlta->diff($dt2);
                      $diasInfo = $diasInfo->days + 1;
            }else if(($mesBaja == $bimestre[0] || $mesBaja == $bimestre[1])){
                      $diasInfo = $dt1->diff($dtBaja);
                      $diasInfo = $diasInfo->days + 1;
            }else{
                $diasInfo = $dt1->diff($dt2);
                $diasInfo = $diasInfo->days + 1;
            }  
        } else if($estatusImss == '3') {
            if(($mesAlta == $bimestre[0] || $mesAlta == $bimestre[1]) && $anioAlta==$anio){
                $diasInfo = $dtAlta->diff($dt2);
                $diasInfo = $diasInfo->days + 1;
            }else{
                  $diasInfo = $dt1->diff($dt2);
                  $diasInfo = $diasInfo->days + 1;
            }
        } 

        $listaEmpleados[$i]["diasInfonavit"] = $diasInfo;
        $diasInfonavitTotal= $diasInfonavitTotal+$diasInfo;
        // $log->LogInfo("Valor de  diasInfonavitTotal: " . var_export ($diasInfonavitTotal, true)); //revisar no llega solo el primero, lo demas esta bien
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

        $retiro=($sdi*$diasInfo*$retiroPrctVal)/100;
        $retiro= round($retiro, 2);
        $listaEmpleados[$i]["retiro"] = $retiro;
        $retiroTotal= $retiroTotal+$retiro;
    //$log->LogInfo("Valor de  retiroTotal: " . var_export ($retiroTotal, true));

        //CESANTIA Y VEJEZ

        $cyvPatronal=($sdi*$diasInfo*$prcCyvPatronVal)/100;
        $cyvPatronal= round($cyvPatronal, 2);
        $listaEmpleados[$i]["cesantiaPat"] = $cyvPatronal;
        $cesantiaPatTotal= $cesantiaPatTotal+$cyvPatronal;
    //$log->LogInfo("Valor de  cesantiaPatTotal: " . var_export ($cesantiaPatTotal, true));

        $cyvObrero=($sdi*$diasInfo*$prcCyvObreroVal)/100;
        $cyvObrero= round($cyvObrero, 2);
        $listaEmpleados[$i]["cesantiaObr"] = $cyvObrero;
        $cesantiaObrTotal= $cesantiaObrTotal+$cyvObrero;
    //$log->LogInfo("Valor de  cesantiaObrTotal: " . var_export ($cesantiaObrTotal, true));

        $suma1=$retiro+$cyvPatronal+$cyvObrero;
        $listaEmpleados[$i]["suma1"] = $suma1;
        $suma1Total= $suma1Total+$suma1;
    //$log->LogInfo("Valor de  suma1Total: " . var_export ($suma1Total, true));

        $vivienda=($sdi*$diasInfo*$viviendaPatronVal)/100; 
        $vivienda = round($vivienda, 2);
        if($Amortizacion=="0"){
            $listaEmpleados[$i]["aportacionConCredito"] = 0;
            $listaEmpleados[$i]["aportacionSinCredito"] = $vivienda;
        }else{
            $listaEmpleados[$i]["aportacionConCredito"] = $vivienda;
            $listaEmpleados[$i]["aportacionSinCredito"] = 0;
        }
       // $listaEmpleados[$i]["aportacion"] = $vivienda;

        $aportacionConCreditoTotal= $aportacionConCreditoTotal+$listaEmpleados[$i]["aportacionConCredito"];
    //$log->LogInfo("Valor de  aportacionConCreditoTotal: " . var_export ($aportacionConCreditoTotal, true));

        $aportacionSinCreditoTotal= $aportacionSinCreditoTotal+$listaEmpleados[$i]["aportacionSinCredito"];
    //$log->LogInfo("Valor de  aportacionSinCreditoTotal: " . var_export ($aportacionSinCreditoTotal, true));

        $suma2=$vivienda;
        $listaEmpleados[$i]["suma2"] = $suma2;
        $suma2Total= $suma2Total+$suma2;
    //$log->LogInfo("Valor de  suma2Total: " . var_export ($suma2Total, true));
        $listaEmpleados[$i]["amortizacion"] = $Amortizacion;
        $amortizacionTotal= $amortizacionTotal+$Amortizacion;
    //$log->LogInfo("Valor de  amortizacionTotal: " . var_export ($amortizacionTotal, true));
    }
}
    $listaEmpleados["diasInfonavitTotalEBA"] =$diasInfonavitTotal;
    $listaEmpleados["sdiTotalEBA"] =$sdiTotal;
    $listaEmpleados["incapacidadesTotalEBA"]= $incapacidadesTotal;
    $listaEmpleados["ausentismosTotalEBA"]= $ausentismosTotal;
    $listaEmpleados["retiroTotalEBA"] = $retiroTotal;
    $listaEmpleados["cesantiaPatTotalEBA"]  = $cesantiaPatTotal;
    $listaEmpleados["cesantiaObrTotalEBA"]  = $cesantiaObrTotal;
    $listaEmpleados["suma1TotalEBA"]=$suma1Total;
    $listaEmpleados["aportacionConCreditoTotalEBA"]=$aportacionConCreditoTotal;
    $listaEmpleados["aportacionSinCreditoTotalEBA"]=$aportacionSinCreditoTotal;
    $listaEmpleados["amortizacionTotalEBA"]=$amortizacionTotal;
    $listaEmpleados["suma2TotalEBA"]=$suma2Total + $amortizacionTotal;
    $listaEmpleados["sumaTotalAmbasEbas"]=$suma1Total + $suma2Total + $amortizacionTotal;// agregado recientemente el 19/07/2024 con el conta

    //$listaEmpleados["creditoTotal"]=$creditoTotal;

    $response["datosInfo"] = $listaEmpleados;
        $log->LogInfo("Valor de  listaEmpleados: " . var_export ($listaEmpleados, true));

} catch (Exception $e) {
    $response["status"]  = "error";
    $response["message"] = "Error: " . $e->getMessage();
}

echo json_encode($response);
