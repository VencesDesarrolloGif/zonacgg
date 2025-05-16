<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");

		//$log = new KLogger ( "ajax_getTransferenciasByEntidad.log" , KLogger::DEBUG );
		$entidadUsuario = $_SESSION ["userLog"]["entidadFederativaUsuario"];
		//$log->LogInfo("Valor de la variable entidadUsuario : " . var_export ($entidadUsuario, true));

	try{
			$lista= $negocio -> getTransferGenerales("","",$entidadUsuario);

			for($i = 0; $i < count($lista); $i++){

				$idTransfer = $lista[$i] ["idTransferencia"];	
				$identidadDestino = $lista[$i] ["identidadDestino"];	
				$estatus = $lista[$i] ["estatusTransfer"];

				if($estatus=="ENVIADA"){
					$lista[$i] ["estatusTransfer"]="<button id='recibirTransfer' name='recibirTransfer' class='btn btn-primary' type='button' onclick='recibirTransferencia(\"".$idTransfer."\",\"".$identidadDestino."\");'>Recibir</button>";					
				}								

				$lista[$i]["ver_detalle"] = "<a href='javascript:mostrarDetalleTransfer(\"" . $idTransfer . "\");'>Ver Detalle</a>";				
			}
			$response["data"]= $lista;

		//$log->LogInfo("Valor de la variable \$lista : " . var_export ($lista, true));

	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se pudo obtener detalle de Transferencia";
	}
/*
}
*/

echo json_encode($response);

?>