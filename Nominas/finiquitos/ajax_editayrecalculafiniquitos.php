<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "../conexion/conexion.php";
require_once "../../libs/logger/KLogger.php";
   // $log = new KLogger("ajax_EditarFiniquito.log", KLogger::DEBUG);

//$log->LogInfo("Valor de la variable qry:  " . var_export($_POST, true));

$entidadempleado              = $_POST["entidadempleado"];
$consecutivoemp               = $_POST["consecutivoemp"];
$categoriaemp                 = $_POST["categoriaemp"];
$fechaingresoimss             = $_POST["fechaingresoimss"];
$fechabajaimss                = $_POST["fechabajaimss"];
$prestamo                     = $_POST["prestamo"];
$infonavit                    = $_POST["infonavit"];
$fonacot                      = $_POST["fonacot"];
$cuota                        = $_POST["cuota"];
$diastrabajados               = $_POST["diastrabajados"];
$separacion                   = $_POST["separacion"];
$piramidar                    = $_POST["piramidar"];
$antiguedadtotal              = $_POST["antiguedadtotal"];
$diasparappdevacaciones       = $_POST["diasparappdevacaciones"];
$diasdevacaciones             = $_POST["diasdevacaciones"];
$factorproporciondevacaciones = $_POST["factorproporciondevacaciones"];
$calculodiasdeaguinaldo       = $_POST["calculodiasdeaguinaldo"];
$diasdeaguinaldo              = $_POST["diasdeaguinaldo"];
$proporciondevacaciones       = $_POST["proporciondevacaciones"];
$primavacacionalneta          = $_POST["primavacacionalneta"];
$proporcionnetaaguinaldo      = $_POST["proporcionnetaaguinaldo"];
$diasdepago                   = $_POST["diasdepago"];
$aumentoengratificacion       = $_POST["aumentoengratificacion"];
$calculobruto1                 = $_POST["calculobruto"];
$pagoneto                     = $_POST["pagoneto"];
$proporcionvacacionessa       = $_POST["proporcionvacacionessa"];
$primavacacionalsa            = $_POST["primavacacionalsa"];
$propaguinaldosa              = $_POST["propaguinaldosa"];
$diaspagosa                   = $_POST["diaspagosa"];
$pagonetosa1                   = $_POST["pagonetosa"];
//$diferenciagratificacionsa    = $_POST["diferenciagratificacionsa"];
$ingresoacumulablesa1          = $_POST["ingresoacumulablesa"];
$limiteinferiorisr            = $_POST["limiteinferiorisr"];
$excedenteLimitesa            = $_POST["excedenteLimitesa"];
$tasaaplicable                = $_POST["tasaaplicable"];
$resultado                    = $_POST["resultado"];
$cuotafija                    = $_POST["cuotafija"];
$isr                          = $_POST["isr"];
$primavacacionespendientes    = $_POST["primavacacionespendientes"];
$PpPrimaVacacionalPendiente1  = $_POST["PpPrimaVacacionalPendiente1"];
$pension                      = $_POST["pension"];
$salarioDiario                = $_POST["salarioDiario"];

$i                            = $_POST["i"];
//$sd                           = 90.50;
$response                     = array();
$response["status"]           = "error";
$datos                        = array();



