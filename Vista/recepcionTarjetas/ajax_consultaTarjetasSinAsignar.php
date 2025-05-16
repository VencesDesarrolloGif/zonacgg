<?php
session_start ();
require_once("../../libs/logger/KLogger.php");
require "../conexion.php";
$response = array ();
$response ["status"] = "error";
$idMatriz=$_POST["noMatriz"];
$datos= array ();
// $log = new KLogger ( "ajax_consultaTarjetasSinAsignar.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
try{
    $sql = "SELECT *
            FROM tarjetadespensa
            WHERE (idEstatusAsignacionEntidad is null or idEstatusAsignacionEntidad ='0' or idEstatusAsignacionEntidad ='3')
            AND idMatrizAsiganda='$idMatriz'"; 

    $res = mysqli_query($conexion, $sql);
           while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
           }

        $hojaPedidoExist=count($datos);

        if($hojaPedidoExist != '0'){
            $response["status"] = "error";
            $response["mensaje"]= "Auú cuenta con tarjetas para asignar a entidades, por favor asigne y posteriormente recepcione un nuevo pedido";
        }else{
            $response["status"] = "success";
        }
}catch(Exception $e){
       $response ["status"] = "error";
       $response ["message"]= "error al consultar matrizes";
}
echo json_encode ($response);
?>
