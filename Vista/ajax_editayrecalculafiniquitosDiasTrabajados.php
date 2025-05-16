<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio ();
// $log = new KLogger("ajax_EditarFiniquitoDiasTRabajados.log", KLogger::DEBUG);

// $log->LogInfo("Valor de la variable post:  " . var_export($_POST, true));

$entidadempleado              = $_POST["entidadempleado"];
$consecutivoemp               = $_POST["consecutivoemp"];
$categoriaemp                 = $_POST["categoriaemp"];
$cuota                        = $_POST["cuota"];
$diastrabajados               = $_POST["diastrabajados"];
$salarioDiario                = $_POST["salarioDiario"];
$calculobruto1                = $_POST["calculoBruto"];
$pagonetosa1                  = $_POST["pagoNetoSA"];
$ingresoacumulablesa1         = $_POST["ingresoAcumulableSA"];

$sd                           = $salarioDiario;
$response                     = array();
$response["status"]           = "error";
$datos                        = array();

try {
///////////////////////////////////////////////////////////////////////para el calculo/////////////////////////////////////////////////////////////////////////////////////////////////
    $diasdepago   = ($cuota * $diastrabajados);
    $calculobruto = ($calculobruto1 + $diasdepago);
    $pagoneto     = $calculobruto;
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////para el calculo de S.A/////////////////////////////////////////////////////////////////////////////////////////////////
    $diaspagosa                = ($sd * $diastrabajados);
    $pagonetosa                = ($pagonetosa1 + $diaspagosa);
    $diferenciagratificacionsa = ($calculobruto - $pagonetosa);
    $ingresoacumulablesa       = ($ingresoacumulablesa1 + $diaspagosa + $diferenciagratificacionsa);
    ////////////////////////////////////////////////////////////////QUERY QUE SACA EL LIMITEINFERIOR Y SUPERIOR PARA EL CALCULO S.A//////////////////////////////////////////////////////////////////////////////

    $datosqryrangolimitesisr = $negocio -> obtenerisrmensual($ingresoacumulablesa);

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
    $negocio -> UpdateFiniquitosDiasTrabajados($diasdepago,$calculobruto,$pagoneto,$diaspagosa,$pagonetosa,$diferenciagratificacionsa,$ingresoacumulablesa,$limiteinferior,$excedenteLimitesa,$sobreexcedenteliminferior,$resultado,$cuotaqryfloat,$isr,$netoalpago,$entidadempleado,$consecutivoemp,$categoriaemp);
//$log->LogInfo("Valor de la variable qry:  " . var_export($datos, true));
    //$response["datos"]  = $datos;
} catch (Exception $e) {
    $response["message"] = "Error al iniciar sesion";}

$response["status"] = "success";

$response["datos"] = $datos;
echo json_encode($response);
