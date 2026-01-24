<?php
session_start();
require "conexion.php";
require_once("../libs/logger/KLogger.php");
// $log = new KLogger ( "ajax_obtenerSupOpFisicaXentidad.php.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable _FILES: " . var_export ($_FILES, true)); 
$response = array("status" => "success");
$entidad=$_POST['entidadLaborar'];
$supervisoresOp= array();

try{

    $sql = "SELECT e.entidadFederativaId, e.empleadoConsecutivoId,e.empleadoCategoriaId, concat_ws('-',e.entidadFederativaId, e.empleadoConsecutivoId,e.empleadoCategoriaId) as supervisorId , concat( e.nombreEmpleado, \" \", e.apellidoPaterno, \" \", e.apellidoMaterno) AS nombre
    		FROM empleados e
    		WHERE empleadoIdPuesto=6  
    		AND e.empleadoEstatusId<>0 
    		-- AND idEntidadTrabajo='$entidad' 
    		ORDER BY e.nombreEmpleado asc"; 

    $res = mysqli_query($conexion, $sql);
    while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
           $supervisoresOp[] = $reg;
    }
    $response["listaSupervisoresOperativos"]=$supervisoresOp;

}catch( Exception $e ){
	$response["status"]="error";
	$response["error"]="No se pudo eliminar folio";
}
echo json_encode($response);
?>