<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "success";
$datos              = array();
$datos1              = array();
 $log = new KLogger ( "ajax_AgregarEliminarEntidadRegion.log" , KLogger::DEBUG );
 $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));  
try {
    $SelectRegiones  = $_POST["SelectRegiones"];
    $SelectLineaNegocioRegion  = $_POST["SelectLineaNegocioRegion"];
    $entidad  = $_POST["entidad"];
    $opcion  = $_POST["opcion"];
    $textoRegion  = $_POST["textoRegion"];
    $usuario  = $_SESSION ["userLog"]["usuario"];
    if($opcion =="1"){
        $sql = "DELETE FROM index_regiones WHERE idRegionI = '$SelectRegiones' and idLineaNegI='$SelectLineaNegocioRegion' and idEntidadI ='$entidad'"; 
    }else{
        $sql = "INSERT INTO index_regiones (idIncrementI, idRegionI, DescripcionI, idLineaNegI, idEntidadI, usuarioEdicion, FechaEdicion)VALUES (null, '$SelectRegiones', '$textoRegion', '$SelectLineaNegocioRegion', '$entidad', '$usuario', now())";
    }
    // $log->LogInfo("Valor de la variable sql: " . var_export ($sql, true));  
    $res = mysqli_query($conexion, $sql);  
    if ($res !== true) {
        $response["status"] = "error";
        $response["message"]='error al enviar la entidad a la region';
        return;
    }else{
        //se actualiza asistencia
        $response["message"]='Se Guardo Exitosamente la entidad a la region';
    }
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
