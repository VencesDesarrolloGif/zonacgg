<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
//$log = new KLogger ( "ajax_obtenerTotalTarjetasDisponiblesARecibirParaMatrizR.log" , KLogger::DEBUG );

$response = array();
$datos    = array();
$datos1    = array();
$response["status"]  = "success";
$response["opcion"]  = "0";
$response["matriz"]  = "";
$usuario             = $_SESSION ["userLog"]["usuario"];
try {

    $sql1 = "SELECT * from asignacionMatriz
            left join matrices on (asignacionMatriz.IdMatrizAsignacion= matrices.IdMatriz)
                where usuarioAsignacion='$usuario  '";      
        $res1 = mysqli_query($conexion, $sql1);
        while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
            $datos1[] = $reg1;
        }
        $banderaMatriz = count($datos1); 

        if( $banderaMatriz != "0"){
            $IdMatriz = $datos1[0]["IdMatrizAsignacion"];
            $nombreEntidadmatriz = $datos1[0]["nombreEntidadmatriz"];
            $response["matriz"]  = $nombreEntidadmatriz;

        }else{
            $response["opcion"]  = "1";
            $IdMatriz = ""; 
            $response["matriz"]  = "";

        }

    $sql = "SELECT * from TarjetaDespensa
            left join entidadesfederativas on (TarjetaDespensa.idEntidadAsignada= entidadesfederativas.idEntidadFederativa)
            left join pedidotarjetas on (TarjetaDespensa.IdPedido= pedidotarjetas.IdPedidoT)
            where idMatrizAsiganda='$IdMatriz'
            and idEstatusAsignacionEntidad = '3'";      
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);