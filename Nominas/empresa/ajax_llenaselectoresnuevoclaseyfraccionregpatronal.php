<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "../conexion/conexion.php";

$response    = array();
$datos       = array();
$datosriesgo = array();

$accion   = $_POST['accion'];
$idriesgo = $_POST['idriesgo'];

if ($accion == 0) {
    $sql0    = "SELECT * FROM tablacuotariesgos";
    $ressql0 = mysqli_query($conexion, $sql0);
    while (($reg = mysqli_fetch_array($ressql0, MYSQLI_ASSOC))) {
        $datos[] = $reg;}
    $response["datos"] = $datos;}

if ($accion == 1) {
    $sql1 = "SELECT * FROM fracciongiro
where idRiesgo='$idriesgo'";
    $ressql1 = mysqli_query($conexion, $sql1);
    while (($reg = mysqli_fetch_array($ressql1, MYSQLI_ASSOC))) {
        $datosriesgo[] = $reg;}
    $response["datosriesgo"] = $datosriesgo;
}

//$response["cppppp"]        = $cp;
echo json_encode($response);
