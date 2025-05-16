<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);
$accion=$_POST["accion"];
$idBanco=$_POST["idBanco"];
$datos=array();
//$log = new KLogger ( "ajaxListacuentasbancariasselectores.log" , KLogger::DEBUG );
$response = array("status" => "success");

try{

if($accion==1){
$listacuentasbancarias = $negocio -> negocio_ListaCuentasBancarias($idBanco);
//$log->LogInfo("Valor de variable listacuentasbancarias" . var_export ($listacuentasbancarias, true));
for($i=0;$i<count($listacuentasbancarias);$i++){
$datos[$i]["cuentas"]=$listacuentasbancarias[$i];
}

}else{
	$listacuentasbancarias = $negocio -> negocio_ListaCuentasBancarias($idBanco);
//$log->LogInfo("Valor de variable listacuentasbancarias" . var_export ($listacuentasbancarias, true));
for($i=0;$i<count($listacuentasbancarias);$i++){
$datos[$i]["cuentas"]=$listacuentasbancarias[$i];}

}
$response["datos"]=	$datos;
}catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Lista de Visitantes";
}

echo json_encode($response);

?>