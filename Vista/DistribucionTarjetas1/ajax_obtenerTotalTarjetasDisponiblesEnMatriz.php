<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
//$log = new KLogger ( "ajax_obtenerTotalTarjetasDisponiblesEnMatriz.log" , KLogger::DEBUG );
   // $log->LogInfo("Valor de la variable POST: " . var_export ($_POST, true));

$response = array();
$datos    = array();
$response["status"]  = "success";
$IdMatriz            = $_POST["IdMatriz"];
$usuario             = $_SESSION ["userLog"]["usuario"];
try {
    $sql = "SELECT * from TarjetaDespensa
            left join pedidotarjetas on (TarjetaDespensa.IdPedido= pedidotarjetas.IdPedidoT)
            where idMatrizAsiganda='$IdMatriz'
            and (idEstatusAsignacionEntidad is null or idEstatusAsignacionEntidad = '0')";      
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
    //$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
echo json_encode($response);