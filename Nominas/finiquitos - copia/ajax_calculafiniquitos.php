<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "../conexion/conexion.php";
require_once "../../libs/logger/KLogger.php";
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
$calculobruto                 = $_POST["calculobruto"];
$pagoneto                     = $_POST["pagoneto"];
$i                            = $_POST["i"];

$response           = array();
$response["status"] = "error";
$datos              = array();
try {
///////////////////////////////////////////////////////////////////////para el calculo/////////////////////////////////////////////////////////////////////////////////////////////////
    $diasdepago = $cuota * $diastrabajados;
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
    $response["message"] = "Error al iniciar sesion";}$response["status"] = "success";
$response["datos"]                                                    = $datos;
echo json_encode($response);
