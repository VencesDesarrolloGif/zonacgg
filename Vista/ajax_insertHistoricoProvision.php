<?php
session_start();
require "conexion.php"; 
require_once("../libs/logger/KLogger.php");
$log = new KLogger ( "ajax_insertHistoricoProvision.log" , KLogger::DEBUG );
$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
$response= array();

$anio= $_POST['anio'];
$mes = $_POST['mes'];
$fechaInicioPeriodo = $_POST['fechaInicioPeriodo'];
$fechaTerminoPeriodo = $_POST['fechaTerminoPeriodo'];

$arreglo = $_POST['tableCalculoProvision'];
// $log->LogInfo("Valor de la variable arreglo: " . var_export ($arreglo, true));
// $log->LogInfo("Valor de la variable count: " . var_export (count($arreglo), true));

try{
    for($i=0; $i <25; $i++) { 
    // for($i=0; $i <count($arreglo); $i++) { 
// $log->LogInfo("Valor de la variable i: " . var_export ($i, true));
        $registrosP= $arreglo[$i]['registrosP'];
// $log->LogInfo("Valor de la variable registrosP: " . var_export ($registrosP, true));
        $diasImssTotalSumaT= $arreglo[$i]['diasImssTotalSumaT'];
        $sdiTotalSumaT= $arreglo[$i]['sdiTotalSumaT'];
        $incapacidadesTotalSumaT= $arreglo[$i]['incapacidadesTotalSumaT'];
        $ausentismosTotalSumaT= $arreglo[$i]['ausentismosTotalSumaT'];
        $cuotaFijaTotalSumaT= $arreglo[$i]['cuotaFijaTotalSumaT'];
        $excPatronTotalSumaT= $arreglo[$i]['excPatronTotalSumaT'];
        $excObreroTotalSumaT= $arreglo[$i]['excObreroTotalSumaT'];
        $prestDinPatronTotalSumaT= $arreglo[$i]['prestDinPatronTotalSumaT'];
        $prestDinObreroTotalSumaT= $arreglo[$i]['prestDinObreroTotalSumaT'];
        $gastosMedicosPatronTotalSumaT= $arreglo[$i]['gastosMedicosPatronTotalSumaT'];
        $gastosMedicosObreroTotalSumaT= $arreglo[$i]['gastosMedicosObreroTotalSumaT'];
        $riesgoTrabajoTotalSumaT= $arreglo[$i]['riesgoTrabajoTotalSumaT'];
        $invYvPatronTotalSumaT= $arreglo[$i]['invYvPatronTotalSumaT'];
        $invYvObreroTotalSumaT= $arreglo[$i]['invYvObreroTotalSumaT'];
        $guarderiasYPenTotalSumaT= $arreglo[$i]['guarderiasYPenTotalSumaT'];
        $sumaPatronalTotalSumaT= $arreglo[$i]['sumaPatronalTotalSumaT'];
        $sumaObreraTotalSumaT= $arreglo[$i]['sumaObreraTotalSumaT'];
        $subTotalTotalSumaT= $arreglo[$i]['subTotalTotalSumaT'];
        $diasInfonavitTotalEBA= $arreglo[$i]['diasInfonavitTotalEBA'];
        $sdiTotalEBA= $arreglo[$i]['sdiTotalEBA'];
        $incapacidadesTotalEBA= $arreglo[$i]['incapacidadesTotalEBA'];
        $ausentismosTotalEBA= $arreglo[$i]['ausentismosTotalEBA'];
        $retiroTotalEBA= $arreglo[$i]['retiroTotalEBA'];
        $cesantiaPatTotalEBA= $arreglo[$i]['cesantiaPatTotalEBA'];
        $cesantiaObrTotalEBA= $arreglo[$i]['cesantiaObrTotalEBA'];
        $suma1TotalEBA= $arreglo[$i]['suma1TotalEBA'];
        $aportacionConCreditoTotalEBA= $arreglo[$i]['aportacionConCreditoTotalEBA'];
        $aportacionSinCreditoTotalEBA= $arreglo[$i]['aportacionSinCreditoTotalEBA'];
        $amortizacionTotalEBA= $arreglo[$i]['amortizacionTotalEBA'];
        $suma2TotalEBA= $arreglo[$i]['suma2TotalEBA'];
        $sumaTotalAmbasEbas= $arreglo[$i]['sumaTotalAmbasEbas'];
        $neto= $arreglo[$i]['neto'];
    
        $sql = "INSERT INTO historico_Provision(registroPatronalHP,anioProvision,mesProvision,inicioPeriodo,finPeriodo,díasImss,sdiEMA,incapacidadEMA,ausentismosEMA,cuotaFija,excedentePatronal,excedenteObrera,prestacionPatronal,prestacionObrera,gastosMedicosPatronal,gastosMedicosObrera,riesgoTrabajoEMA,invalidezYvidaPatEMA,invalidezYvidaObrEMA,guarderiasYpension,sumaEMApatronal,sumaEMAobrera,subtotalEMA,díasEBA,sdiEBA,incEBA,ausEBA,retiroEBA,cesantiaYvejezEBAPat,cesantiaYvejezEBAobr,sumaEBA1,aportacionPatronalEBACredito,aportacionPatronalEBAsinCredito,amortizacionEBA,sumaEBA2,sumaTotalEBA,neto,fechaGuardado) VALUES('$registrosP','$anio','$mes','$fechaInicioPeriodo','$fechaTerminoPeriodo','$diasImssTotalSumaT','$sdiTotalSumaT','$incapacidadesTotalSumaT','$ausentismosTotalSumaT','$cuotaFijaTotalSumaT','$excPatronTotalSumaT','$excObreroTotalSumaT','$prestDinPatronTotalSumaT','$prestDinObreroTotalSumaT','$gastosMedicosPatronTotalSumaT','$gastosMedicosObreroTotalSumaT','$riesgoTrabajoTotalSumaT','$invYvPatronTotalSumaT','$invYvObreroTotalSumaT','$guarderiasYPenTotalSumaT','$sumaPatronalTotalSumaT','$sumaObreraTotalSumaT','$subTotalTotalSumaT','$diasInfonavitTotalEBA','$sdiTotalEBA','$incapacidadesTotalEBA','$ausentismosTotalEBA','$retiroTotalEBA','$cesantiaPatTotalEBA','$cesantiaObrTotalEBA','$suma1TotalEBA','$aportacionConCreditoTotalEBA','$aportacionSinCreditoTotalEBA','$amortizacionTotalEBA','$suma2TotalEBA','$sumaTotalAmbasEbas','$neto',now())"; 
    
        $res = mysqli_query($conexion, $sql);
        // $log->LogInfo("Valor de la consulta $sql: " . var_export ($sql, true));
    }//for
    $response["status"]  = "success";
} catch (Exception $e) {
    $response["status"]  = "error";
    $response["message"] = $e->getMessage();
}
echo json_encode($response);