<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "../conexion.php";
$response = array();
//$response ["status"] = "error";
$inprol              = $_SESSION["userLog"]["usuario"]; //variables que recibo del ajax
$accion              = $_POST["accion"];
$datos               = array();
$accion              = $_POST["accion"];
$fechainiciobusqueda = $_POST["fechainiciobusqueda"];
$fechafinbusqueda    = $_POST["fechafinbusqueda"];
//$fechainicio = $_POST["fechainicio"];
//$fechafin    = $_POST["fechafin"];
$archivo = "../Vista/img/checkAsistencia.png";

if ($accion == 1) {

    $qry = mysqli_query($conexion, "SELECT concat_ws('-',asistencias_administrativos.entidadEmpleadoAdmin,asistencias_administrativos.consecutivoEmpleadoAdmin,asistencias_administrativos.categoriaEmpleadoAdmin)as numeroempleado,
        concat_ws(' ',empleados.apellidoPaterno,empleados.apellidoMaterno,empleados.nombreEmpleado) as nombreempleado,
        ifnull(asistencias_administrativos.horaEntrada,'N/A')as horaEntrada,ifnull(asistencias_administrativos.salidaComer,'N/A')as salidaComer,
        ifnull(asistencias_administrativos.regresoComer,'N/A')as regresoComer,ifnull(asistencias_administrativos.salidaTurno,'N/A')as salidaTurno,
        asistencias_administrativos.fechaAsistencia,asistencias_administrativos.CalifOficinas,catalogopuntosservicios.puntoServicio,
        catalogopuestos.descripcionPuesto,
IF(asistencias_administrativos.horaEntrada IS NULL or asistencias_administrativos.salidaComer IS NULL or asistencias_administrativos.regresoComer IS NULL or asistencias_administrativos.salidaTurno IS NULL,'FALTA', 'ASISTENCIA') AS faltaoasis
    FROM  asistencias_administrativos
 LEFT JOIN catalogopuntosservicios
ON catalogopuntosservicios.idPuntoServicio=asistencias_administrativos.idPuntoServicioAsistencia
left join  empleados
on empleados.entidadFederativaId=asistencias_administrativos.entidadEmpleadoAdmin
and empleados.empleadoConsecutivoId=asistencias_administrativos.consecutivoEmpleadoAdmin
and empleados.empleadoCategoriaId=asistencias_administrativos.categoriaEmpleadoAdmin
left join catalogopuestos
on empleados.empleadoIdPuesto=catalogopuestos.idPuesto");
}  

if ($accion == 2) {
    $qry = mysqli_query($conexion, "SELECT concat_ws('-',asistencias_administrativos.entidadEmpleadoAdmin,asistencias_administrativos.consecutivoEmpleadoAdmin,asistencias_administrativos.categoriaEmpleadoAdmin)as numeroempleado,
concat_ws(' ',empleados.apellidoPaterno,empleados.apellidoMaterno,empleados.nombreEmpleado) as nombreempleado,
ifnull(asistencias_administrativos.horaEntrada,'N/A')as horaEntrada,ifnull(asistencias_administrativos.salidaComer,'N/A')as salidaComer,
ifnull(asistencias_administrativos.regresoComer,'N/A')as regresoComer,ifnull(asistencias_administrativos.salidaTurno,'N/A')as salidaTurno,
asistencias_administrativos.fechaAsistencia,asistencias_administrativos.CalifOficinas,catalogopuntosservicios.puntoServicio,
catalogopuestos.descripcionPuesto,
IF(asistencias_administrativos.horaEntrada IS NULL or asistencias_administrativos.salidaComer IS NULL or asistencias_administrativos.regresoComer IS NULL or asistencias_administrativos.salidaTurno IS NULL,'FALTA', 'ASISTENCIA') AS faltaoasis
FROM  asistencias_administrativos
LEFT JOIN catalogopuntosservicios
ON catalogopuntosservicios.idPuntoServicio=asistencias_administrativos.idPuntoServicioAsistencia
left join  empleados
on empleados.entidadFederativaId=asistencias_administrativos.entidadEmpleadoAdmin
and empleados.empleadoConsecutivoId=asistencias_administrativos.consecutivoEmpleadoAdmin
and empleados.empleadoCategoriaId=asistencias_administrativos.categoriaEmpleadoAdmin
left join catalogopuestos
on empleados.empleadoIdPuesto=catalogopuestos.idPuesto
where fechaAsistencia between '$fechainiciobusqueda' and '$fechafinbusqueda'");

}

$i = 0;
while (($regg = mysqli_fetch_array($qry, MYSQLI_ASSOC))) {
    $datos[] = $regg;

    $datos[$i]["detallemodal"] = "<a href='javascript:mostrarModalAsistenciaadministrativos( \"" . $datos[$i]["numeroempleado"] . "\",\"" . $datos[$i]["fechaAsistencia"] . "\" );'><img style='heigth:30%; width:30%; margin-left:34%' src='" . $archivo . "'></a>";

    $i++;
}

$response["datos"] = $datos;
echo json_encode($response);
