<?php

//$response = array();
//$datos    = array();
require "../conexion/conexion.php";
//require_once "../../libs/logger/KLogger.php";
$accion         = $_POST['accion'];
$limiteinferior = $_POST['limiteinferior'];
$limitesuperior = $_POST['limitesuperior'];
$cuotafija      = $_POST['cuotafija'];
$sobreexcedente = $_POST['sobreexcedente'];
//$log    = new KLogger("ajax_actualizaSalarios.log", KLogger::DEBUG);
if ($accion == 1) {
    for ($i = 0; $i < count($limiteinferior); $i++) {
        $sum = $i + 1;
        $sql = "update  isrmensual
    set limiteInferior='" . $limiteinferior[$i] . "',limiteSuperior='" . $limitesuperior[$i] . "',cuotaFija='" . $cuotafija[$i] . "',sobreExcedenteLimInferior='" . $sobreexcedente[$i] . "'
    where idIsr='$sum'";
        //$log->LogInfo("Valor de la variable query:  " . var_export($sql, true));
        $res = mysqli_query($conexion, $sql);
    }}

if ($accion == 2) {

    $sql = "insert into isrmensual(idIsr, limiteInferior, limiteSuperior, cuotaFija, sobreExcedenteLimInferior) values('',  '$limiteinferior', $limitesuperior,$cuotafija, $sobreexcedente)";
    // $log->LogInfo("Valor de la variable query:  " . var_export($sql, true));
    $res = mysqli_query($conexion, $sql);
}
echo json_encode($datoa);
