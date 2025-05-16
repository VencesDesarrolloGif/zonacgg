<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
//$log = new KLogger ( "ajax_obtenerTotalTarjetasDisponiblesLaEntidadParaRecibir.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable POST: " . var_export ($_POST, true));

$response = array();
$datos    = array();
$response["status"]  = "success";
$EntidadABuscar            = $_POST["EntidadABuscar"];
$usuario             = $_SESSION ["userLog"]["usuario"];
try {
    $sql = "SELECT * from TarjetaDespensa
            left join matrices on (TarjetaDespensa.idMatrizAsiganda= matrices.IdMatriz)
            left join pedidotarjetas on (TarjetaDespensa.IdPedido= pedidotarjetas.IdPedidoT)
            where idEntidadAsignada='$EntidadABuscar'
            and idEstatusAsignacionEntidad = '2'";      
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);