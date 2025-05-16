<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajaxConsultaPlantilla.log" , KLogger::DEBUG );
$response = array("status" => "success");
$mesPost=$_POST["mes"];
$anioPost=$_POST["anio"];
$mes      = date("m");
$anio     = date("Y");
$fecha    = $anioPost . "-" . $mesPost;
$aux      = date('Y-m-d', strtotime("{$fecha} + 1 month"));
$last_day = date('Y-m-d', strtotime("{$aux} -1  day"));
if($mes==$mesPost && $anio==$anioPost){
    $last_day=date('Y-m-d');
}
$dtLast       = new DateTime($last_day);
$mesConsulta  = $dtLast->format('m');
$anioConsulta = $dtLast->format('Y');
$diasDelMes   = $dtLast->format('d');
$fechaPeriodo1 = $anioConsulta . "-" . $mesConsulta . "-01";
$fechaPeriodo2 = $last_day;
try{
	$idCliente=getValueFromPost ("idCliente");	
	//$log->LogInfo("Valor de la variable \$idCliente: " . var_export ($idCliente, true));
	$datosParaImss  = $negocio->negocio_obtenerValoresImss($anioConsulta);
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
    $lista= $negocio -> getEmpleadosClienteEntidad($idCliente,$fechaPeriodo1,$fechaPeriodo2);
    for($i=0;$i< count($lista);$i++){
      $entidad=$lista[$i]["entidadFederativaId"];
      $consecutivo=$lista[$i]["empleadoConsecutivoId"];
      $categoria=$lista[$i]["empleadoCategoriaId"];
      $registro=$lista[$i]["registroPatronal"];
      $determinate=$lista[$i]["numeroCentroCosto"];    
      $arraydeterminante=explode('-',$determinate);
  //$log->LogInfo("Valor de la variable \$arraydeterminante: en la posocion".$i . var_export (count($arraydeterminante), true));
      if(count($arraydeterminante)==1 || count($arraydeterminante)==0 ){
        $arraydeterminante[1]="SIN ASIGNAR";
    }else{
       $arraydeterminante[1]= $arraydeterminante[1];
       $arraydeterminante[0]= $arraydeterminante[0];
   } 
   $lista[$i]["determinante"]=$arraydeterminante[1];  
   $lista[$i]["formatodet"]=$arraydeterminante[0];                                
   $fechaAlta         = $lista[$i]["fechaImss"];
   $fechaBaja         = $lista[$i]["fechaBajaImss"];
   $salarioDiario     = $lista[$i]["salarioDiario"];
   $estatusImss       = $lista[$i]["empleadoEstatusImss"];
   $diasTranscurridos = $lista[$i]["diasTranscurridos"];
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
   $valorPrimaRT= $negocio->negocio_obtenerPrimaRTEmpleado($registro,$mesConsulta,$anioConsulta);
   if ($estatusImss == '7') {
    if ($mesConsulta == $mesAlta && $anioConsulta==$anioBaja && $anioConsulta==$anioAlta) {
        $diasImss = $dtAlta->diff($dtBaja);
        $diasImss = $diasImss->days + 1;
    } else {
        $diasImss = $diaBaja;
    }
} else if ($estatusImss == '3') {
    if ($mesConsulta == $mesAlta && $anioAlta==$anioConsulta && $anioConsulta==$anioBaja) {
        $diasImss = $dtAlta->diff($dtLast);
        $diasImss = $diasImss->days + 1;
    } else {
        $diasImss = $diasDelMes;
    }
}

if ($diasTranscurridos <= 365) {
    $primaVacacional = 1.5;

} elseif ($diasTranscurridos >= 366 and $diasTranscurridos <= 730) {

    $primaVacacional = 2;

} elseif ($diasTranscurridos >= 731 and $diasTranscurridos <= 1095) {

    $primaVacacional = 2.5;
} elseif ($diasTranscurridos >= 1096 and $diasTranscurridos <= 1460) {

    $primaVacacional = 3;

} elseif ($diasTranscurridos >= 1461 and $diasTranscurridos <= 1825) {

    $primaVacacional = 3.5;

} elseif ($diasTranscurridos >= 1826 and $diasTranscurridos <= 3650) {

    $primaVacacional = 3.5;

} elseif ($diasTranscurridos >= 1827 and $diasTranscurridos <= 5475) {

    $primaVacacional = 4;
}

$factorIntegracion = $unidad + ($primaVacacional / 365) + $aguinaldo;
$sdi               = $factorIntegracion * $salarioDiario;
$sdi = bcdiv($sdi, '1', 2);

$incapacidades     = '0';
$ausentismos       = '0';


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
$subTotal=$sumaPatronal+$sumaObrera;

$lista[$i]["subtotalEma"] = $subTotal;



$lista[$i]["accion_datos"]="<a href='javascript:mostrarHojaDeDatos(\"" . $entidad . "\",\"" . $consecutivo . "\",\"" . $categoria . "\");'><img src='img/hojaDatos.png' title='Ver'/></a>";
}
$response["data"]= $lista;
	//$log->LogInfo("Valor de la variable \$lista: " . var_export ($response, true));

} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener consulta";
}

echo json_encode($response);
