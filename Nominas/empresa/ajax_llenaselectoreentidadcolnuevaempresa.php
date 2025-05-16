<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "../conexion/conexion.php";

$response               = array();
$datos                  = array();
$datossubdelegacionimss = array();

$cp     = $_POST['cp'];
$accion = $_POST['accion'];
if ($accion == 1) {
    $sql0 = "SELECT *
    FROM asentamientos
        LEFT JOIN catalogomunicipios
        ON asentamientos.municipioAsentamiento=catalogomunicipios.idMunicipio
        left join entidadesfederativas
        ON catalogomunicipios.idEstado=entidadesfederativas.idEntidadFederativa
        where asentamientos.codigoPostalAsentamiento='$cp'";
    $ressql0 = mysqli_query($conexion, $sql0);
    while (($reg = mysqli_fetch_array($ressql0, MYSQLI_ASSOC))) {
        $datos[] = $reg;}

}

if ($accion == 2) {
    $sql0 = "SELECT *
    FROM asentamientos
        LEFT JOIN catalogomunicipios
        ON asentamientos.municipioAsentamiento=catalogomunicipios.idMunicipio
        left join entidadesfederativas
        ON catalogomunicipios.idEstado=entidadesfederativas.idEntidadFederativa
        where asentamientos.codigoPostalAsentamiento='$cp'";
    $ressql0 = mysqli_query($conexion, $sql0);
    while (($reg = mysqli_fetch_array($ressql0, MYSQLI_ASSOC))) {
        $datos[] = $reg;}
    if (count($datos) == 0) {$identidadfederativa = 0;} else {
        $identidadfederativa = $datos[0]["idEntidadFederativa"];}

    $sql1 = "SELECT * FROM subdelegacionesimss
    where idEntidadFederativa = '$identidadfederativa'";
    $ressql1 = mysqli_query($conexion, $sql1);
    while (($reg = mysqli_fetch_array($ressql1, MYSQLI_ASSOC))) {
        $datossubdelegacionimss[] = $reg;}
    $response["datossubdelegacionimss"] = $datossubdelegacionimss;
}

$response["datos"] = $datos;
//$response["cppppp"]        = $cp;
echo json_encode($response);
