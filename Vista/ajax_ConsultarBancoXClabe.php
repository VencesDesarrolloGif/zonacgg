<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
$response = array("status" => "success");
// $log = new KLogger ("ajax_ConsultarBancoXClabe.log" , KLogger::DEBUG );
$clabe=getValueFromPost("clabe");
$idClabeBanco =  substr($clabe, 0, 3);

// $log->LogInfo("Valor de la variable clabe: " . var_export ($clabe, true));
	try{
		$banco= $negocio -> obtenerBancoByClabe($idClabeBanco);//se reutiliza la funcion de negocio y persistencia
		if (count($banco)>0) {
        $idBancoXClabe=$banco[0]["idCuentaBanco"];
        $response["idCuentaBanco"]=$idBancoXClabe;
		}else{
			$response["status"]="error";
		}
	}catch(Exception $e ){
		   $response["status"]="error";
		   $response["error"]="No se puedo obtener Empleado";
	}
echo json_encode($response);
?>