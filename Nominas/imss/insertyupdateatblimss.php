<?php

//$response = array();
//$datos    = array();
require "../conexion/conexion.php";
require_once "../../libs/logger/KLogger.php";

$descripcion         = $_POST['descripcion'];
$tipo                = $_POST['tipo'];
$patron              = $_POST['patron'];
$obrero              = $_POST['obrero'];
$total               = $_POST['total'];
$basecalculo         = $_POST['basecalculo'];
$marconormativididad = $_POST['marconormativididad'];
$accion              = $_POST['accion'];
//$log                 = new KLogger("ajax_imss.log", KLogger::DEBUG);
if ($accion == 1) {
    for ($i = 0; $i < 2; $i++) {
        $sum = $i + 1;
        $sql = "update  imss
    set descripcion='" . $descripcion[$i] . "',Tipo=' " . $tipo[$i] . "',Patron=' " . $patron[$i] . "',Obrero=' " . $obrero[$i] . "',Total=' " . $total[$i] . "'
    ,BaseCalculo=' " . $basecalculo[$i] . "',MarcoNormat=' " . $marconormativididad[$i] . "'
    where idConcepto='$sum'";
        //$log->LogInfo("Valor de la variable query:  " . var_export($descripcion, true));
        $res = mysqli_query($conexion, $sql);

    }
}

if ($accion == 2) {

    $sql = "insert into imss(idConcepto, descripcion, Tipo, Patron, Obrero, Total, BaseCalculo, MarcoNormat) values('','$descripcion', '$tipo','$patron', '$obrero','$total',
    '$basecalculo','$marconormativididad')";
    // $log->LogInfo("Valor de la variable query:  " . var_export($sql, true));
    $res = mysqli_query($conexion, $sql);
}
//$S = count($descripcion);
echo json_encode($descripcion);
