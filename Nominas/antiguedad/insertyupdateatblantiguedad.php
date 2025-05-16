<?php

//$response = array();
//$datos    = array();
require "../conexion/conexion.php";
//require_once "../../libs/logger/KLogger.php";
$antiguedad        = $_POST['antiguedad'];
$diasvacconf       = $_POST['diasvacconf'];
$diasvacsind       = $_POST['diasvacsind'];
$porcprimaconf     = $_POST['porcprimaconf'];
$porcprimasind     = $_POST['porcprimasind'];
$diasantigconf     = $_POST['diasantigconf'];
$diasantigsind     = $_POST['diasantigsind'];
$diasaguinaldoconf = $_POST['diasaguinaldoconf'];
$diasaguinaldosind = $_POST['diasaguinaldosind'];
$accion            = $_POST['accion'];

//$log    = new KLogger("ajax_actualizaSalarios.log", KLogger::DEBUG);
if ($accion == 1) {
    for ($i = 0; $i < count($antiguedad); $i++) {
        $sum = $i + 1;
        $sql = "update  antiguedad
    set Antiguedad='" . $antiguedad[$i] . "',
    DiasVacConf='" . $diasvacconf[$i] . "',
    DiasVacSind='" . $diasvacsind[$i] . "',
    PorcPrimaConf='" . $porcprimaconf[$i] . "',
    PorcPrimaSind='" . $porcprimasind[$i] . "',
     DiasAntigConf='" . $diasantigconf[$i] . "',
     DiasAntigSind='" . $diasantigsind[$i] . "',
     DiasAguinaldoConf='" . $diasaguinaldoconf[$i] . "',
    DiasAguinaldoSind='" . $diasaguinaldosind[$i] . "'
    where IdAntiguedad='$sum'";
        //$log->LogInfo("Valor de la variable query:  " . var_export($sql, true));
        $res = mysqli_query($conexion, $sql);
    }}

if ($accion == 2) {

    $sql = "insert into antiguedad(IdAntiguedad,Antiguedad,DiasVacConf,DiasVacSind,PorcPrimaConf,PorcPrimaSind,DiasAntigConf,DiasAntigSind,DiasAguinaldoConf,DiasAguinaldoSind)
                                values('',$antiguedad,$diasvacconf,$diasvacsind,$porcprimaconf,$porcprimasind,$diasantigconf,$diasantigsind,$diasaguinaldoconf,$diasaguinaldosind)";
    // $log->LogInfo("Valor de la variable query:  " . var_export($sql, true));
    $res = mysqli_query($conexion, $sql);
}
echo json_encode($datoa);
