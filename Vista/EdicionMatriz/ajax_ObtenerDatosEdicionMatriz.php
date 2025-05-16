<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
$idMatriz           = $_POST["idMatriz"];
//$log = new KLogger ( "ajax_ObtenerDatosEdicionMatriz.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));
try {
    $sql = "SELECT * FROM matricesEntidades
            where IdMatrizPrincipal='$idMatriz'
            and EstatusEntidadesMatriz='1'";      
    
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    for($i = 0; $i < count($datos); $i++){
        $IdMatrizEntidad     = $datos[$i]["IdMatrizEntidad"]; 
        $nombreEntidadAsignada1     = $datos[$i]["nombreEntidadAsignada"]; 
        $nombreEntidadAsignada = str_replace(" ","-",$nombreEntidadAsignada1);

        $datos[$i]["accion"]= "<img style='width: 6%' title='Rechazar'src='img/rechazarImss.png' class='cursorImg' id='btnRechazar' onclick=ElimiarEntidadDeLaMatriz('$IdMatrizEntidad','$nombreEntidadAsignada')>";
    }
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
