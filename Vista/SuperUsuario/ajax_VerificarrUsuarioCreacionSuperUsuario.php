<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
//$log = new KLogger ( "ajax_VerificarrUsuarioCreacionSuperUsuario.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));

try {
    $Usuario = $_POST ["Usuario"];
    $NumeroSuperUsuario = $_POST ["NumeroSuperUsuario"];
    $sql = "SELECT count(idSuperUsuario) as idSuperUsuario from SuperUsuarios
            where ((UsuarioS='$Usuario') or (concat_ws('-',empleadoEntidadSuperU,empleadoConsecutivoSuperU,empleadoCategoriaSuperU)='$NumeroSuperUsuario'))";     
        //$log->LogInfo("Valor de la variable sql " . var_export ($sql, true));
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    //$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
