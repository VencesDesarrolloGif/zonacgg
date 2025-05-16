<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
// $log = new KLogger("ajaxCalculoEva.log", KLogger::DEBUG);
$response = array("status" => "success");
$mes      = date("m");
$anioActual= date("Y");
$registro=$_POST["registro"];
$anio=$_POST["anio"];
$bimestre=$_POST["bimestre"];
// $log->LogInfo("Valor de  _POST: " . var_export ($_POST, true));

$fecha    = $anio . "-" . $bimestre[1];
// $log->LogInfo("Valor dias para: fecha " . var_export ($fecha, true)); 
$aux      = date('Y-m-d', strtotime("{$fecha} + 1 month"));
// $log->LogInfo("Valor dias para: aux " . var_export ($aux, true)); 
$last_day = date('Y-m-d', strtotime("{$aux} -1  day"));
// $log->LogInfo("Valor dias para: last_day " . var_export ($last_day, true)); 
$fechaPeriodo1=$anioActual."-".$bimestre[0]."-01";
// $log->LogInfo("Valor dias para: fechaPeriodo1 " . var_export ($fechaPeriodo1, true)); 
$fechaPeriodo2=$last_day;
// $log->LogInfo("Valor dias para: fechaPeriodo2 " . var_export ($fechaPeriodo2, true)); 
if(($mes == $bimestre[0] || $mes == $bimestre[1]) && $anio==$anioActual){    
    $fechaPeriodo2=date("Y-m-d");    
}
if($anio != $anioActual){
    $fechaPeriodo1 = $anio."-".$bimestre[0]."-01";
}
// $log->LogInfo("Valor dias para: fechaPeriodo1 1" . var_export ($fechaPeriodo1, true)); 

// $log->LogInfo("Valor dias para: fechaPeriodo2 1" . var_export ($fechaPeriodo2, true)); 

