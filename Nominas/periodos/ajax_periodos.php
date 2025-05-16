<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();

require "../conexion/conexion.php";

$response  = array();
$datos     = array();
$idperiodo = $_POST['idperiodo'];

if ($idperiodo == 0) {
    $sql = "SELECT *
            from  periodos ";} else {
    $sql = "SELECT *
            from  aniosperiodos
            where IdPeriodo='$idperiodo'";

}

$res = mysqli_query($conexion, $sql);

while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {

    $datos[] = $reg;
}
$response["datos"] = $datos;

echo json_encode($response);
