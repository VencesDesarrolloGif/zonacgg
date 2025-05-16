<?php
session_start ();
require_once("../../libs/logger/KLogger.php");
require "../conexion.php";
$response = array ();
$response ["status"] = "error";
$usuario = $_SESSION ["userLog"]["usuario"];
$datos= array ();
// $log = new KLogger ( "ajax_consultaUsuarioMatriz.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable response: " . var_export ($response, true));

try{
    $sql = "SELECT m.IdMatriz,m.nombreEntidadmatriz 
            FROM asignacionmatriz am
            LEFT JOIN matrices m on (am.IdMatrizAsignacion=m.IdMatriz)
            WHERE am.usuarioAsignacion='$usuario'
            AND am.estatusAsigacionMatriz='1' "; 

    $res = mysqli_query($conexion, $sql);
           while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
           }

    $response["status"] = "success";
    $response["datos"] = $datos;
}catch(Exception $e){
       $response ["status"] = "error";
       $response ["message"]= "error al consultar matrizes";
}
echo json_encode ($response);
?>
