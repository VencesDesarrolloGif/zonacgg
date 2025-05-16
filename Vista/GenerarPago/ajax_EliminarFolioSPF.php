<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
// $log = new KLogger ( "ajax_EliminarFolioSPF.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable idFiniquito: " . var_export ($idFiniquito, true));
$response = array("status" => "success");
$idFiniquito= $_POST['idFiniquito'];
$usuario=$_SESSION['userLog']['usuario'];

try{
    $sql1 ="UPDATE finiquitos 
            SET folioSPF=null,
                estatusPagoFiniquito='3'
            WHERE idFiniquito=$idFiniquito";
    $res = mysqli_query($conexion, $sql1);

    $sql2 ="INSERT INTO historicomovimientosFiniquitosPago(idFiniquito,idEstatusActual,idEstatusNuevo,fechamovimiento,usuarioMovimiento) VALUES ($idFiniquito,'4', '3',now(),'$usuario')";
        $res2 = mysqli_query($conexion, $sql2);
}catch( Exception $e ){
	$response["status"]="error";
	$response["error"]="No se pudo eliminar folio";
}
echo json_encode($response);
?>