<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php"); 
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajax_ObatenerLaSigienteTarjetaDeDespensa.log" , KLogger::DEBUG );
$response = array("status" => "success");
$IdTarjetaDespensa=$_POST["IdTarjetaDespensa"];
$idEndidadFederativaContratacion=$_POST["idEndidadFederativaContratacion"];
$ComentarioIut=$_POST["ComentarioIut"];
$contraseniaBajaTarjeta=$_POST["contraseniaBajaTarjeta"];
$NumEmpBajaTarjeta=$_POST["NumEmpBajaTarjeta"];
$usuario = $_SESSION ["userLog"]["usuario"];
try{

	$datos= $negocio -> negocio_ObtenerLaSiguienteTarjetaDeDespensa($IdTarjetaDespensa,$idEndidadFederativaContratacion,$ComentarioIut,$contraseniaBajaTarjeta,$NumEmpBajaTarjeta,$usuario);
	$response["datos"]= $datos;
	//$log->LogInfo("Valor de la variable \$listaClientes: " . var_export ($response, true));

} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Lista de Clientes";
}

echo json_encode($response);

?>