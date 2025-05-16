<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$datos = array();
$response = array("status" => "success");
$log = new KLogger ( "ajax_getclientes.log" , KLogger::DEBUG );

try {
    $clientesAsignados= array();
    $usuarioRUC= $_POST['usuarioRUC'];
    $lineaNegocioElegida= $_POST['lineaNegocioElegida'];

    $sql1 = "SELECT idClienteRUC
             FROM relacionUsuarios_clientes
             WHERE idUsuarioRUC='$usuarioRUC'
             AND idLineaNegocioRUC='$lineaNegocioElegida'"; 

    $log->LogInfo("Valor de la variable sql1 " . var_export ($sql1, true));

    $res1 = mysqli_query($conexion, $sql1);
    while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
        $clientesAsignados[] = $reg1;
    }

    if($clientesAsignados==NULL || $clientesAsignados=="NULL") {
       $totalClientes=0;
    }else{
        $totalClientes=count($clientesAsignados);
    }

    $sql = "SELECT idCliente,razonSocial
            FROM catalogoclientes";  

    if($totalClientes>0) {

        for($a=0; $a < $totalClientes; $a++){ 
            $clienteID = $clientesAsignados[$a]["idClienteRUC"];

            $suma= $a+1;

            if($a==0){
               $sql.=" WHERE (";
            }

            $sql.="idCliente!=$clienteID";

            if($suma==$totalClientes) {
               $sql.=")";
            }else{
               $sql.=" AND ";
            }
        }
               $sql.=" ORDER BY razonSocial";
    }   

    $log->LogInfo("Valor de la variable sql " . var_export ($sql, true));

    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }

    $response["datos"] = $datos;
} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No se puedo obtener lista de datos";
}
echo json_encode($response);
