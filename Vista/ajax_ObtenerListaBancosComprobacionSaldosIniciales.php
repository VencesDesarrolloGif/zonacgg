<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);
$accion=$_POST["accion"];
$idbanco=$_POST["idbanco"];
$datos=array();
//$log = new KLogger ( "ajaxListaBancos.log" , KLogger::DEBUG );

$response = array("status" => "success");

try{

if($accion==0){
	$listaBancos = $negocio -> negocio_ListaBancos();
$response["listaBancos"]= $listaBancos;
}
else if($accion==1){
$listacuentasbancarias = $negocio -> negocio_ListaCuentasBancarias($idbanco);



for($i=0;$i<count($listacuentasbancarias);$i++){
	$numcuenta=$listacuentasbancarias[$i]["numCuenta"];
	$idnumcuenta =$listacuentasbancarias[$i]["idCuentaBancaria"];
//$log->LogInfo("Valor de variable numcuenta" . var_export ($numcuenta, true));
	$listasaldosporcuentasbancarias = $negocio -> negocio_ListaSaldosPorCuentas($idbanco,$idnumcuenta);
	//$listamontosporcuentasbancarias = $negocio -> negocio_ListaMontosPorCuentas($numcuenta);
	




  //$monto=$listamontosporcuentasbancarias[0]["monto"];

//$log->LogInfo("Valor de variable listasaldosporcuentasbancarias" . var_export ($listasaldosporcuentasbancarias, true));
if(count($listasaldosporcuentasbancarias)!=0){
	$subtotal=$listasaldosporcuentasbancarias[0]["saldoDisponibleFin"];
}else{

$subtotal=0;

}

	//$subtotal=$listasaldosporcuentasbancarias[0]["saldoDisponibleFin"];

	//$subtotal=($subtotalporcuenta-$monto);



	$datos[$i]["cuenta"]=$numcuenta;
	$datos[$i]["saldo"]=$subtotal;

	//$log->LogInfo("Valor de variable numcuenta" . var_export ($numcuenta, true)."saldo" . var_export ($listasaldosporcuentasbancarias, true));
	


}

//$response["listacuentasbancarias"]= $datos;

$response["listacuentasbancarias"]= $datos;
}



	
	
} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Lista de Visitantes";
}

echo json_encode($response);

?>