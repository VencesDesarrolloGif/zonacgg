<?php

//$response = array();
//$datos    = array();
require "../conexion/conexion.php";
//require_once "../../libs/logger/KLogger.php";
$accion             = $_POST['accion'];
$descripcionentidad = $_POST['descripcionentidad'];
$porcentajeimpuesto = $_POST['porcentajeimpuesto'];
//$log    = new KLogger("ajax_actualizaSalarios.log", KLogger::DEBUG);
$a = count($descripcionentidad);
if ($accion == 1) {
    for ($i = 0; $i < count($descripcionentidad); $i++) {
        $sum = $i + 1;
        $sql = "update  porcentajeimpuestosnominas
    set descripcionEntidad='" . $descripcionentidad[$i] . "',porcentajeImpuesto='" . $porcentajeimpuesto[$i] . "'
    where idEntidad='$sum'";
        //$log->LogInfo("Valor de la variable query:  " . var_export($sql, true));
        $res = mysqli_query($conexion, $sql);
    }}

if ($accion == 2) {

    $sql = "insert into porcentajeimpuestosnominas(idEntidad, descripcionEntidad, porcentajeImpuesto) values('',  '$descripcionentidad', $porcentajeimpuesto)";
    // $log->LogInfo("Valor de la variable query:  " . var_export($sql, true));
    $res = mysqli_query($conexion, $sql);
}
echo json_encode($a);
