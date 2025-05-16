<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "conexion.php";
$response = array();
//$response ["status"] = "error";
$datos           = array();
$idpuntoservicio = $_POST["idpuntoservicio"]; //variables que recibo del ajax
$qry             = mysqli_query($conexion, "SELECT  concat(asistencias_guardias.entidadEmpleado,'-',asistencias_guardias.consecutivoEmpleado,'-',asistencias_guardias.categoriaEmpleado) numeroempleado,
        concat(empleados.apellidoPaterno,' ',empleados.apellidoMaterno,' ',empleados.nombreEmpleado) nombre,catalogopuestos.descripcionPuesto,
        asistencias_guardias.contadorTurno,ifnull(asistencias_guardias.horaEntrada,'N.A') as horaEntrada ,ifnull(asistencias_guardias.salidaComer,'N.A')AS salidaComer,ifnull(asistencias_guardias.regresoComer,'N.A') as regresoComer,ifnull(asistencias_guardias.salidaTurno,'N.A') as salidaTurno,asistencias_guardias.fechaAsistencia
FROM asistencias_guardias
left join  empleados
on empleados.entidadFederativaId=asistencias_guardias.entidadEmpleado
and empleados.empleadoConsecutivoId=asistencias_guardias.consecutivoEmpleado
and empleados.empleadoCategoriaId=asistencias_guardias.categoriaEmpleado
left join catalogopuestos
on empleados.empleadoIdPuesto=catalogopuestos.idPuesto
where asistencias_guardias.idPuntoServicioAsistencia='$idpuntoservicio'");
while (($regg = mysqli_fetch_array($qry, MYSQLI_ASSOC))) {

    $datos[] = $regg;}

$response["datos"] = $datos;
echo json_encode($response);
