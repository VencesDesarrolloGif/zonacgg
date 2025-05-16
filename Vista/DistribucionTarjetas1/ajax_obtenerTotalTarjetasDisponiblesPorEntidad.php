<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
$log = new KLogger ( "ajax_obtenerTotalTarjetasDisponiblesPorEntidad.log" , KLogger::DEBUG );
$response = array();
$datos    = array();
$response["status"]  = "success";
$IdEntidadARevisar   = $_POST["IdEntidadARevisar"];
$usuario             = $_SESSION ["userLog"]["usuario"];
try {
    $sql = "SELECT * from TarjetaDespensa
            left join matrices on (TarjetaDespensa.idMatrizAsiganda=matrices.IdMatriz)
            left join pedidotarjetas on (TarjetaDespensa.IdPedido=pedidotarjetas.IdPedidoT)
            where idEntidadAsignada='$IdEntidadARevisar'
            and (IdEstatusAsignacionEmpleado is null or IdEstatusAsignacionEmpleado = '0')
            and idEstatusAsignacionEntidad='1'";      
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }
    $response["status"]= "success";
    $response["mensaje"] = "Cargado Con Exito";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";
    $response["status"]= "error";}
$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
echo json_encode($response);