<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();

require "../conexion/conexion.php";
require_once "../../libs/logger/KLogger.php";
$iniciodeconsulta   = $_POST["iniciodeconsulta"];
$findeconsulta      = $_POST["findeconsulta"];
$response           = array();
$response["status"] = "error";
$datos              = array();
try {
    $log = new KLogger("ajax_diastrabajados.log", KLogger::DEBUG);
    $sql = "SELECT concat(empleados.entidadFederativaId,'-',empleados.empleadoConsecutivoId,'-',empleados.empleadoCategoriaId)AS numempleado,
        concat(empleados.apellidoPaterno,' ',empleados.apellidoMaterno,' ',empleados.nombreEmpleado) AS nombreempleado,
         catalogopuestos.descripcionPuesto,datosimss.fechaImss,datosimss.fechaBajaImss,nomina.cuotaPagadaTurno
FROM  empleados
left join datosimss
on datosimss.empladoEntidadImss=empleados.entidadFederativaId
and datosimss.empleadoConsecutivoImss=empleados.empleadoConsecutivoId
and datosimss.empleadoCategoriaImss=empleados.empleadoCategoriaId
LEFT JOIN nomina
on nomina.idEntidadEmpleadoNomina=datosimss.empladoEntidadImss
and  nomina.consecutivoEmpleadoNomina=datosimss.empleadoConsecutivoImss
and nomina.tipoEmpleadoNomina=datosimss.empleadoCategoriaImss
LEFT JOIN  catalogopuestos
 on empleados.empleadoIdPuesto=catalogopuestos.idPuesto
where datosimss.fechaBajaImss between CAST('$iniciodeconsulta' AS DATE) and CAST('$findeconsulta'  AS DATE)

and datosimss.empleadoEstatusImss=7
order by  datosimss.fechaBajaImss asc";

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
