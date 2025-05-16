<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "../conexion/conexion.php";
$response           = array();
$response["status"] = "error";
$datos              = array();
$accion             = $_POST["accion"];
$nombretbl          = $_POST["nombretbl"];
try {
    if ($accion == 1) {
        $sql = "SHOW TABLES FROM zonagif";
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {$datos[] = $reg;}
    } else if ($accion == 2) {
        $sql = "SHOW  COLUMNS FROM " . $nombretbl . " FROM zonagif";
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {$datos[] = $reg;}
    }
    $response["status"] = "success";
    $response["datos"]  = $datos;
} catch (Exception $e) {
    $response["message"] = "Error al iniciar sesion";
}
echo json_encode($response);
