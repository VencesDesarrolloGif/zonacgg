<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_obtenerClientesXlineaNegocio.log" , KLogger::DEBUG );
$LineaNegocioElegida = getValueFromPost ("LineaNegocioElegida");
$valorgifTipo=getValueFromPost ("valorgifTipo");


try{
	if ($_SESSION["userLog"]["rol"]=='Gerente Regional') {
		$casoXgerente='1';
		$entidadGerente = $_SESSION["userLog"]['entidadFederativaUsuario'][0];//para obtener su region
        $region = $negocio->obtenerRegionGerente($LineaNegocioElegida,$entidadGerente);
		$regionGerente= $region[0]["idRegionI"];
	}else{
		  $casoXgerente='0';
		  $regionGerente= '0';
	}

    $clientes = $negocio->obtenerClienteXLinea($LineaNegocioElegida,$valorgifTipo,$casoXgerente,$regionGerente);
    $response["datos"] = $clientes;
	//$log->LogInfo("Valor de Clienets" . var_export ($response, true));
   }catch(Exception $e) {
	    $response["status"] = "error";
	    $response["error"]  = "No se puedo obtener lista de Clientes";
	}
echo json_encode($response);
