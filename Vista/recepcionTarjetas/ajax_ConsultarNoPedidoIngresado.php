<?php
session_start ();
require_once("../../libs/logger/KLogger.php");
require "../conexion.php";
$response = array ();
$datos= array ();
$noPedido=$_POST["noPedido"];
$response ["status"] = "error";
// $log = new KLogger ( "ajax_consultaPedidoIngresado.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));

    $sql = "SELECT ifnull(count(IdPedidoT),0) as existePedido
            FROM pedidotarjetas
            WHERE NumeroPedido=$noPedido"; 

    $res = mysqli_query($conexion, $sql);
           while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
           }

    if ($datos[0]["existePedido"] != '' && $datos[0]["existePedido"] != '0') {
        $response ["status"] = "error";
        $response ["mensaje"]= "ya existe este numero de pedido";
    }else{
        $response["status"] = "success";
    }
echo json_encode ($response);
?>
