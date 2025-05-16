<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "../conexion.php";
$response              = array();
$datos                 = array();
$supervisorentidad     = $_POST["supervisorentidad"]; //variables que recibo del ajax
$supervisorconsecutivo = $_POST["supervisorconsecutivo"]; //variables que recibo del ajax
$supervisortipo        = $_POST["supervisortipo"]; //variables que recibo del ajax
$sql                   = " SELECT supervisor_puntoservicio.puntoServicioId,catalogopuntosservicios.idPuntoServicio,catalogopuntosservicios.puntoServicio
                                FROM supervisor_puntoservicio
                                LEFT join catalogopuntosservicios
                                ON supervisor_puntoservicio.puntoServicioId=catalogopuntosservicios.idPuntoServicio
                                where  supervisor_puntoservicio.supervisorEntidad='$supervisorentidad'
                                and supervisor_puntoservicio.supervisorConsecutivo='$supervisorconsecutivo'
                                and supervisor_puntoservicio.supervisorTipo='$supervisortipo'
                                and  catalogopuntosservicios.esatusPunto='1' ORDER BY catalogopuntosservicios.puntoServicio ASC";
mysqli_query($conexion, "SET NAMES 'UTF8'");
$res = mysqli_query($conexion, $sql);
while ($reg = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
    $datos[] = $reg;}
$response["datos"] = $datos;
echo json_encode($response);
