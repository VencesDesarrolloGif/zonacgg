<?php

//$response = array();
//$datos    = array();
require "../conexion/conexion.php";
//require_once "../../libs/logger/KLogger.php";
$accion            = $_POST['accion'];
$paraingresos      = $_POST['paraingresos'];
$hastaingresos     = $_POST['hastaingresos'];
$cantidadsubsidios = $_POST['cantidadsubsidios'];
//$sobreexcedente = $_POST['sobreexcedente'];
//$log    = new KLogger("ajax_actualizaSalarios.log", KLogger::DEBUG);
if ($accion == 1) {
    for ($i = 0; $i < count($paraingresos); $i++) {
        $sum = $i + 1;
        $sql = "update  subsidiomensual
    set ParaIngMen='" . $paraingresos[$i] . "',HasIngMen='" . $hastaingresos[$i] . "',cantSubsidioMensual='" . $cantidadsubsidios[$i] . "'
    where idSubsidioMensual='$sum'";
        //$log->LogInfo("Valor de la variable query:  " . var_export($sql, true));
        $res = mysqli_query($conexion, $sql);
    }}

if ($accion == 2) {

    $sql = "insert into subsidiomensual(idSubsidioMensual, ParaIngMen, HasIngMen, cantSubsidioMensual) values('',  '$paraingresos', $hastaingresos,$cantidadsubsidios)";
    // $log->LogInfo("Valor de la variable query:  " . var_export($sql, true));
    $res = mysqli_query($conexion, $sql);
}
echo json_encode($sum);
