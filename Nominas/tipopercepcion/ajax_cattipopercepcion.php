<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();

require "../conexion/conexion.php";

$response           = array();
$response["status"] = "error";
$datos              = array();
$accion             = $_POST["accion"];

try {
    if ($accion == 2) {
        $sql = "SELECT *,ifnull(importeTotalTP,'Agregar formula') importeTotalTP,ifnull(grabadoISRTP,'Agregar formula') grabadoISRTP
                        ,ifnull(grabadoISRTP,'Agregar formula') grabadoISRTP,ifnull(excentoISRTP,'Agregar formula') excentoISRTP
                        ,ifnull(grabadoIMSSTP,'Agregar formula') grabadoIMSSTP,ifnull(excentoIMSSTP,'Agregar formula') excentoIMSSTP
                from  catalogo_TipoPercepcion ctp
                left join catalogo_TipoPercepcionsat ctps
                on ctp.IdTipoPercepcionSat=ctps.IdTipoPercepcionSat";}
    if ($accion == 0 || $accion == 1) {
        $sql = "SELECT *
            from  catalogo_TipoPercepcionsat";
    }

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
