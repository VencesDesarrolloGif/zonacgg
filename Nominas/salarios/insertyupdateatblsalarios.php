<?php

//$response = array();
//$datos    = array();
require "../conexion/conexion.php";
//require_once "../../libs/logger/KLogger.php";
$accion = $_POST['accion'];
$fecha  = $_POST['fecha'];
$datoa  = $_POST['datoa'];
$datob  = $_POST['datob'];
$datoc  = $_POST['datoc'];
//$log    = new KLogger("ajax_actualizaSalarios.log", KLogger::DEBUG);
if ($accion == 1) {
    for ($i = 0; $i < count($fecha); $i++) {
        $sum = $i +1;
        $sql = "update  tblsalarios
    set fechaInicio='" . $fecha[$i] . "',sAreaA='" . $datoa[$i] . "',sAreaB='" . $datob[$i] . "',sAreaC='" . $datoc[$i] . "'
    where idSalarios='$sum'";
        //$log->LogInfo("Valor de la variable query:  " . var_export($sql, true));
        $res = mysqli_query($conexion, $sql);
    }}

if ($accion == 2) {

    $sql = "insert into tblsalarios(idSalarios, fechaInicio, sAreaA, sAreaB, sAreaC) values(null,  '$fecha', $datoa,$datob, $datoc)";
    // $log->LogInfo("Valor de la variable query:  " . var_export($sql, true));
    $res = mysqli_query($conexion, $sql);
}
echo json_encode($datoa);
