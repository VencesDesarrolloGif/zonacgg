<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
require "../conexion.php";
$response = array();
//$response ["status"] = "error";
$datos            = array();
$idsupervision    = $_POST["idsupervision"]; //variables que recibo del ajax;
$qry              = mysqli_query($conexion, "SELECT concat(empleados.entidadFederativaId,'-',empleados.empleadoConsecutivoId,'-',empleados.empleadoCategoriaId) as numerodeempleadoguardia,
concat(empleados.apellidoPaterno,' ',empleados.apellidoMaterno,' ',empleados.nombreEmpleado) AS nombreguardia,
supervisiones_guardias.CalifImagen,supervisiones_guardias.CalifUniformeCompleto,supervisiones_guardias.CalifActitudServicio,supervisiones_guardias.CalifCumplimientoConsignias,
supervisiones_guardias.Observaciones,catalogopuntosservicios.puntoServicio,supervisiones_guardias.FechaHoraRegistro
FROM  supervisiones_guardias
left join empleados
on supervisiones_guardias.entidadGuardia=empleados.entidadFederativaId
and supervisiones_guardias.consecutivoGuardia=empleados.empleadoConsecutivoId
and supervisiones_guardias.categoriaGuardia=empleados.empleadoCategoriaId
left join catalogopuntosservicios on (catalogopuntosservicios.idPuntoServicio=supervisiones_guardias.IdPuntoAsistnciaGuardia)
where supervisiones_guardias.idAsistenciaSup='$idsupervision'");
while (($regg = mysqli_fetch_array($qry, MYSQLI_ASSOC))) {

    $datos[] = $regg;
}
$response["datos"] = $datos;
echo json_encode($response);
