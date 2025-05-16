<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
// $log = new KLogger("consultaDetalleSujetoOblogado.log", KLogger::DEBUG);
$negocio           = new Negocio ();
$response          = array();
$response["status"]= "error";
$datos             = array();

$cuatrimestre=$_POST['cuatrimestre'];
$anio=$_POST['anio'];
$mes      = date("m");
$anioActual= date("Y");
$total_Credito2=0;
$total_SinCredito2=0;
$total_AmortizacionTotal2=0;

// $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
//$log->LogInfo("Valor de la variable anio: " . var_export ($anio, true));

if($cuatrimestre==1) {
   $fechaInicio= $anio."-01-01";
   $fechaFin= $anio."-04-30";
  }
  else if($cuatrimestre==2) {
   $fechaInicio= $anio."-05-01";
   $fechaFin= $anio."-08-31";
  }
  else if($cuatrimestre==3) {
   $fechaInicio= $anio."-09-01";
   $fechaFin= $anio."-12-31";
  }

  //  $log->LogInfo("Valor de la variable fechaInicio: " . var_export ($fechaInicio, true));
  //  $log->LogInfo("Valor de la variable fechaFin: " . var_export ($fechaFin, true));
try {
    $infoRegPatSujetoObligado   = $negocio -> registrosPatronalesSujetoObligado();//se busca solo entidad 9 que es donde esta coorporativo gif
    //$log->LogInfo("Valor de la variable infoRegPatSujetoObligado: " . var_export ($infoRegPatSujetoObligado, true));
    
    for ($i=0; $i <count($infoRegPatSujetoObligado)+1 ; $i++) { 
     if($i!=count($infoRegPatSujetoObligado)){
        $unidad         = 1;
        $aguinaldo      = 15 / 365;
        $Credito = 0;
        $SinCredito = 0;
        $AmortizacionTotal = 0;
        $Credito1 =0;
        $SinCredito1 =0;
        $AmortizacionTotal1 =0;
        $datosParaImss  = $negocio->negocio_obtenerValoresImss($anio);
        $viviendaPatron=$datosParaImss["tblImss"][8]["Patron"];
        $viviendaPatronVal = substr($viviendaPatron, 0, -1);
        $viviendaPatronVal = str_replace(' ', '', $viviendaPatronVal);

        $infoSujetoObligado   = $negocio -> infoDetalleSujetoObligado();//se busca solo cliente 13 ya que es gif el sujeto obligado
        $rfcSujetoObligado    = $negocio -> obtenerRFCSujetoObligado();//se busca de la tabla "empresa" ya que es donde esta bien el RFC
        $infoEscrituraPublica = $negocio -> infoEscrituraPublica($fechaFin);
        $numeroRepse = $negocio -> obtenerRepse1();
    
    
        $response["datosSO"][$i]["rfcCliente"]             = $rfcSujetoObligado[0]["rfcCliente"];
        $response["datosSO"][$i]["razonSocial"]            = $rfcSujetoObligado[0]["razonSocial"];
        $response["datosSO"][$i]["correoCliente"]          = $infoSujetoObligado[0]["correoCliente"];
        $response["datosSO"][$i]["telefonoFijoCliente"]    = $infoSujetoObligado[0]["telefonoFijoCliente"];
        $response["datosSO"][$i]["RegistroPatronal"]       = $infoRegPatSujetoObligado[$i]["idcatalogoRegistrosPatronales"];
        $registro = $infoRegPatSujetoObligado[$i]["idcatalogoRegistrosPatronales"];
        $response["datosSO"][$i]["CallePrincipaCliente"]   = $infoSujetoObligado[0]["CallePrincipaCliente"];
        $response["datosSO"][$i]["NumeroExteriorCliente"]  = $infoSujetoObligado[0]["NumeroExteriorCliente"];
        $response["datosSO"][$i]["NumeroInterirCliente"]   = $infoSujetoObligado[0]["NumeroInterirCliente"];
        $response["datosSO"][$i]["PrimerCalleCliente"]     = $infoSujetoObligado[0]["PrimerCalleCliente"];
        $response["datosSO"][$i]["SegundaCalleCliente"]    = $infoSujetoObligado[0]["SegundaCalleCliente"];
        $response["datosSO"][$i]["ColoniaCliente"]         = $infoSujetoObligado[0]["nombreAsentamiento"];
        $response["datosSO"][$i]["CodigoPostalCliente"]    = $infoSujetoObligado[0]["CodigoPostalCliente"];
        $response["datosSO"][$i]["MunicipioCliente"]       = $infoSujetoObligado[0]["nombreMunicipio"];
        $response["datosSO"][$i]["nombreEntidadFederativa"]= $infoSujetoObligado[0]["nombreEntidadFederativa"];
    
        if (count($infoEscrituraPublica)=='0' || count($infoEscrituraPublica)=='NULL' || count($infoEscrituraPublica)=='null'){
            $response["datosSO"][$i]["representantelegal"]     = "SIN INFORMACIÓN CARGADA";
            $response["datosSO"][$i]["administradorunico"]     = "SIN INFORMACIÓN CARGADA";
            $response["datosSO"][$i]["numerodeescritura"]      = "SIN INFORMACIÓN CARGADA";
            $response["datosSO"][$i]["nombreDelNotarioPublico"]= "SIN INFORMACIÓN CARGADA";
            $response["datosSO"][$i]["numeroNotarioPublico"]   = "SIN INFORMACIÓN CARGADA";
            $response["datosSO"][$i]["fechaEscrituraPublica"]  = "SIN INFORMACIÓN CARGADA";
            $response["datosSO"][$i]["folioMercantil"]         = "SIN INFORMACIÓN CARGADA";
            $response["datosSO"][$i]["NumAcuerdo"]             = "SIN INFORMACIÓN CARGADA";
        }else{
            $response["datosSO"][$i]["representantelegal"]     = $infoEscrituraPublica[0]["representantelegal"];
            $response["datosSO"][$i]["administradorunico"]     = $infoEscrituraPublica[0]["administradorunico"];
            $response["datosSO"][$i]["numerodeescritura"]      = $infoEscrituraPublica[0]["numerodeescritura"];
            $response["datosSO"][$i]["nombreDelNotarioPublico"]= $infoEscrituraPublica[0]["nombreDelNotarioPublico"];
            $response["datosSO"][$i]["numeroNotarioPublico"]   = $infoEscrituraPublica[0]["numeroNotarioPublico"];
            $response["datosSO"][$i]["fechaEscrituraPublica"]  = $infoEscrituraPublica[0]["fechaEscrituraPublica"];
            $response["datosSO"][$i]["folioMercantil"]         = $infoEscrituraPublica[0]["folioMercantil"];
            $repseCompleto             = $numeroRepse[0]["NumAcuerdo"];
            $repseEdit = explode("/", $repseCompleto);
            $repseNumero=$repseEdit[3];

            $repseFin = explode("R", $repseNumero);
            $repseNumeroF=$repseFin[1];


            $response["datosSO"][$i]["NumAcuerdo"]= $repseNumeroF;

        }
        for ($k=0; $k < 2; $k++) { 
            if($k == "0"){
                if($cuatrimestre==1) {
                    $fecha    = $anio . "-02";
                    $aux      = date('Y-m-d', strtotime("{$fecha} + 1 month"));
                    $last_day = date('Y-m-d', strtotime("{$aux} -1  day"));
                    $fechaInicio1=$anioActual."-01-01";
                    $fechaFin1=$last_day;
                    if(($mes == "01" || $mes == "02") && $anio==$anioActual){    
                        $fechaFin1=date("Y-m-d");    
                    }
                    if($anio != $anioActual){
                       $fechaInicio1 = $anio."-01-01";
                    }
                    $bimestre[0] ="01";
                    $bimestre[1] ="02";
                }
                else if($cuatrimestre==2) {

                    $fecha    = $anio . "-06";
                    $aux      = date('Y-m-d', strtotime("{$fecha} + 1 month"));
                    $last_day = date('Y-m-d', strtotime("{$aux} -1  day"));
                    $fechaInicio1=$anioActual."-05-01";
                    $fechaFin1=$last_day;
                    if(($mes == "05" || $mes == "06") && $anio==$anioActual){    
                        $fechaFin1=date("Y-m-d");    
                    }
                    if($anio != $anioActual){
                       $fechaInicio1 = $anio."-05-01";
                    }
                    $bimestre[0] ="05";
                    $bimestre[1] ="06";
                }
                else if($cuatrimestre==3) {

                    $fecha    = $anio . "-10";
                    $aux      = date('Y-m-d', strtotime("{$fecha} + 1 month"));
                    $last_day = date('Y-m-d', strtotime("{$aux} -1  day"));
                    $fechaInicio1=$anioActual."-09-01";
                    $fechaFin1=$last_day;
                    if(($mes == "09" || $mes == "10") && $anio==$anioActual){    
                        $fechaFin1=date("Y-m-d");    
                    }
                    if($anio != $anioActual){
                       $fechaInicio1 = $anio."-09-01";
                    }
                    $bimestre[0] ="09";
                    $bimestre[1] ="10";
                }
            }else{
                if($cuatrimestre==1) {
                    $fecha    = $anio . "-04";
                    $aux      = date('Y-m-d', strtotime("{$fecha} + 1 month"));
                    $last_day = date('Y-m-d', strtotime("{$aux} -1  day"));
                    $fechaInicio1=$anioActual."-03-01";
                    $fechaFin1=$last_day;
                    if(($mes == "03" || $mes == "04") && $anio==$anioActual){    
                        $fechaFin1=date("Y-m-d");    
                    }
                    if($anio != $anioActual){
                       $fechaInicio1 = $anio."-03-01";
                    }
                    $bimestre[0] ="03";
                    $bimestre[1] ="04";
                }
                else if($cuatrimestre==2) {
                    $fecha    = $anio . "-08";
                    $aux      = date('Y-m-d', strtotime("{$fecha} + 1 month"));
                    $last_day = date('Y-m-d', strtotime("{$aux} -1  day"));
                    $fechaInicio1=$anioActual."-07-01";
                    $fechaFin1=$last_day;
                    if(($mes == "07" || $mes == "08") && $anio==$anioActual){    
                        $fechaFin1=date("Y-m-d");    
                    }
                    if($anio != $anioActual){
                       $fechaInicio1 = $anio."-07-01";
                    }
                    $bimestre[0] ="07";
                    $bimestre[1] ="08";
                }
                else if($cuatrimestre==3) {
                    $fecha    = $anio . "-12";
                    $aux      = date('Y-m-d', strtotime("{$fecha} + 1 month"));
                    $last_day = date('Y-m-d', strtotime("{$aux} -1  day"));
                    $fechaInicio1=$anioActual."-11-01";
                    $fechaFin1=$last_day;
                    if(($mes == "11" || $mes == "12") && $anio==$anioActual){    
                        $fechaFin1=date("Y-m-d");    
                    }
                    if($anio != $anioActual){
                       $fechaInicio1 = $anio."-11-01";
                    }
                    $bimestre[0] ="11";
                    $bimestre[1] ="12";
                }
            }
            //$log->LogInfo("Valor de la variable registro: " . var_export ($registro, true));
            // $log->LogInfo("Valor de la variable fechaInicio1: " . var_export ($fechaInicio1, true));
            // $log->LogInfo("Valor de la variable fechaFin1: " . var_export ($fechaFin1, true));
            $listaEmpleados = $negocio->negocio_obtenerEmpleadosEva($registro, $fechaInicio1, $fechaFin1);
            for($j=0;$j< count($listaEmpleados);$j++){
                $diasTranscurridos = $listaEmpleados[$j]["diasTranscurridos"];
                $salarioDiario     = $listaEmpleados[$j]["salarioDiario"];
                $empladoEntidad        = $listaEmpleados[$j]["empladoEntidadImss"];
                $empleadoConsecutivo        = $listaEmpleados[$j]["empleadoConsecutivoImss"];
                $empleadoCategoria        = $listaEmpleados[$j]["empleadoCategoriaImss"];
                // ocupamos
                $Amortizacionporempleado = $negocio->negocio_obtenerAmortizacionEmpleadosEva($empladoEntidad,$empleadoConsecutivo,$empleadoCategoria, $fechaInicio1, $fechaFin1);
               // $log->LogInfo("Valor de la variable Amortizacionporempleado: " . var_export ($Amortizacionporempleado, true));
                $empleadoId        = $listaEmpleados[$j]["numeroEmpleado"];
                $Amortizacion = $Amortizacionporempleado[0]["Amortizacion"];
                $fechaAlta         = $listaEmpleados[$j]["fechaImss"];
                $fechaBaja         = $listaEmpleados[$j]["fechaBajaImss"];
                $estatusImss       = $listaEmpleados[$j]["empleadoEstatusImss"];
                $dateAlta       = date($fechaAlta);
                $dtAlta         = new DateTime($dateAlta);
                $anioAlta       = $dtAlta->format('Y');
                $mesAlta        = $dtAlta->format('m');
                //$diacomparacion = $dtAlta->format('d');
                $dateBaja = date($fechaBaja);
                $dtBaja   = new DateTime($dateBaja);
                //$anioBaja = $dtBaja->format('Y');
                $mesBaja  = $dtBaja->format('m');
                //$diaBaja  = $dtBaja->format('d');
                $diasInfo = 0;
                $dt1         = new DateTime($fechaInicio1);
                $dt2         = new DateTime($fechaFin1);   
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
                    //$log->LogInfo("Valor dias para: " . var_export ($empleadoId, true)." ---> ". var_export ($diasInfo, true));          
                }else if ($estatusImss == '3') {
                    if(($mesAlta == $bimestre[0] || $mesAlta == $bimestre[1]) && $anioAlta==$anio){
                        $diasInfo = $dtAlta->diff($dt2);
                        $diasInfo = $diasInfo->days + 1;
                    }else{
                        $diasInfo = $dt1->diff($dt2);
                        $diasInfo = $diasInfo->days + 1;
                    }
                    //$log->LogInfo("Valor dias para: " . var_export ($empleadoId, true)." ---> ". var_export ($diasInfo, true));   
                } 
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
                $vivienda=($sdi*$diasInfo*$viviendaPatronVal)/100;
                $vivienda = round($vivienda, 2);
                if($Amortizacion=="0"){
                    $SinCredito = $SinCredito + $vivienda;
                }else{
                    $Credito = $Credito + $vivienda;
                }
                $AmortizacionTotal = $AmortizacionTotal + $Amortizacion;
            }//for j listaEmpleados

            // $log->LogInfo("Valor de la variable i: " . var_export ($i, true));
            // $log->LogInfo("Valor de la variable k: " . var_export ($k, true));
            // $log->LogInfo("Valor de la variable Credito: " . var_export ($Credito, true)); 
            // $log->LogInfo("Valor de la variable SinCredito: " . var_export ($SinCredito, true));
            // $log->LogInfo("Valor de la variable AmortizacionTotal: " . var_export ($AmortizacionTotal, true));
            $Credito1 = $Credito1 + $Credito;
            $SinCredito1 = $SinCredito1 + $SinCredito;
            $AmortizacionTotal1 = $AmortizacionTotal1 + $AmortizacionTotal;
            $Credito = 0;
            $SinCredito = 0;
            $AmortizacionTotal = 0;

        }//for k cuatrimestres
        $Credito2 = round($Credito1);
        $SinCredito2 = round($SinCredito1);
        $AmortizacionTotal2 = round($AmortizacionTotal1);

        $total_Credito2= $total_Credito2+ $Credito2;
        $total_SinCredito2= $total_SinCredito2+ $SinCredito2;
        $total_AmortizacionTotal2= $total_AmortizacionTotal2+ $AmortizacionTotal2;

        $response["datosSO"][$i]["Credito"] = $Credito2;
        $response["datosSO"][$i]["SinCredito"] = $SinCredito2;
        $response["datosSO"][$i]["AmortizacionTotal"] = $AmortizacionTotal2;
       }else{
          $response["datosSO"][$i]["rfcCliente"]= "TOTAL"; 
          $response["datosSO"][$i]["razonSocial"]= ""; 
          $response["datosSO"][$i]["correoCliente"]= ""; 
          $response["datosSO"][$i]["telefonoFijoCliente"]= ""; 
          $response["datosSO"][$i]["RegistroPatronal"]= ""; 
          $response["datosSO"][$i]["CallePrincipaCliente"]= ""; 
          $response["datosSO"][$i]["NumeroExteriorCliente"]= ""; 
          $response["datosSO"][$i]["NumeroInterirCliente"]= ""; 
          $response["datosSO"][$i]["PrimerCalleCliente"]= ""; 
          $response["datosSO"][$i]["SegundaCalleCliente"]= ""; 
          $response["datosSO"][$i]["ColoniaCliente"]= ""; 
          $response["datosSO"][$i]["CodigoPostalCliente"]= ""; 
          $response["datosSO"][$i]["MunicipioCliente"]= ""; 
          $response["datosSO"][$i]["nombreEntidadFederativa"]= ""; 
          $response["datosSO"][$i]["representantelegal"]= ""; 
          $response["datosSO"][$i]["administradorunico"]= ""; 
          $response["datosSO"][$i]["numerodeescritura"]= ""; 
          $response["datosSO"][$i]["nombreDelNotarioPublico"]= ""; 
          $response["datosSO"][$i]["numeroNotarioPublico"]= ""; 
          $response["datosSO"][$i]["fechaEscrituraPublica"]= ""; 
          $response["datosSO"][$i]["folioMercantil"]= ""; 
          $response["datosSO"][$i]["NumAcuerdo"]= ""; 
          $response["datosSO"][$i]["Credito"]= $total_Credito2; 
          $response["datosSO"][$i]["SinCredito"]= $total_SinCredito2; 
          $response["datosSO"][$i]["AmortizacionTotal"]= $total_AmortizacionTotal2; 
      }
    }//for i
    $response["status"] = "success";
    //$response["datosSO"]["infoSujetoObligado"]  = $infoSujetoObligado;
    //$response["datosSO"]["infoEscrituraPublica"]  = $infoEscrituraPublica;
    // $log->LogInfo("Valor de la variable response: " . var_export ($response, true));
}catch (Exception $e) {
    $response["mensaje"]= "Error al iniciar sesion";}
echo json_encode($response);
