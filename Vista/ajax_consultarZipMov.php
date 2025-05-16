<?php
session_start ();
require_once ("../libs/logger/KLogger.php");
require "conexion.php";
//$log = new KLogger ( "ajax_consultarZipMov.log" , KLogger::DEBUG );
// Obtenemos los datos del empleado
$response= array ();
$mes     =$_POST['mes'];
$anio    =$_POST['anio'];

$nombreDocumento="movimiento_".$mes.$anio;

    $sql = "SELECT ifnull(count(idArchivoMov),0) total 
            FROM documentos_movimientos
            WHERE NombreArchivoMov LIKE '%$nombreDocumento%'
            ORDER BY idArchivoMov DESC
            LIMIT 1";      
            
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {
        $datos[] = $reg;
    }

    $totalDoc=$datos[0]["total"];


    $response["status"] = "success";
    $response["datos"]  = $datos;
    $response["datos"]["total"]=$totalDoc;

echo json_encode($response);
?> 