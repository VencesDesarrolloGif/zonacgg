<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "../conexion.php";
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
    $qry = mysqli_query($conexion, "SELECT  asistencia_supervisor.idSupervision,asistencia_supervisor.idPuntoServicioAsistencia,
    										concat(asistencia_supervisor.entidadSupervisor,'-',asistencia_supervisor.consecutivoSupervisor,'-',asistencia_supervisor.categoriaSupervisor) AS numeroempleadosupervisor,
											catalogopuntosservicios.puntoServicio,concat(empleados.apellidoPaterno,' ',empleados.apellidoMaterno,' ',empleados.nombreEmpleado) AS nombresupervisor,
											catalogopuestos.descripcionPuesto,ifnull( asistencia_supervisor.horaEntradaSupervisor,'N.A') as horaEntradasupervision ,
											ifnull(asistencia_supervisor.salidaSupervisor,'N.A')AS salidasupervision,ifnull(asistencia_supervisor.fechaAsistenciaSupervisor,'N.A') AS fechaasistenciasupervision
									FROM asistencia_supervisor
									LEFT JOIN catalogopuntosservicios
									ON catalogopuntosservicios.idPuntoServicio=asistencia_supervisor.idPuntoServicioAsistencia
									left join  empleados
									on empleados.entidadFederativaId=asistencia_supervisor.entidadSupervisor
									and empleados.empleadoConsecutivoId=asistencia_supervisor.consecutivoSupervisor
									and empleados.empleadoCategoriaId=asistencia_supervisor.categoriaSupervisor
									left join catalogopuestos
									on empleados.empleadoIdPuesto=catalogopuestos.idPuesto
									where catalogopuntosservicios.esatusPunto=1
									order by asistencia_supervisor.fechaAsistenciaSupervisor  desc");
}

