<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();

require "../conexion/conexion.php";

$response      = array();
$datos         = array();
$iddescripcion = $_POST['iddescripcion'];

if ($iddescripcion == 0) {
    $sql = "SELECT '0' as IdPeriodo,'Nueva descripción' as Descripcion
				union
                select '-2' as IdPeriodo, 'EXTRAORDINARIO' AS Descripcion
                UNION
SELECT IdPeriodo, Descripcion
				 FROM periodos";}

$res = mysqli_query($conexion, $sql);

while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {

    $datos[] = $reg;
}

$response["datos"] = $datos;

echo json_encode($response);
