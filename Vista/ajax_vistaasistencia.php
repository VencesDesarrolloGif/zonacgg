<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "conexion.php";
$response  = array();
$datoss    = array();
$responsee = array();
$datos     = array();
$inprol    = $_SESSION["userLog"]["usuario"]; //variables que recibo del ajax
$accion    = $_POST["accion"]; //variables que recibo del ajax
if ($accion == 1) {
    $sql = "SELECT * FROM usuario_empleado
            where usuario='$inprol'";    
    mysqli_query($conexion, "SET NAMES 'UTF8'");
    $res = mysqli_query($conexion, $sql);
    if ($reg = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
        $entidad     = $reg["entidadEmpleadoUsuario"];
        $consecutivo = $reg["consecutivoEmpleadoUsuario"];
        $categoria   = $reg["categoriaEmpleadoUsuario"];}
    $qry2 = mysqli_query($conexion, "SELECT supervisor_puntoservicio.puntoServicioId,catalogopuntosservicios.idPuntoServicio,catalogopuntosservicios.puntoServicio
                                        FROM supervisor_puntoservicio
                                        LEFT join catalogopuntosservicios
                                        ON supervisor_puntoservicio.puntoServicioId=catalogopuntosservicios.idPuntoServicio
                                        where  supervisor_puntoservicio.supervisorEntidad='$entidad'
                                        and supervisor_puntoservicio.supervisorConsecutivo='$consecutivo'
                                        and supervisor_puntoservicio.supervisorTipo='$categoria'
                                        and  catalogopuntosservicios.esatusPunto='1'");
    while (($regg = mysqli_fetch_array($qry2, MYSQLI_ASSOC))) {
        $datos[] = $regg;
    }
} elseif ($accion == 2) {
    mysqli_query($conexion, "SET NAMES 'UTF8'");
    $qry3 = mysqli_query($conexion, "SELECT concat(empleados.entidadFederativaId,'-',empleados.empleadoConsecutivoId,'-',empleados.empleadoCategoriaId) numeroempleado,
        concat(empleados.apellidoPaterno,' ',empleados.apellidoMaterno,' ',empleados.nombreEmpleado)  as nombreempleado ,empleados.empleadoIdPuesto,
        empleados.empleadoIdPuntoServicio
        FROM empleados
        where empleados.empleadoIdPuesto=6 and empleados.empleadoEstatusId<>0 order by empleados.nombreEmpleado asc");
    while (($reggg = mysqli_fetch_array($qry3, MYSQLI_ASSOC))) {
        $datos[] = $reggg;}}
$response["datos"] = $datos;
echo json_encode($response);


?>