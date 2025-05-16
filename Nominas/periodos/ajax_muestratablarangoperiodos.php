<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();

require "../conexion/conexion.php";

$response    = array();
$datos       = array();
$anioperiodo = $_POST['anioperiodo'];

if ($anioperiodo != 0) {
    $sql = "SELECT *
            from  rangoperiodos
            where IdAnio='$anioperiodo'";}
$res = mysqli_query($conexion, $sql);

while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {

    $datos[] = $reg;
}
$response["datos"] = $datos;

echo json_encode($response);
