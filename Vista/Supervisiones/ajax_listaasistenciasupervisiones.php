<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
require "../conexion.php";
$response = array();
//$response ["status"] = "error";
$datos            = array();
$idpuntoservicio  = $_POST["idpuntoservicio"]; //variables que recibo del ajax
$entidadsuper     = $_POST["entidadsuper"];
$consecutivosuper = $_POST["consecutivosuper"];
$categoriasuper   = $_POST["categoriasuper"];
$qry              = mysqli_query($conexion, "SELECT  concat(asistencia_supervisor.entidadSupervisor,'-',asistencia_supervisor.consecutivoSupervisor,'-',asistencia_supervisor.categoriaSupervisor) numeroempleado,
												        concat(empleados.apellidoPaterno,' ',empleados.apellidoMaterno,' ',empleados.nombreEmpleado) nombre,catalogopuestos.descripcionPuesto,
												        ifnull(asistencia_supervisor.horaEntradaSupervisor,'N.A') as horaEntradaSupervison ,
												        ifnull(asistencia_supervisor.salidaSupervisor,'N.A') as salidaSupervision,
												        ifnull(asistencia_supervisor.fechaAsistenciaSupervisor,'N.A') as fechaAsistenciaSupervision,asistencia_supervisor.idSupervision,
																	      asistencia_supervisor.entidadSupervisor, asistencia_supervisor.consecutivoSupervisor, asistencia_supervisor.categoriaSupervisor
												FROM asistencia_supervisor
												left join  empleados
												on empleados.entidadFederativaId=asistencia_supervisor.entidadSupervisor
												and empleados.empleadoConsecutivoId=asistencia_supervisor.consecutivoSupervisor
												and empleados.empleadoCategoriaId=asistencia_supervisor.categoriaSupervisor
												left join catalogopuestos
												on empleados.empleadoIdPuesto=catalogopuestos.idPuesto
												where asistencia_supervisor.idPuntoServicioAsistencia='$idpuntoservicio'
												and asistencia_supervisor.entidadSupervisor='$entidadsuper'
												and asistencia_supervisor.consecutivoSupervisor ='$consecutivosuper'
												and asistencia_supervisor.categoriaSupervisor='$categoriasuper'");
while (($regg = mysqli_fetch_array($qry, MYSQLI_ASSOC))) {
	
    $datos[] = $regg;}
$response["datos"] = $datos;
echo json_encode($response);
