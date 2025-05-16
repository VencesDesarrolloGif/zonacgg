<?php

//$response = array();
//$datos    = array();
require "../conexion/conexion.php";
//require_once "../../libs/logger/KLogger.php";

$descripcion = $_POST['descripcion'];
$razonsocial = $_POST['razonsocial'];
$fechainicio = $_POST['fechainicio'];
$fechafin    = $_POST['fechafin'];
$id          = $_POST['id'];
$accion      = $_POST['accion'];

//$log    = new KLogger("ajax_actualizaSalarios.log", KLogger::DEBUG);

if ($accion == 1) {

    if (empty($_POST['fechafin'])) {
        $sql = "UPDATE bancos_empresa
                SET nombreBanco='$descripcion',razonSocialBanco='$razonsocial',fechaInicio='$fechainicio',fechaFin=NULL
            WHERE idCuentaBanco='$id '";
    } else {
        $sql = "UPDATE bancos_empresa
                SET nombreBanco='$descripcion',razonSocialBanco='$razonsocial',fechaInicio='$fechainicio',fechaFin='$fechafin'
            WHERE idCuentaBanco='$id'";}
    //$log->LogInfo("Valor de la variable query:  " . var_export($sql, true));
    $res = mysqli_query($conexion, $sql);
}

if ($accion == 2) {
    if (empty($_POST['fechafin'])) {
        $sql = "INSERT INTO  bancos_empresa(idCuentaBanco, nombreBanco, razonSocialBanco, fechaInicio)VALUES('$id','$descripcion','$razonsocial','$fechainicio');";
    } else {

        $sql = "INSERT INTO  bancos_empresa(idCuentaBanco, nombreBanco, razonSocialBanco, fechaInicio, fechaFin)VALUES('$id','$descripcion','$razonsocial','$fechainicio','$fechafin');";}
    // $log->LogInfo("Valor de la variable query:  " . var_export($sql, true));
    $res = mysqli_query($conexion, $sql);
}
echo json_encode($accion);