try {
///////////////////////////////////////////////////////////////////////para el calculo/////////////////////////////////////////////////////////////////////////////////////////////////
    $diasdepago   = ($cuota * $diastrabajados);
    $calculobruto = ($proporciondevacaciones +$primavacacionalneta +$proporcionnetaaguinaldo +$diasdepago +$aumentoengratificacion +$primavacacionespendientes +$PpPrimaVacacionalPendiente1);

    //$calculobruto = ($calculobruto1 + $aumentoengratificacion );
    //$pagoneto     = ($calculobruto + $separacion );
    $pagoneto     = ($calculobruto - $prestamo - $infonavit - $fonacot - $pension + $separacion);

    $pagoneto                = ($calculobruto - $prestamo - $infonavit - $fonacot - $separacion - $montopension);//deducciones
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////para el calculo de S.A/////////////////////////////////////////////////////////////////////////////////////////////////
   // $diaspagosa                = ($salarioDiario * $diastrabajados);
    
    //$diaspagosa                = ($sd * $diastrabajados);
    $pagonetosa                = ($pagonetosa1);
    $diferenciagratificacionsa = ($calculobruto - $pagonetosa);
    $ingresoacumulablesa       = ($proporcionvacacionessa + $propaguinaldosa + $diaspagosa + $diferenciagratificacionsa);
    ////////////////////////////////////////////////////////////////QUERY QUE SACA EL LIMITEINFERIOR Y SUPERIOR PARA EL CALCULO S.A//////////////////////////////////////////////////////////////////////////////



    $qryrangodelimiteinferior = "SELECT * FROM isrmensual
                                        where  $ingresoacumulablesa >=limiteInferior  and   $ingresoacumulablesa<=limiteSuperior";
    $resqryrangolim          = mysqli_query($conexion, $qryrangodelimiteinferior);
    $datosqryrangolimitesisr = array();
    while (($regqry = mysqli_fetch_array($resqryrangolim, MYSQLI_ASSOC))) {
        $datosqryrangolimitesisr[] = $regqry;}
    $limiteinferior            = $datosqryrangolimitesisr[0]["limiteInferior"];
    $limitesuperior            = $datosqryrangolimitesisr[0]["limiteSuperior"];
    $sobreexcedenteliminferior = $datosqryrangolimitesisr[0]["sobreExcedenteLimInferior"];
    $cuotafijaqry              = $datosqryrangolimitesisr[0]["cuotaFija"];
    $cuotaqryfloat             = (float) $cuotafijaqry;
    ////////////////////////////////////////////////////////////CONTINUAN CALCULOS S.A///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $excedenteLimitesa = ($ingresoacumulablesa - $limiteinferior);
    $resultado2        = (($excedenteLimitesa * $sobreexcedenteliminferior) / 100);
    $resultadoo        = bcdiv($resultado2, 1, 2);
    $resultado         = (float) $resultadoo;
    $isrsa             = ($resultado + $cuotaqryfloat);
    $isr               = round($isrsa, 0);
    $netoalpagosa      = ($pagoneto - $isr);
    $netoalpago        = round($netoalpagosa, 0);
    ////SIGUE EL UPDATE
    $sql = "UPDATE finiquitos
            SET separacion='$separacion',diasDePago='$diasdepago',
                aumentoGratificacion='$aumentoengratificacion', calculoBruto='$calculobruto', pagoNeto='$pagoneto',pagoNetoSA='$pagonetosa',diferenciaGratificacionSA='$diferenciagratificacionsa',ingresoAcumulableSA='$ingresoacumulablesa',limiteInferiorisr='$limiteinferior',excedenteLimiteSA='$excedenteLimitesa',tasaAplicable='$sobreexcedenteliminferior',resultado='$resultado',cuotaFija='$cuotaqryfloat',isr='$isr',netoAlPago='$netoalpago'
            WHERE entidadEmpFiniquito='$entidadempleado'
            AND consecutivoEmpFiniquito='$consecutivoemp'
            AND categoriaEmpFiniquito='$categoriaemp'
            and estatusFiniquito=0";
    $res                                         = mysqli_query($conexion, $sql);
    $datos["datos"]["numempleado"]               = "$entidadempleado-$consecutivoemp-  . $categoriaemp";
    $datos["datos"]["diastrabenlaquincena"]      = "<input class='input-mini' id='diastrabajadosenrangodelaultimaquincenaint" . $i . "' value='" . $diastrabajados . "'readonly>";
    $datos["datos"]["PRIMAVACACAIONALNETA"]      = "<input class='input-mini' id='primavacacionalnetaredondeada" . $i . "'  value='" . $primavacacionalneta . "'readonly>";
    $datos["datos"]["PROPORCIONNETADEAGUINALDO"] = "<input class='input-mini' id='proporcionnetaaguinaldo" . $i . "' value='" . $proporcionnetaaguinaldo . "'readonly>";
    $datos["datos"]["aumentoengratificacion"]    = "<input class='input-mini' id='aumentoengratificacion" . $i . "' value='" . $aumentoengratificacion . "'readonly>";
    $datos["datos"]["CALCULODIASAGUINALDO"]      = "<input class='input-mini' id='calculodiasaguinaldo" . $i . "'  value='" . $calculodiasdeaguinaldo . "'readonly>";
    $datos["datos"]["DiasVacConf"]               = "<input class='input-mini' id='diasdevacaciones" . $i . "'  value='" . $diasdevacaciones . "'readonly>";
    $datos["datos"]["fechaImss"]                 = "$fechaingresoimss";
    $datos["datos"]["proporcion_de_vacaciones"]  = "<input class='input-mini' id='propdevaccpnvert" . $i . "'  value='" . $proporciondevacaciones . "'readonly>";
    $datos["datos"]["DIASAGUINALDO"]             = "<input class='input-mini' id='diasdeaguinaldo" . $i . "'   value='" . $diasdeaguinaldo . "'readonly> ";
    $datos["datos"]["antiguedadtotal"]           = "<input class='input-mini' id='antiguedadtotal" . $i . "' value='" . $antiguedadtotal . "'readonly>";
    $datos["datos"]["fechaBajaImss"]             = "$fechabajaimss";
    $datos["datos"]["diastrabajados"]            = "<input class='input-mini' id='diastrabajados" . $i . "'  value='" . $diastrabajados . "'readonly>";
    $datos["datos"]["propdevacaciones"]          = "<input class='input-mini' id='propvacaciones" . $i . "'  value='" . $factorproporciondevacaciones . "'readonly>";
    $datos["datos"]["calculobruto"]              = "<input class='input-mini' id='calculobruto" . $i . "' value='" . $calculobruto . "'readonly>";
    $datos["datos"]["diasdepago"]                = "<input class='input-mini' id='diasdepago" . $i . "' value='" . $diasdepago . "'readonly>";
    $datos["datos"]["separacion"]                = "<input class='input-mini' id='separacion" . $i . "' value='" . $separacion . "'readonly>";
    $datos["datos"]["infonavit"]                 = "<input class='input-mini' id='infonavit" . $i . "' value='" . $infonavit . "'readonly>";
    $datos["datos"]["cuotaPagadaTurno"]          = "<input class='input-mini' id='cuotaint" . $i . "'  value='" . $cuota . "'readonly>";
    $datos["datos"]["prestamo"]                  = "<input class='input-mini' id='prestamo" . $i . "' value='" . $prestamo . "'readonly>";
    $datos["datos"]["pagoneto"]                  = "<input class='input-mini' id='pagoneto" . $i . "' value='" . $pagoneto . "'readonly>";
    $datos["datos"]["fonacot"]                   = "<input class='input-mini' id='fonacot" . $i . "' value='" . $fonacot . "'readonly>";
//$log->LogInfo("Valor de la variable qry:  " . var_export($datos, true));
    //$response["datos"]  = $datos;
} catch (Exception $e) {
    $response["message"] = "Error al iniciar sesion";}

$response["status"] = "success";

$response["datos"] = $datos;
echo json_encode($response);
