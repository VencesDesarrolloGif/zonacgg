<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$datos              = array();
$response = array("status" => "success");
$log = new KLogger ( "ajax_getClientesAsigandosXUsuarios.log" , KLogger::DEBUG );
$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
try {
    $usuarioRUC= $_POST['usuarioRUC'];
    $lineaNegocioElegida= $_POST['lineaNegocioElegida'];

    $sql = "SELECT ruc.idIncrementUC,cc.razonSocial
            FROM relacionUsuarios_clientes ruc
            LEFT JOIN catalogoclientes cc on cc.idCliente=ruc.idClienteRUC
            WHERE ruc.idUsuarioRUC='$usuarioRUC'
            AND idLineaNegocioRUC='$lineaNegocioElegida'
            ORDER BY cc.razonSocial";    
$log->LogInfo("Valor de la variable sql " . var_export ($sql, true));
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }
    $response["datos"] = $datos;

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No se puedo obtener lista de datos";
}
echo json_encode($response);
