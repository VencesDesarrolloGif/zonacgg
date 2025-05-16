<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");

$entidadConsulta=$_SESSION ["userLog"]["entidadFederativaUsuario"];
//$log = new KLogger ( "ajaxGetEnviosLava.log" , KLogger::DEBUG );
try{

	if($entidadConsulta =='09'){

		$envios = $negocio ->  negocio_obtenerEnvios1();
	}else{
		$envios = $negocio ->  negocio_obtenerEnvios2($entidadConsulta);
		//$log->LogInfo("Valor de la variable $facturas: " . var_export ($facturas, true));
	}
	
	for($i = 0; $i < count($envios); $i++){

		$idEnvio = $envios[$i] ["idEnvio"];		
		$estatus = $envios[$i] ["estatus"];	
		if($estatus==0){
			$envios[$i] ["estatus"]="En Lavanderia";
			$accion="<button id='recibirEnvio' name='recibirEnvio' class='btn btn-primary' type='button' onclick='recibirLavanderia(\"".$idEnvio."\");'>Recibir</button>";
		}else{
			$envios[$i] ["estatus"]="Recibida";
			$accion="N/A";
		}

		$envios[$i]["accion_ver_detalle"] = "<a href='javascript:mostrarModalDetalleEnvio(\"" . $idEnvio . "\");'>Ver Detalle</a>";
		$envios[$i]["accion_recibir"] = $accion;

	//	$log->LogInfo("Valor de la variable \$envios: " . var_export ($envios, true));
	}
	$response["data"]= $envios;

} 
catch( Exception $e )		
{
	$response["status"]="error";
	$response["error"]="No se pudieron obtener facturas";	
}

echo json_encode($response);

?>


