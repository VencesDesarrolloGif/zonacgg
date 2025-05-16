<?php
session_start();
require "conexion.php";
require_once("../libs/logger/KLogger.php");
//$log = new KLogger ( "ajax_consultaSucursalesAlmacen.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable \$listaClientes: " . var_export ($response, true));
$response = array("status" => "success");
$sucursales = array();
$entidadElegida=$_POST["entidadElegida"];

try{
	$sql = "SELECT  *
		 FROM sucursalesInternas
		 where idEntidadPerteneciente='$entidadElegida'
		 AND estatusSucursalI='1'";

    $res = mysqli_query($conexion, $sql);
    while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
           $sucursales[] = $reg;
        }
	$response["sucursales"]= $sucursales;
} 
catch( Exception $e ){
	$response["status"]="error";
	$response["error"]="No se puedo obtener Lista de Clientes";
}
echo json_encode($response);
?>