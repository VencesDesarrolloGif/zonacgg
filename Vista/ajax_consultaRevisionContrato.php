<?php
session_start();
require "conexion.php";
require_once("../libs/logger/KLogger.php");
// $log = new KLogger("ajax_consultaRevisionContrato.log", KLogger::DEBUG);
// $log->LogInfo("Valor de la variable sql: " . var_export ($sql, true));
$response= array();
$response["status"]= "error";
$estatusRevision= array();
$idContratoCliente=$_POST['idContratoCliente'];

try{
   
   $sql ="SELECT IFNULL(estatusRevisionPdf,0) AS estatusRevisionPdf 
          FROM contratosclientes
          WHERE idContratoCliente='$idContratoCliente'";

   $res = mysqli_query($conexion, $sql);
   while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $estatusRevision[] = $reg;
        }

   $response["status"] = "success";
   $response["estatusRevisionPdf"] = $estatusRevision[0]['estatusRevisionPdf'];
   $response["mensaje"]= "estatus revision actualizado";
}catch (Exception $e) {
   $response["mensaje"]= "Error al actualizar estatus revision de contrato";
}
echo json_encode($response);