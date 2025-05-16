<?php

//$response = array();
//$datos    = array();
require "../conexion/conexion.php";
//require_once "../../libs/logger/KLogger.php";
$accion     = $_POST['accion'];
$aniouma    = $_POST['aniouma'];
$diariouma  = $_POST['diariouma'];
$mensualuma = $_POST['mensualuma'];
$anualuma   = $_POST['anualuma'];

//$log    = new KLogger("ajax_actualizaSalarios.log", KLogger::DEBUG);
if ($accion == 1) {
    for ($i = 0; $i < count($aniouma); $i++) {
        $sum = $i + 1;
        $sql = "update  uma
    set anioUma='" . $aniouma[$i] . "',diarioUma='" . $diariouma[$i] . "',mensualUma='" . $mensualuma[$i] . "',anualUma='" . $anualuma[$i] . "'
    where idUma='$sum'";
        //$log->LogInfo("Valor de la variable query:  " . var_export($sql, true));
        $res = mysqli_query($conexion, $sql);
    }}

if ($accion == 2) {

    $sql = "insert into uma(idUma, anioUma, diarioUma, mensualUma, anualUma) values('',  '$aniouma', $diariouma,$mensualuma, $anualuma)";
    // $log->LogInfo("Valor de la variable query:  " . var_export($sql, true));
    $res = mysqli_query($conexion, $sql);
}
echo json_encode($aniouma);
