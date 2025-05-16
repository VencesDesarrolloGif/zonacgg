<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "conexion.php";
$response = array();
//$response ["status"] = "error";
$inprol      = $_SESSION["userLog"]["usuario"]; //variables que recibo del ajax
$accion      = $_POST["accion"];
$datos       = array();
$accion      = $_POST["accion"];
$fechainicio = $_POST["fechainicio"];
$fechafin    = $_POST["fechafin"];
$archivo     = "../Vista/img/checkAsistencia.png";
if ($accion == 1) {
    $qry = mysqli_query($conexion, "SELECT  concat(asistencias_guardias.entidadEmpleado,'-',asistencias_guardias.consecutivoEmpleado,'-',asistencias_guardias.categoriaEmpleado) numeroempleado,
        catalogopuntosservicios.puntoServicio,concat(empleados.apellidoPaterno,' ',empleados.apellidoMaterno,' ',empleados.nombreEmpleado) nombre,catalogopuestos.descripcionPuesto,
        asistencias_guardias.idTurno,ifnull(asistencias_guardias.horaEntrada,'N.A') as horaEntrada ,
        ifnull(asistencias_guardias.salidaComer,'N.A')AS salidaComer,ifnull(asistencias_guardias.regresoComer,'N.A') as regresoComer,
        ifnull(asistencias_guardias.salidaTurno,'N.A') as salidaTurno,asistencias_guardias.fechaAsistencia
FROM asistencias_guardias
LEFT JOIN catalogopuntosservicios
ON catalogopuntosservicios.idPuntoServicio=asistencias_guardias.idPuntoServicioAsistencia
left join  empleados
on empleados.entidadFederativaId=asistencias_guardias.entidadEmpleado
and empleados.empleadoConsecutivoId=asistencias_guardias.consecutivoEmpleado
and empleados.empleadoCategoriaId=asistencias_guardias.categoriaEmpleado
left join catalogopuestos
on empleados.empleadoIdPuesto=catalogopuestos.idPuesto
where catalogopuntosservicios.esatusPunto=1
order by esatusPunto desc");}
if ($accion == 2) {
    $qry = mysqli_query($conexion, "SELECT  concat(asistencias_guardias.entidadEmpleado,'-',asistencias_guardias.consecutivoEmpleado,'-',asistencias_guardias.categoriaEmpleado) numeroempleado,
        catalogopuntosservicios.puntoServicio,concat(empleados.apellidoPaterno,' ',empleados.apellidoMaterno,' ',empleados.nombreEmpleado) nombre,catalogopuestos.descripcionPuesto,
        asistencias_guardias.idTurno,ifnull(asistencias_guardias.horaEntrada,'N.A') as horaEntrada ,
        ifnull(asistencias_guardias.salidaComer,'N.A')AS salidaComer,ifnull(asistencias_guardias.regresoComer,'N.A') as regresoComer,
        ifnull(asistencias_guardias.salidaTurno,'N.A') as salidaTurno,asistencias_guardias.fechaAsistencia
FROM asistencias_guardias
LEFT JOIN catalogopuntosservicios
ON catalogopuntosservicios.idPuntoServicio=asistencias_guardias.idPuntoServicioAsistencia
left join  empleados
on empleados.entidadFederativaId=asistencias_guardias.entidadEmpleado
and empleados.empleadoConsecutivoId=asistencias_guardias.consecutivoEmpleado
and empleados.empleadoCategoriaId=asistencias_guardias.categoriaEmpleado
left join catalogopuestos
on empleados.empleadoIdPuesto=catalogopuestos.idPuesto

where catalogopuntosservicios.esatusPunto=1
and fechaAsistencia between '$fechainicio' and '$fechafin'
order by esatusPunto desc");
}

if ($accion == 3) {

    $sql = "SELECT * FROM usuario_empleado
            where usuario='$inprol'";
    mysqli_query($conexion, "SET NAMES 'UTF8'");
    $res = mysqli_query($conexion, $sql);
    if ($reg = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
        $entidad     = $reg["entidadEmpleadoUsuario"];
        $consecutivo = $reg["consecutivoEmpleadoUsuario"];
        $categoria   = $reg["categoriaEmpleadoUsuario"];}
    $qry = mysqli_query($conexion, " SELECT  concat(asistencias_guardias.entidadEmpleado,'-',asistencias_guardias.consecutivoEmpleado,'-',asistencias_guardias.categoriaEmpleado) numeroempleado,
        catalogopuntosservicios.puntoServicio,concat(empleados.apellidoPaterno,' ',empleados.apellidoMaterno,' ',empleados.nombreEmpleado) nombre,catalogopuestos.descripcionPuesto,
        asistencias_guardias.idTurno,ifnull(asistencias_guardias.horaEntrada,'N.A') as horaEntrada ,
        ifnull(asistencias_guardias.salidaComer,'N.A')AS salidaComer,ifnull(asistencias_guardias.regresoComer,'N.A') as regresoComer,
        ifnull(asistencias_guardias.salidaTurno,'N.A') as salidaTurno,asistencias_guardias.fechaAsistencia
                                        FROM asistencias_guardias
                                        LEFT join supervisor_puntoservicio
                                        on supervisor_puntoservicio.puntoServicioId=asistencias_guardias.idPuntoServicioAsistencia
                                        left join catalogopuntosservicios
                                        ON supervisor_puntoservicio.puntoServicioId=catalogopuntosservicios.idPuntoServicio
                                        left join  empleados
                                        on empleados.entidadFederativaId=asistencias_guardias.entidadEmpleado
                                        and empleados.empleadoConsecutivoId=asistencias_guardias.consecutivoEmpleado
                                        and empleados.empleadoCategoriaId=asistencias_guardias.categoriaEmpleado
                                        left join catalogopuestos
                                        on empleados.empleadoIdPuesto=catalogopuestos.idPuesto
                                        where  supervisor_puntoservicio.supervisorEntidad='$entidad'
                                        and supervisor_puntoservicio.supervisorConsecutivo='$consecutivo'
                                        and supervisor_puntoservicio.supervisorTipo='$categoria'
                                        and  catalogopuntosservicios.esatusPunto='1'");

}

if ($accion == 4) {
    $sql = "SELECT * FROM usuario_empleado
            where usuario='$inprol'";
    mysqli_query($conexion, "SET NAMES 'UTF8'");
    $res = mysqli_query($conexion, $sql);
    if ($reg = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
        $entidad     = $reg["entidadEmpleadoUsuario"];
        $consecutivo = $reg["consecutivoEmpleadoUsuario"];
        $categoria   = $reg["categoriaEmpleadoUsuario"];}
    $qry = mysqli_query($conexion, " SELECT  concat(asistencias_guardias.entidadEmpleado,'-',asistencias_guardias.consecutivoEmpleado,'-',asistencias_guardias.categoriaEmpleado) numeroempleado,
        catalogopuntosservicios.puntoServicio,concat(empleados.apellidoPaterno,' ',empleados.apellidoMaterno,' ',empleados.nombreEmpleado) nombre,catalogopuestos.descripcionPuesto,
        asistencias_guardias.idTurno,ifnull(asistencias_guardias.horaEntrada,'N.A') as horaEntrada ,
        ifnull(asistencias_guardias.salidaComer,'N.A')AS salidaComer,ifnull(asistencias_guardias.regresoComer,'N.A') as regresoComer,
        ifnull(asistencias_guardias.salidaTurno,'N.A') as salidaTurno,asistencias_guardias.fechaAsistencia
                                        FROM asistencias_guardias
                                        LEFT join supervisor_puntoservicio
                                        on supervisor_puntoservicio.puntoServicioId=asistencias_guardias.idPuntoServicioAsistencia
                                        left join catalogopuntosservicios
                                        ON supervisor_puntoservicio.puntoServicioId=catalogopuntosservicios.idPuntoServicio
                                        left join  empleados
                                        on empleados.entidadFederativaId=asistencias_guardias.entidadEmpleado
                                        and empleados.empleadoConsecutivoId=asistencias_guardias.consecutivoEmpleado
                                        and empleados.empleadoCategoriaId=asistencias_guardias.categoriaEmpleado
                                        left join catalogopuestos
                                        on empleados.empleadoIdPuesto=catalogopuestos.idPuesto
                                        where  supervisor_puntoservicio.supervisorEntidad='$entidad'
                                        and supervisor_puntoservicio.supervisorConsecutivo='$consecutivo'
                                        and supervisor_puntoservicio.supervisorTipo='$categoria'
                                        and  catalogopuntosservicios.esatusPunto='1'
                                        and fechaAsistencia between '$fechainicio' and '$fechafin'");
}
while (($regg = mysqli_fetch_array($qry, MYSQLI_ASSOC))) {

    $datos[] = $regg;}
for ($i = 0; $i < count($datos); $i++) {
    $numeroempleadoguardia         = $datos[$i]["numeroempleado"];
    $datos[$i]["fotoguardiamodal"] = "<a href='javascript:mostrarModalfotoguardia(\"" . $numeroempleadoguardia . "\");'><img style='heigth:30%; width:30%; margin-left:34%' src='" . $archivo . "'></a>";
}

$response["datos"] = $datos;
echo json_encode($response);
