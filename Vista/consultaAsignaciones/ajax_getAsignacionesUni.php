<?php
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response = array("status" => "success");
//$log = new KLogger ( "ajaxGetProveedores.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable $proveedores: " . var_export ($proveedores, true))	
$tipoAsignacion=$_POST['tipoAsignacion'];
$asignaciones = array();

try{

	if($tipoAsignacion=='1'){//uso propio

		$sql = "SELECT concat_ws('-',au.entidadEmpAsignacion,au.consecutivoEmpAsignacion,au.categoriaEmpAsignacion) as numeroEmpleado,
					   concat_ws(' ',e.apellidoPaterno,e.apellidoMaterno,e.nombreEmpleado) as nombreEmpleado,
					   ef.nombreEntidadFederativa as entidadTrabajo,
					   ctu.codigoUniforme,ctu.descripcionTipo,
					   ctu.costoUniforme,
					   au.claveUniAsignacion as idUniforme,
					   (au.cantidadUniforme*ctu.costoUniforme) as totalAsignacion,
					   au.cantidadUniforme,
					   au.fechaAsignacion,
					   cc.razonSocial as cliente,
					   cps.puntoServicio 
				FROM asignacion_uniforme au 
				LEFT JOIN empleados e ON (au.entidadEmpAsignacion=e.entidadFederativaId and au.consecutivoEmpAsignacion=e.empleadoConsecutivoId and au.categoriaEmpAsignacion=e.empleadoCategoriaId) 
				LEFT JOIN entidadesfederativas ef ON (e.idEntidadTrabajo=ef.idEntidadFederativa) 
				LEFT JOIN catalogopuntosservicios cps ON (e.empleadoIdPuntoServicio=cps.idPuntoServicio) 
				LEFT JOIN catalogoclientes cc ON(cps.idClientePunto=cc.idCliente) 
				LEFT JOIN catalogotiposuniforme ctu ON (au.claveUniAsignacion=ctu.idTipoUniforme)";
	}else{
		$sql = "SELECT concat_ws('-', au.entidadSupAsignacion,au.consecutivoSupAsignacion,au.categoriaSupAsignacion) as numeroEmpleado,
					   concat_ws(' ',e.apellidoPaterno,e.apellidoMaterno,e.nombreEmpleado) as nombreEmpleado,
					   ef.nombreEntidadFederativa as entidadTrabajo,
				       ctu.codigoUniforme,
				       ctu.descripcionTipo,
				       ctu.costoUniforme,
				       au.claveUniAsignacionSup as idUniforme,
				       (au.cantidadUniformeSup*ctu.costoUniforme) as totalAsignacion,
				       au.cantidadUniformeSup as cantidadUniforme,
				       au.fechaAsignacionASup as fechaAsignacion,
				       cc.razonSocial as cliente,
				       cps.puntoServicio 
				FROM asignacion_uniforme_supervisores au 
				LEFT JOIN empleados e ON (au.entidadSupAsignacion=e.entidadFederativaId and au.consecutivoSupAsignacion=e.empleadoConsecutivoId and au.categoriaSupAsignacion=e.empleadoCategoriaId) 
				LEFT JOIN entidadesfederativas ef ON (e.idEntidadTrabajo=ef.idEntidadFederativa) 
				LEFT JOIN catalogopuntosservicios cps ON (e.empleadoIdPuntoServicio=cps.idPuntoServicio) 
				LEFT JOIN catalogoclientes cc ON(cps.idClientePunto=cc.idCliente) 
				LEFT JOIN catalogotiposuniforme ctu ON (au.claveUniAsignacionSup=ctu.idTipoUniforme)";
	}

	$res = mysqli_query($conexion, $sql);
   	while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
   	       $asignaciones[] = $reg;
   	}
	$response["data"]= $asignaciones;
} 
catch( Exception $e ){
	$response["status"]="error";
	$response["error"]="No se puedo obtener Lista de personal Activo";	
}
echo json_encode($response);
?>