if ($accion == 2) {
    $qry = mysqli_query($conexion, "SELECT  asistencia_supervisor.idSupervision,asistencia_supervisor.idPuntoServicioAsistencia,
    										concat(asistencia_supervisor.entidadSupervisor,'-',asistencia_supervisor.consecutivoSupervisor,'-',asistencia_supervisor.categoriaSupervisor) AS numeroempleadosupervisor,
											catalogopuntosservicios.puntoServicio,concat(empleados.apellidoPaterno,' ',empleados.apellidoMaterno,' ',empleados.nombreEmpleado) AS nombresupervisor,
											catalogopuestos.descripcionPuesto,ifnull( asistencia_supervisor.horaEntradaSupervisor,'N.A') as horaEntradasupervision ,
											ifnull(asistencia_supervisor.salidaSupervisor,'N.A') AS salidasupervision,ifnull(asistencia_supervisor.fechaAsistenciaSupervisor,'N.A') AS fechaasistenciasupervision
									FROM asistencia_supervisor
									LEFT JOIN catalogopuntosservicios
									ON catalogopuntosservicios.idPuntoServicio=asistencia_supervisor.idPuntoServicioAsistencia
									left join  empleados
									on empleados.entidadFederativaId=asistencia_supervisor.entidadSupervisor
									and empleados.empleadoConsecutivoId=asistencia_supervisor.consecutivoSupervisor
									and empleados.empleadoCategoriaId=asistencia_supervisor.categoriaSupervisor
									left join catalogopuestos
									on empleados.empleadoIdPuesto=catalogopuestos.idPuesto
									where catalogopuntosservicios.esatusPunto=1
									and asistencia_supervisor.fechaAsistenciaSupervisor between '$fechainicio' AND '$fechafin '
									order by asistencia_supervisor.fechaAsistenciaSupervisor  desc");
}
if ($accion == 3) {
    $sql = "SELECT * FROM usuario_empleado
            where usuario='$inprol'";
    mysqli_query($conexion, "SET NAMES 'UTF8'");
    $res = mysqli_query($conexion, $sql);
    while ($reg = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
        $entidad     = $reg["entidadEmpleadoUsuario"];
        $consecutivo = $reg["consecutivoEmpleadoUsuario"];
        $categoria   = $reg["categoriaEmpleadoUsuario"];}
    $qry = mysqli_query($conexion, "SELECT asistencia_supervisor.idSupervision,asistencia_supervisor.idPuntoServicioAsistencia,
    										concat(asistencia_supervisor.entidadSupervisor,'-',asistencia_supervisor.consecutivoSupervisor,'-',asistencia_supervisor.categoriaSupervisor) AS numeroempleadosupervisor,
											catalogopuntosservicios.puntoServicio,concat(empleados.apellidoPaterno,' ',empleados.apellidoMaterno,' ',empleados.nombreEmpleado) AS nombresupervisor,
											catalogopuestos.descripcionPuesto,ifnull( asistencia_supervisor.horaEntradaSupervisor,'N.A') as horaEntradasupervision ,
											ifnull(asistencia_supervisor.salidaSupervisor,'N.A')AS salidasupervision,ifnull(asistencia_supervisor.fechaAsistenciaSupervisor,'N.A') AS fechaasistenciasupervision
									FROM asistencia_supervisor
									LEFT JOIN catalogopuntosservicios
									ON catalogopuntosservicios.idPuntoServicio=asistencia_supervisor.idPuntoServicioAsistencia
									left join  empleados
									on empleados.entidadFederativaId=asistencia_supervisor.entidadSupervisor
									and empleados.empleadoConsecutivoId=asistencia_supervisor.consecutivoSupervisor
									and empleados.empleadoCategoriaId=asistencia_supervisor.categoriaSupervisor
									left join catalogopuestos
									on empleados.empleadoIdPuesto=catalogopuestos.idPuesto
									where catalogopuntosservicios.esatusPunto=1
									and  asistencia_supervisor.entidadSupervisor='$entidad'
									and asistencia_supervisor.consecutivoSupervisor='$consecutivo'
									and asistencia_supervisor.categoriaSupervisor='$categoria'
									order by asistencia_supervisor.fechaAsistenciaSupervisor  desc");
}
if ($accion == 4) {
    $sql = "SELECT * FROM usuario_empleado
            where usuario='$inprol'";
    $res = mysqli_query($conexion, $sql);
    while ($reg = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
        $entidad     = $reg["entidadEmpleadoUsuario"];
        $consecutivo = $reg["consecutivoEmpleadoUsuario"];
        $categoria   = $reg["categoriaEmpleadoUsuario"];}
    $qry = mysqli_query($conexion, "SELECT asistencia_supervisor.idSupervision,asistencia_supervisor.idPuntoServicioAsistencia,
    										concat(asistencia_supervisor.entidadSupervisor,'-',asistencia_supervisor.consecutivoSupervisor,'-',asistencia_supervisor.categoriaSupervisor) AS numeroempleadosupervisor,
											catalogopuntosservicios.puntoServicio,concat(empleados.apellidoPaterno,' ',empleados.apellidoMaterno,' ',empleados.nombreEmpleado) AS nombresupervisor,
											catalogopuestos.descripcionPuesto,ifnull( asistencia_supervisor.horaEntradaSupervisor,'N.A') as horaEntradasupervision ,
											ifnull(asistencia_supervisor.salidaSupervisor,'N.A')AS salidasupervision,ifnull(asistencia_supervisor.fechaAsistenciaSupervisor,'N.A') AS fechaasistenciasupervision
									FROM asistencia_supervisor
									LEFT JOIN catalogopuntosservicios
									ON catalogopuntosservicios.idPuntoServicio=asistencia_supervisor.idPuntoServicioAsistencia
									left join  empleados
									on empleados.entidadFederativaId=asistencia_supervisor.entidadSupervisor
									and empleados.empleadoConsecutivoId=asistencia_supervisor.consecutivoSupervisor
									and empleados.empleadoCategoriaId=asistencia_supervisor.categoriaSupervisor
									left join catalogopuestos
									on empleados.empleadoIdPuesto=catalogopuestos.idPuesto
									where catalogopuntosservicios.esatusPunto=1
									and  asistencia_supervisor.entidadSupervisor='$entidad'
									and asistencia_supervisor.consecutivoSupervisor='$consecutivo'
									and asistencia_supervisor.categoriaSupervisor='$categoria'
									and asistencia_supervisor.fechaAsistenciaSupervisor between '$fechainicio' AND '$fechafin '
									order by asistencia_supervisor.fechaAsistenciaSupervisor  desc");
}
while (($regg = mysqli_fetch_array($qry, MYSQLI_ASSOC))) {
    $datos[] = $regg;}
for ($i = 0; $i < count($datos); $i++) {
    $idsup                      = $datos[$i]["idSupervision"];
    $fechaasistenciasupervision = $datos[$i]["fechaasistenciasupervision"];
    $numeroempleadosupervisor   = $datos[$i]["numeroempleadosupervisor"];
    $idPuntoServicioAsistencia  = $datos[$i]["idPuntoServicioAsistencia"];

    $datos[$i]["detallemodal"] = "<a href='javascript:mostrarModalSupervision(" . $idsup . ",\"" . $fechaasistenciasupervision . "\",\"" . $numeroempleadosupervisor . "\",\"" . $idPuntoServicioAsistencia . "\");'><img style='heigth:30%; width:30%; margin-left:34%' src='" . $archivo . "'></a>";
}

$response["datos"] = $datos;
echo json_encode($response);
