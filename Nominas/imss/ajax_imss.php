<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();

require "../conexion/conexion.php";

$response           = array();
$response["status"] = "error";
$datos              = array();

try {

    $sql = "SELECT *
            from  imss ";

    $res = mysqli_query($conexion, $sql);

    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {

        $datos[] = $reg;
    }
    $response["status"] = "success";
    $response["datos"]  = $datos;

} catch (Exception $e) {

    $response["message"] = "Error al iniciar sesion";

}

echo json_encode($response);
