<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");

		//$log = new KLogger ( "ajax_getTransferenciasByFechaEntidad.log" , KLogger::DEBUG );

		$fecha1=getValueFromPost("fechaConsulta1");
		$fecha2=getValueFromPost("fechaConsulta2");
		$entidadConsulta=getValueFromPost("entidadConsulta");

		//$log->LogInfo("Valor de la variable entidadConsulta : " . var_export ($entidadConsulta, true));
	try{
		//4 CASOS A TOMAR EN CUENTA:  1 CUANDO SOLO INGRESAN FECHA
		//2 CUANDO SOLO INGRESAN ENTIDAD
		//3CUANDO INGRESAN AMBOS PARAMETROS
		//4 CUANDO NO INGRESEN NINGUN DATO MUESTRA GENERALES	
		
			$lista= $negocio -> getTransferGenerales($fecha1,$fecha2,$entidadConsulta);
			for($i = 0; $i < count($lista); $i++){
				$idTransfer = $lista[$i] ["idTransferencia"];										
				$lista[$i]["ver_detalle"] = "<a href='javascript:mostrarModalDetalleTransfer(\"" . $idTransfer . "\");'>Ver Detalle</a>";				
			}
			$response["data"]= $lista;
		//$log->LogInfo("Valor de la variable \$entidadConsulta : " . var_export ($entidadConsulta, true));

	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se pudo obtener detalle de asistencia";
	}
/*
}
*/

echo json_encode($response);

?>