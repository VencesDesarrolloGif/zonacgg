<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
date_default_timezone_set('America/Mexico_City');
$response = array();
$datos    = array();
$response = array("status" => "success");
$idIncidencia=$_POST['idSeleccion'];
//$log = new KLogger ( "ajax_ObtenerEspecificacionIncidencias.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
try {
    $sql = "SELECT * 
            FROM CatalogoEspecificacionIncidenciaCentroC
            WHERE idTipoIncidenciaEsp=$idIncidencia";
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }
    $response["datos"]= $datos;
    //$log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));
}catch (Exception $e) {    
    $response["status"]="error";
    $response["error"]="No se puedo obtener Lista se Entidades";
}
echo json_encode($response);
?>