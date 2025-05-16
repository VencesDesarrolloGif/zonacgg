<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
if (!isset($_SESSION["userLog"])) {
    header ("Location: https://zonagifseguridad.com.mx//zonagif/Vista/LoginSuperUsuario/form_LoginSuperUsuario.php");
    exit;
} 
$log = new KLogger ( "ajax_insertarHistoricoMovimientoFiniquitoPago.log" , KLogger::DEBUG );
$response = array("status" => "success");
$idFiniquito = $_POST['idFiniquito'];
$estatusActual = $_POST['estatusActual'];
$estatusNuevo = $_POST['estatusNuevo'];
$usuario = $_SESSION ["userLog"]["usuario"];
$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));

try{
    $sql1 ="INSERT INTO historicomovimientosFiniquitosPago (idHstMovFinPago, idFiniquito, idEstatusActual, idEstatusNuevo, fechamovimiento, usuarioMovimiento) VALUES (null,'$idFiniquito','$estatusActual','$estatusNuevo',now(),'$usuario')";
	$log->LogInfo("Valor de la variable sql1: " . var_export ($sql1, true));

        $res = mysqli_query($conexion, $sql1);
    
}catch( Exception $e ){
	$response["status"]="error";
	$response["error"]="No se pudo eliminar folio";
}
echo json_encode($response);
?>