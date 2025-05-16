<?php

//$response = array();
//$datos    = array();
require "../conexion/conexion.php";
//require_once "../../libs/logger/KLogger.php";
$accion      = $_POST['accion'];
$descripcion = $_POST['descripcion'];
$id          = $_POST['id'];
//$log    = new KLogger("ajax_actualizaSalarios.log", KLogger::DEBUG);
$a = count($descripcion);
if ($accion == 1) {
    for ($i = 0; $i < count($descripcion); $i++) {
        $sum = $i + 1;
        $sql = "update  catalogo_TipoContrato
    set numTipoContrato='" . $id[$i] . "',Descripcion='" . $descripcion[$i] . "'
    where IdTipoContrato='$sum'";

        //$log->LogInfo("Valor de la variable query:  " . var_export($sql, true));
        $res = mysqli_query($conexion, $sql);
    }}

if ($accion == 2) {

    $sql = "insert into catalogo_TipoContrato(IdTipoContrato, numTipoContrato, Descripcion)values('','$id','$descripcion')";
    // $log->LogInfo("Valor de la variable query:  " . var_export($sql, true));
    $res = mysqli_query($conexion, $sql);
}
echo json_encode($a);