$datos=array();
try {
    if($registro=="TODOS"){
        $listaregistrospatronales = $negocio->negocio_traeCatalogoRegistrosPatronales();

    for($j = 0; $j < count($listaregistrospatronales); $j++){
            $registro=$listaregistrospatronales[$j]["idcatalogoRegistrosPatronales"];
    $listaEmpleados = $negocio->negocio_obtenerEmpleadosEva($registro, $fechaPeriodo1, $fechaPeriodo2);
    $datosParaImss  = $negocio->negocio_obtenerValoresImss($anio);
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
    for($i=0;$i< count($listaEmpleados);$i++){
        $empleadoId        = $listaEmpleados[$i]["numeroEmpleado"];
        $empladoEntidad        = $listaEmpleados[$i]["empladoEntidadImss"];
        $empleadoConsecutivo        = $listaEmpleados[$i]["empleadoConsecutivoImss"];
        $empleadoCategoria        = $listaEmpleados[$i]["empleadoCategoriaImss"];
        $Amortizacionporempleado = $negocio->negocio_obtenerAmortizacionEmpleadosEva($empladoEntidad,$empleadoConsecutivo,$empleadoCategoria, $fechaPeriodo1, $fechaPeriodo2);
        $Amortizacion = $Amortizacionporempleado[0]["Amortizacion"];
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
            //$log->LogInfo("Valor dias para: " . var_export ($empleadoId, true)." ---> ". var_export ($diasInfo, true));          
        } else if ($estatusImss == '3') {
            if(($mesAlta == $bimestre[0] || $mesAlta == $bimestre[1]) && $anioAlta==$anio){
                $diasInfo = $dtAlta->diff($dt2);
                $diasInfo = $diasInfo->days + 1;
            }else{
                $diasInfo = $dt1->diff($dt2);
                $diasInfo = $diasInfo->days + 1;
            }
            //$log->LogInfo("Valor dias para: " . var_export ($empleadoId, true)." ---> ". var_export ($diasInfo, true));   
        } 
        $listaEmpleados[$i]["diasInfonavit"] = $diasInfo;

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
        $retiro=($sdi*$diasInfo*$retiroPrctVal)/100;
        $retiro = round($retiro, 2);
        $listaEmpleados[$i]["retiro"] = $retiro;
        //CESANTIA Y VEJEZ
        $cyvPatronal=($sdi*$diasInfo*$prcCyvPatronVal)/100;
        $cyvPatronal = round($cyvPatronal, 2);
        $listaEmpleados[$i]["cesantiaPat"] = $cyvPatronal;
        $cyvObrero=($sdi*$diasInfo*$prcCyvObreroVal)/100;
        $cyvObrero = round($cyvObrero, 2);
        $listaEmpleados[$i]["cesantiaObr"] = $cyvObrero;
        $suma1=$retiro+$cyvPatronal+$cyvObrero;
        $listaEmpleados[$i]["suma1"] = $suma1;
        $vivienda=($sdi*$diasInfo*$viviendaPatronVal)/100;
        $vivienda = round($vivienda, 2);
        if($Amortizacion=="0"){
            $listaEmpleados[$i]["aportacionConCredito"] = 0;
            $listaEmpleados[$i]["aportacionSinCredito"] = $vivienda;
        }else{
            $listaEmpleados[$i]["aportacionConCredito"] = $vivienda;
            $listaEmpleados[$i]["aportacionSinCredito"] = 0;
        }
       //$listaEmpleados[$i]["aportacion"] = $vivienda;
        $suma2=$vivienda + $Amortizacion;
        $listaEmpleados[$i]["suma2"] = $suma2;
        $listaEmpleados[$i]["suma3"] = round( ($suma1 + $suma2),2);
        $listaEmpleados[$i]["amortizacion"] = $Amortizacion;
        $listaEmpleados[$i]["credito"] = "";
        $listaEmpleados[$i]["movimientoCred"] = "";
        if($listaEmpleados[$i]["razonSocial"]!="CORPORATIVO GIF"){
            $listaEmpleados[$i] ["accion_movimiento"] = "<a href='javascript:nuevoMovimientoInfo(\"" . $empleadoId . "\",\"".$nss."\",\"".$registro."\");'>
                <div style='text-align: center'><img src='img/iconNuevo.png' /></div></a>";
        }else{
            $listaEmpleados[$i] ["accion_movimiento"] = "<div style='text-align: center'><img src='img/iconListo.png' /></div>";
        }
    }$datos["lista"][$j]=$listaEmpleados;
}$response["datos"]=$datos;
}else{
    $listaEmpleados = $negocio->negocio_obtenerEmpleadosEva($registro, $fechaPeriodo1, $fechaPeriodo2);
    $datosParaImss  = $negocio->negocio_obtenerValoresImss($anio);
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
    //$log->LogInfo("Valor de la variable \$last_day punto: " . var_export ($last_day, true));


    //$log->LogInfo("Valor de la variable \$last_day punto: " . var_export ($last_day, true));

    for($i=0;$i< count($listaEmpleados);$i++){
        $empleadoId        = $listaEmpleados[$i]["numeroEmpleado"];
        $empladoEntidad        = $listaEmpleados[$i]["empladoEntidadImss"];
        $empleadoConsecutivo        = $listaEmpleados[$i]["empleadoConsecutivoImss"];
        $empleadoCategoria        = $listaEmpleados[$i]["empleadoCategoriaImss"];
        $Amortizacionporempleado = $negocio->negocio_obtenerAmortizacionEmpleadosEva($empladoEntidad,$empleadoConsecutivo,$empleadoCategoria, $fechaPeriodo1, $fechaPeriodo2);
        $Amortizacion = $Amortizacionporempleado[0]["Amortizacion"];
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
            //$log->LogInfo("Valor dias para: " . var_export ($empleadoId, true)." ---> ". var_export ($diasInfo, true));          
        } else if ($estatusImss == '3') {
            if(($mesAlta == $bimestre[0] || $mesAlta == $bimestre[1]) && $anioAlta==$anio){
                $diasInfo = $dtAlta->diff($dt2);
                $diasInfo = $diasInfo->days + 1;
            }else{
                $diasInfo = $dt1->diff($dt2);
                $diasInfo = $diasInfo->days + 1;
            }
            //$log->LogInfo("Valor dias para: " . var_export ($empleadoId, true)." ---> ". var_export ($diasInfo, true));   
        } 

        $listaEmpleados[$i]["diasInfonavit"] = $diasInfo;
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

        $retiro=($sdi*$diasInfo*$retiroPrctVal)/100;
        $retiro = round($retiro, 2);
        $listaEmpleados[$i]["retiro"] = $retiro;

        //CESANTIA Y VEJEZ

        $cyvPatronal=($sdi*$diasInfo*$prcCyvPatronVal)/100;
        $cyvPatronal = round($cyvPatronal, 2);
        $listaEmpleados[$i]["cesantiaPat"] = $cyvPatronal;

        $cyvObrero=($sdi*$diasInfo*$prcCyvObreroVal)/100;
        $cyvObrero = round($cyvObrero, 2);
        $listaEmpleados[$i]["cesantiaObr"] = $cyvObrero;


        $suma1=$retiro+$cyvPatronal+$cyvObrero;
        $listaEmpleados[$i]["suma1"] = $suma1;

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

        $suma2=$vivienda + $Amortizacion;
        $listaEmpleados[$i]["suma2"] = $suma2;

        $listaEmpleados[$i]["suma3"] = round(($suma1 + $suma2),2);

        $listaEmpleados[$i]["amortizacion"] = $Amortizacion;
        $listaEmpleados[$i]["credito"] = "";
        $listaEmpleados[$i]["movimientoCred"] = "";

        if($listaEmpleados[$i]["razonSocial"]!="CORPORATIVO GIF"){
            $listaEmpleados[$i] ["accion_movimiento"] = "<a href='javascript:nuevoMovimientoInfo(\"" . $empleadoId . "\",\"".$nss."\",\"".$registro."\");'>
                <div style='text-align: center'><img src='img/iconNuevo.png' /></div></a>";
        }else{
            $listaEmpleados[$i] ["accion_movimiento"] = "<div style='text-align: center'><img src='img/iconListo.png' /></div>";
        }

    }
    $response["datosInfo"] = $listaEmpleados;
}

    

} catch (Exception $e) {
    $response["status"]  = "error";
    $response["message"] = "Error: " . $e->getMessage();
}

echo json_encode($response);
