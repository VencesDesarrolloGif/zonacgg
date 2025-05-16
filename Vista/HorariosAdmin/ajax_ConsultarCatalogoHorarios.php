<?php
session_start();
require "../conexion.php"; 
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array(); 
//$log = new KLogger ( "ajax_ConsultarCatalogoHorarios.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));

try {
    $sql = "SELECT * from Catalogo_Horarios h left join Catalogo_Jornadas j ON (h.idJornada=j.idJornada)";     
    
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
