<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
require "conexion.php";
$log = new KLogger("ajax_calcularProvisionEBADiferenciasHP.log", KLogger::DEBUG);
$response  = array("status" => "success");
// $mes       = date("m");
$anioActual= date("Y");
$registro  = $_POST["registro"];
$anio      = $_POST["anio"];
$mes= $_POST["mes"];//mes del periodo
$fechaInicioPeriodo=$_POST['fechaInicioPeriodo'];
$fechaTerminoPeriodo=$_POST['fechaTerminoPeriodo'];
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

try {
    if($registro=="TODOS"){
       $listaregistrospatronales = $negocio->negocio_traeCatalogoRegistrosPatronales();
        $response["datosRegistroPEBA"]=$listaregistrospatronales;
        // $log->LogInfo("Valor de  listaregistrospatronales: " . var_export ($listaregistrospatronales, true));
        // $log->LogInfo("Valor de  count(listaregistrospatronales): " . var_export (count($listaregistrospatronales), true));

        // for($j = 0; $j < count($listaregistrospatronales)+1; $j++){
        for($j = 0; $j < count($listaregistrospatronales); $j++){
            $listaLN = [];
            if($j == count($listaregistrospatronales)){
                $log->LogInfo("Valor de  ENTRE: " . var_export ($j, true));

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


                $sql5 = "SELECT idLineaNegocio, descripcionLineaNegocio 
                         FROM catalogolineanegocio";
                $res5 = mysqli_query($conexion, $sql5);

                while (($reg5 = mysqli_fetch_array($res5, MYSQLI_ASSOC))) {
                    $listaLN[] = $reg5;
                }

                for($k=0; $k < count($listaLN); $k++) { 
                    $lineaNeg=$listaLN[$k]["idLineaNegocio"];

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

                    for($l=0; $l < 2; $l++){

                        if($l==0){
                         $tipoEmp="02";
                        }else{
                         $tipoEmp="03";
                        }

                        $registro=$listaregistrospatronales[$j]["idcatalogoRegistrosPatronales"];

                        $datosProvisionEBA[$registro]["diasInfonavitTotal"]=0;
                        $datosProvisionEBA[$registro]["sdiTotal"]=0;
                        $datosProvisionEBA[$registro]["incapacidadesTotal"]=0;
                        $datosProvisionEBA[$registro]["ausentismosTotal"]=0;
                        $datosProvisionEBA[$registro]["retiroTotal"]=0;
                        $datosProvisionEBA[$registro]["cesantiaPatTotal"]=0;
                        $datosProvisionEBA[$registro]["cesantiaObrTotal"]=0;
                        $datosProvisionEBA[$registro]["suma1Total"]=0;
                        $datosProvisionEBA[$registro]["aportacionConCreditoTotal"]=0;
                        $datosProvisionEBA[$registro]["aportacionSinCreditoTotal"]=0;
                        $datosProvisionEBA[$registro]["amortizacionTotal"]=0;
                        $datosProvisionEBA[$registro]["suma2Total"]=0;
                        $datosProvisionEBA[$registro]["creditoTotal"]=0;
                        $datosProvisionEBA[$registro]["sumaTotalAmbasEbas"]=0;
                        $log->LogInfo("Valor de  registro: " . var_export ($registro, true));

                        $listaEmpleados  = $negocio->negocio_obtenerEmpleadosEvaHP($registro, $fechaPeriodo1, $fechaPeriodo2,$lineaNeg,$tipoEmp);
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

                            $incapacidades     = '0';
                            $ausentismos       = '0';
                            $listaEmpleados[$i]["incapacidades"] = $incapacidades;
                            $incapacidadesTotal= $incapacidadesTotal+$incapacidades;

                            $listaEmpleados[$i]["ausentismos"] = $ausentismos;
                            $ausentismosTotal= $ausentismosTotal+$ausentismos;

                            $retiro=($sdi*$diasInfo*$retiroPrctVal)/100;
                            $retiro = round($retiro, 2);
                            $listaEmpleados[$i]["retiro"] = $retiro;
                            $retiroTotal= $retiroTotal+$retiro;

                            //CESANTIA Y VEJEZ
                            $cyvPatronal=($sdi*$diasInfo*$prcCyvPatronVal)/100;
                            $cyvPatronal = round($cyvPatronal, 2);
                            $listaEmpleados[$i]["cesantiaPat"] = $cyvPatronal;
                            $cesantiaPatTotal= $cesantiaPatTotal+$cyvPatronal;

                            $cyvObrero=($sdi*$diasInfo*$prcCyvObreroVal)/100;
                            $cyvObrero = round($cyvObrero, 2);
                            $listaEmpleados[$i]["cesantiaObr"] = $cyvObrero;
                            $cesantiaObrTotal= $cesantiaObrTotal+$cyvObrero;

                            $suma1=$retiro+$cyvPatronal+$cyvObrero;
                            $listaEmpleados[$i]["suma1"] = $suma1;
                            $suma1Total= $suma1Total+$suma1;

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
                            $aportacionSinCreditoTotal= $aportacionSinCreditoTotal+$listaEmpleados[$i]["aportacionSinCredito"];

                            $suma2=$vivienda;
                            $listaEmpleados[$i]["suma2"] = $suma2;
                            $suma2Total= $suma2Total+$suma2;
                
                            $listaEmpleados[$i]["amortizacion"] = $Amortizacion;
                            $amortizacionTotal= $amortizacionTotal+$Amortizacion;
                        }//termina for i LISTA EMPLEADOS

                        $netoEba=$suma1Total + $suma2Total + $amortizacionTotal;

                $log->LogInfo("Valor de variable datosProvisionEBA: " . var_export ($datosProvisionEBA, true));

                        $datosProvisionEBA[$registro]["diasInfonavitTotal"]+=$diasInfonavitTotal;
                        $datosProvisionEBA[$registro]["sdiTotal"]+=$sdiTotal;
                        $datosProvisionEBA[$registro]["incapacidadesTotal"]+=$incapacidadesTotal;
                        $datosProvisionEBA[$registro]["ausentismosTotal"]+=$ausentismosTotal;
                        $datosProvisionEBA[$registro]["retiroTotal"]+=$retiroTotal;
                        $datosProvisionEBA[$registro]["cesantiaPatTotal"]+=$cesantiaPatTotal;
                        $datosProvisionEBA[$registro]["cesantiaObrTotal"]+=$cesantiaObrTotal;
                        $datosProvisionEBA[$registro]["suma1Total"]+=$suma1Total;
                        $datosProvisionEBA[$registro]["aportacionConCreditoTotal"]+=$aportacionConCreditoTotal;
                        $datosProvisionEBA[$registro]["aportacionSinCreditoTotal"]+=$aportacionSinCreditoTotal;
                        $datosProvisionEBA[$registro]["amortizacionTotal"]+=$amortizacionTotal;
                        $datosProvisionEBA[$registro]["suma2Total"]+=$suma2Total + $amortizacionTotal;
                        $datosProvisionEBA[$registro]["creditoTotal"]+=$creditoTotal;
                        $datosProvisionEBA[$registro]["sumaTotalAmbasEbas"]+=$suma1Total + $suma2Total + $amortizacionTotal;


                        $sql6 = "INSERT INTO historico_ProvisionEBA(registroPatronalHPEBA,
                                                                    anioProvisionHPEBA,
                                                                    mesProvisionHPEBA,
                                                                    inicioPeriodoHPEBA,
                                                                    finPeriodoHPEBA,
                                                                    lineaNegocioHPEBA,
                                                                    tipoPuestoHPEBA,
                                                                    díasHPEBA,
                                                                    sdiHPEBA,
                                                                    incHPEBA,
                                                                    ausHPEBA,
                                                                    retiroHPEBA,
                                                                    cesantiaYvejezHPEBAPat,
                                                                    cesantiaYvejezHPEBAobr,
                                                                    sumaHPEBA1,
                                                                    aportacionPatronalHPEBACredito,
                                                                    aportacionPatronalHPEBAsinCredito,
                                                                    amortizacionHPEBA,
                                                                    sumaHPEBA2,
                                                                    sumaTotalHPEBA,
                                                                    fechaGuardadoHPEBA,
                                                                    netoHPEBA)
                                        VALUES('$registro',
                                               '$anio',
                                               '$mes',
                                               '$fechaInicioPeriodo',
                                               '$fechaTerminoPeriodo',
                                               '$lineaNeg',
                                               '$tipoEmp',
                                               '$diasInfonavitTotal',
                                               '$sdiTotal',
                                               '$incapacidadesTotal',
                                               '$ausentismosTotal',
                                               '$retiroTotal',
                                               '$cesantiaPatTotal',
                                               '$cesantiaObrTotal',
                                               '$suma1Total',
                                               '$aportacionConCreditoTotal',
                                               '$aportacionSinCreditoTotal',
                                               '$amortizacionTotal',
                                               '$suma2Total',
                                               '$creditoTotal',
                                                now(),
                                               '$netoEba')";
                // $log->LogInfo("Valor de variable sql6: " . var_export ($sql6, true));
                $res6 = mysqli_query($conexion, $sql6);


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
                    }// for L...FOR TIPOS
                }//for k linea de negocio
            }//ELSE 1ER REGISTRO PATRONAL
        }//for j REGISTROS PATRONALES 
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
        $incapacidades= '0';
        $ausentismos  = '0';

        $listaEmpleados[$i]["incapacidades"]= $incapacidades;
        $incapacidadesTotal= $incapacidadesTotal+$incapacidades;

        $listaEmpleados[$i]["ausentismos"]  = $ausentismos;
        $ausentismosTotal= $ausentismosTotal+$ausentismos;

        $retiro=($sdi*$diasInfo*$retiroPrctVal)/100;
        $retiro= round($retiro, 2);
        $listaEmpleados[$i]["retiro"] = $retiro;
        $retiroTotal= $retiroTotal+$retiro;

        //CESANTIA Y VEJEZ

        $cyvPatronal=($sdi*$diasInfo*$prcCyvPatronVal)/100;
        $cyvPatronal= round($cyvPatronal, 2);
        $listaEmpleados[$i]["cesantiaPat"] = $cyvPatronal;
        $cesantiaPatTotal= $cesantiaPatTotal+$cyvPatronal;

        $cyvObrero=($sdi*$diasInfo*$prcCyvObreroVal)/100;
        $cyvObrero= round($cyvObrero, 2);
        $listaEmpleados[$i]["cesantiaObr"] = $cyvObrero;
        $cesantiaObrTotal= $cesantiaObrTotal+$cyvObrero;

        $suma1=$retiro+$cyvPatronal+$cyvObrero;
        $listaEmpleados[$i]["suma1"] = $suma1;
        $suma1Total= $suma1Total+$suma1;

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

        $aportacionSinCreditoTotal= $aportacionSinCreditoTotal+$listaEmpleados[$i]["aportacionSinCredito"];

        $suma2=$vivienda;
        $listaEmpleados[$i]["suma2"] = $suma2;
        $suma2Total= $suma2Total+$suma2;
        $listaEmpleados[$i]["amortizacion"] = $Amortizacion;
        $amortizacionTotal= $amortizacionTotal+$Amortizacion;
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
        // $log->LogInfo("Valor de  listaEmpleados: " . var_export ($listaEmpleados, true));

} catch (Exception $e) {
    $response["status"]  = "error";
    $response["message"] = "Error: " . $e->getMessage();
}

echo json_encode($response);
