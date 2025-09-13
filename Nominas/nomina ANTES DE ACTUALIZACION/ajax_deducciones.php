<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();

require "../conexion/conexion.php";

$response = array();
$datos    = array();
$tipo     = $_POST['tipo'];
if ($tipo == 1) {
    //percepcion
    $sql = "SELECT * from  catalogo_tipopercepcion";

} else if ($tipo == 2) {
    //deduccion
    $sql = "SELECT * from  catalogo_tipodeduccion";
}
$res = mysqli_query($conexion, $sql);

while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {

    $datos[] = $reg;
}
$response["datos"] = $datos;

echo json_encode($response);
