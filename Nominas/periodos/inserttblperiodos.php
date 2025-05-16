<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "../conexion/conexion.php";
require_once "../../libs/logger/KLogger.php";
$response                = array();
$datos                   = array();
$descripcion             = $_POST['descripcion'];
$inicioderango           = $_POST['inicioderango'];
$diaspago                = $_POST['diaspago'];
$seldescripcionperiodonu = $_POST['seldescripcionperiodonu'];
//$log           = new KLogger("ajax_inserttblperiodos.log", KLogger::DEBUG);
$anio           = date($inicioderango);
$anioinsert     = new DateTime($anio);
$anioinsertsolo = $anioinsert->format('Y');
$mescomparacion = $anioinsert->format('m');
$diacomparacion = $anioinsert->format('d');
/*if ($mescomparacion == '01' && $diacomparacion == '01') {
$response["status"] = "success";
} else {
$response["status"] = "notsuccess";
}*/
if ($diaspago == 15) {
    $iteracion = 24;
} else {
    $iteracion = 52;
}
if ($seldescripcionperiodonu == 0) {
    $sql          = "INSERT INTO periodos(IdPeriodo, Descripcion) VALUES(NULL,'$descripcion');";
    $ressql       = mysqli_query($conexion, $sql);
    $sqlselect    = "SELECT max(IdPeriodo) as IdPeriodo FROM periodos;";
    $ressqlselect = mysqli_query($conexion, $sqlselect);
    if (($reg = mysqli_fetch_array($ressqlselect, MYSQLI_ASSOC))) {
        $IdPeriodo = $reg["IdPeriodo"];
    }
    $sql2    = "INSERT INTO aniosperiodos(IdPeriodo, IdAnio, DescAnio, DiasPago)VALUES($IdPeriodo,NULL,$anioinsertsolo,$diaspago);";
    $ressql2 = mysqli_query($conexion, $sql2);
} else if ($seldescripcionperiodonu != 0 && $seldescripcionperiodonu != (-2)) {
    $sql2    = "INSERT INTO aniosperiodos(IdPeriodo, IdAnio, DescAnio, DiasPago)VALUES($seldescripcionperiodonu,NULL,$anioinsertsolo,$diaspago);";
    $ressql2 = mysqli_query($conexion, $sql2);
} else if ($seldescripcionperiodonu == (-2)) {
    $sqlsel = "SELECT max(IdPeriodo) as IdPeriodo FROM periodos
where IdPeriodo=$seldescripcionperiodonu ;";
    $ressqlsel = mysqli_query($conexion, $sqlsel);
    if (($regextra = mysqli_fetch_array($ressqlsel, MYSQLI_ASSOC))) {
        $IdPeriodo = $regextra["IdPeriodo"];
    }
    if ($IdPeriodo == null || $IdPeriodo == 0) {
        $sqlextra = "INSERT INTO periodos(IdPeriodo, Descripcion) VALUES('$seldescripcionperiodonu','$descripcion');";
        $ressql   = mysqli_query($conexion, $sqlextra);
    }
    $sqlselectextra = "SELECT max(IdPeriodo) as IdPeriodo FROM periodos
    where IdPeriodo=$seldescripcionperiodonu ;";
    $ressqlselectextra = mysqli_query($conexion, $sqlselectextra);
    if (($regextra = mysqli_fetch_array($ressqlselectextra, MYSQLI_ASSOC))) {
        $IdPeriodo = $regextra["IdPeriodo"];
    }

    $sqlconextra = "INSERT INTO aniosperiodos(IdPeriodo, IdAnio, DescAnio, DiasPago)VALUES($IdPeriodo,NULL,$anioinsertsolo,'$diaspago');";
    $resconextra = mysqli_query($conexion, $sqlconextra);

    $sqlselect2extra = "SELECT max(IdAnio) IdAnio from aniosperiodos;";
    $sqlselect2extr  = mysqli_query($conexion, $sqlselect2extra);
    if (($regg = mysqli_fetch_array($sqlselect2extr, MYSQLI_ASSOC))) {
        $IdAnio = $regg["IdAnio"];
    }
    $sql4extra    = "INSERT INTO rangoperiodos(IdAnio, IdRango, FechaInicioP, FechaFinP)VALUES($IdAnio,NULL,'$inicioderango','$inicioderango');";
    $ressql4extra = mysqli_query($conexion, $sql4extra);

}

if ($seldescripcionperiodonu != (-2)) {

    $sqlselect2  = "SELECT max(IdAnio) IdAnio from aniosperiodos;";
    $sqlselectt2 = mysqli_query($conexion, $sqlselect2);
    if (($regg = mysqli_fetch_array($sqlselectt2, MYSQLI_ASSOC))) {
        $IdAnio = $regg["IdAnio"];
    }

    $fecha = date($inicioderango);
    $fechs = $anioinsertsolo;
//for ($i = 1; $anioinsertsolo == $fechs; $i++) { bucle comparando el año
    for ($i = 1; $i <= $iteracion; $i++) {
        //bucle tomando en cuenta la iteracion
        $nuevafecha = strtotime('+' . ($diaspago - 1) . ' day', strtotime($fecha)); //suma los dias a la fecha
        $nuevafecha = date('Y-m-d', $nuevafecha);
        if ($i % 2 == 0 && $mescomparacion == '01' && $diacomparacion == '01' && $diaspago == 15) {
            $mesFecha       = new DateTime($fecha);
            $mes            = $mesFecha->format('m');
            $first_of_month = mktime(0, 0, 0, $mes, 1, $anioinsertsolo);
            $maxdays        = date('t', $first_of_month);
            $fecharmada     = $anioinsertsolo . '-' . $mes . '-' . $maxdays;
            $nuevafecha     = $fecharmada;
        }
        $sql4       = "INSERT INTO rangoperiodos(IdAnio, IdRango, FechaInicioP, FechaFinP)VALUES($IdAnio,NULL,'$fecha','$nuevafecha');";
        $ressql4    = mysqli_query($conexion, $sql4);
        $nuevafecha = strtotime('+' . (1) . ' day', strtotime($nuevafecha));
        $nuevafecha = date('Y-m-d', $nuevafecha);
        $fech       = new DateTime($nuevafecha);
        $fechs      = $fech->format('Y');
        $fecha      = $nuevafecha;
    }}
$response["status"] = "success";
echo json_encode($seldescripcionperiodonu);
