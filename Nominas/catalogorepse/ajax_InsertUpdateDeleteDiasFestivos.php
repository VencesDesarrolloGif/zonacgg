<?php
require "../conexion/conexion.php";
require_once "../../libs/logger/KLogger.php";
$accion    = $_POST['accion'];
$FechaDiaF = $_POST['fechaDiaF'];
$MotivoDiaF= $_POST['motivoDiaF'];

if ($accion == 1) {
$fechaDiaFAnterior = $_POST['fechaDiaFAnterior'];
$motivoDiaFAnterior= $_POST['motivoDiaFAnterior'];

    for ($i = 0; $i < count($FechaDiaF); $i++) {
        $sum = $i + 1;
        $sql = "update  diasfestivos
                set fechaDiaFestivo='" . $FechaDiaF[$i] . "',motivoDiaFestivo='" . $MotivoDiaF[$i] . "'
                where fechaDiaFestivo = '$fechaDiaFAnterior[$i]'
                and motivoDiaFestivo = '$motivoDiaFAnterior[$i]'"; 
        $res = mysqli_query($conexion, $sql);
    }}

if ($accion == 2) {
    $sql = "insert into diasfestivos(fechaDiaFestivo, motivoDiaFestivo) values('" . $FechaDiaF . "' , '" . $MotivoDiaF . "')";
    $res = mysqli_query($conexion, $sql);
}