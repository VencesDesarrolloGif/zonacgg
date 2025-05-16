<?php
session_start();
require_once("../../libs/logger/KLogger.php");
require "../conexion.php";
// $log = new KLogger ( "ajax_ActualizarRP.log" , KLogger::DEBUG );
$response = array("status" => "success");

$noEmpCompleto=$_POST['noEmpCompleto'];
$registroPatronalElegido=$_POST['registroPatronalElegido'];
// $log->LogInfo("Valor de la variable _SESSION: " . var_export ($_SESSION, true));

$usuario=$_SESSION['userLog']['usuario'];

$empleadoId = explode("-", $noEmpCompleto);
$entidad=$empleadoId[0];
$consecutivo=$empleadoId[1];
$categoria=$empleadoId[2];

	try{
		//////////////////// 2 es para saber que se cancelo ////////////////////////////
		$sql = "UPDATE datosimss 
            	SET idMotivoBajaImss='B',empleadoEstatusImss='5',cambioRPxPS='3'
            	WHERE empladoEntidadImss='$entidad'
            	AND empleadoConsecutivoImss='$consecutivo'
            	AND empleadoCategoriaImss='$categoria'"; 

    	$res = mysqli_query($conexion, $sql);
		
		$sql1 ="INSERT INTO historicomovimientosimss(empEntidadMovimiento, EmpConsecutivoMovimiento, empCategoriaMovimiento, tipoMovimiento, fechaMovimiento,usuarioEdicion,registroMovimiento,estatusmov) VALUES('$entidad','$consecutivo','$categoria','5',now(),'$usuario','$registroPatronalElegido',0)"; 

    	$res1 = mysqli_query($conexion, $sql1);

		$response["message"]= "Se actualizo correctamente";	
       	
	}catch(Exception $e ){
		$response["status"]="error";
		$response["message"]="Error al declinar";
	}
// $log->LogInfo("Valor de la variable sql: " . var_export ($sql, true));
// $log->LogInfo("Valor de la variable sql1: " . var_export ($sql1, true));
echo json_encode($response);
?>