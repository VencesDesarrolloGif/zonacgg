<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
// $log = new KLogger ( "ssss.log" , KLogger::DEBUG );
$negocio = new Negocio();
$usuario = $_SESSION ["userLog"]["rol"];
verificarInicioSesion ($negocio);


// $log->LogInfo("Valor de la variable \$usuario: " . var_export ($_SESSION , true));

$response = array("status" => "success");
$valorClaves=getValueFromPost("valorClaves");
$check=getValueFromPost("check");
$case=getValueFromPost("case");
try{
	
		$listaClavesPorTipoMovimiento = $negocio -> negocio_ListaClavesClasificacionesPorTipo($case,$valorClaves,$usuario,$check);
		$response["listaClavesPorTipoMovimiento"]= $listaClavesPorTipoMovimiento;
	

	} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Lista de Claves";
}

echo json_encode($response);

?>