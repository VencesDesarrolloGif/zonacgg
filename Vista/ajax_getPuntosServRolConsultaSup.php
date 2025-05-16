<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
$datos               = array();
verificarInicioSesion ($negocio);
// $log = new KLogger ( "supervisorparapuntosservicios.log" , KLogger::DEBUG );
$response = array("status" => "success");
try{
	$usuario = $_SESSION ["userLog"]["empleadoId"];
	$empleadoidd = explode("-", $usuario);

	$supervisorEntidad=$empleadoidd[0];
    $supervisorConsecutivo=$empleadoidd[1];
    $supervisorTipo=$empleadoidd[2];

	$listaPuntosServicios= $negocio -> getPuntosServBySupervisor($supervisorEntidad,$supervisorConsecutivo,$supervisorTipo);
		//$log->LogInfo("Valor de variable de listaPuntosServicios" . var_export ($listaPuntosServicios, true));
    for ($i = 0; $i < count($listaPuntosServicios); $i++)
    {
        $datos[$i]["idPuntoServicio"]=$listaPuntosServicios[$i]["idPuntoServicio"];
        $datos[$i]["puntoServicio"]=$listaPuntosServicios[$i]["puntoServicio"];
        $datos[$i]["cobraDescansos"]=$listaPuntosServicios[$i]["cobraDescansos"];
        $datos[$i]["cobraDiaFestivo"]=$listaPuntosServicios[$i]["cobraDiaFestivo"];
        $datos[$i]["cobra31"]=$listaPuntosServicios[$i]["cobra31"];
        $datos[$i]["idClientePunto"]=$listaPuntosServicios[$i]["idClientePunto"];
        $response["datos"]  = $datos;
	} 
}catch( Exception $e ){
	$response["status"]="error";
	$response["error"]="No se puedo obtener consulta";
}
echo json_encode($response);
?>
