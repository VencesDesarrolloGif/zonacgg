<?php

session_start();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php"); 
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
$response = array (); 
verificarInicioSesion($negocio);
	//$log = new KLogger ( "ajax_bajaPunto.log" , KLogger::DEBUG );
	$idPuntoServicio=getValueFromPost("idPuntoServicio");
	$esatusPunto=getValueFromPost("esatusPunto"); 
	$fechaTerminoServicio=getValueFromPost("fechaTerminoServicio");
	$usuario = $_SESSION ["userLog"]["usuario"];
	
		//$log -> LogInfo ("VALOR DE idPuntoServicio ".var_export ($idPuntoServicio, true));
	try
	{
		if ($esatusPunto==0){
			$MotivoBaja=getValueFromPost("MotivoBaja");
			$listaClientes= $negocio -> negocio_RevisarElementosActivosEnELPunto($idPuntoServicio);
			$ConteoTotalEmpleadosActivos = count($listaClientes);
			if($ConteoTotalEmpleadosActivos=="0"){
				$negocio -> actualizaEstatusPuntoServicio($idPuntoServicio, $esatusPunto, $fechaTerminoServicio);
				$negocio -> updateEstatusRequisicionesByPunto($idPuntoServicio, $esatusPunto,$MotivoBaja,$fechaTerminoServicio,$usuario);
				$response["status"] = "success";
				$response ["message"] = "Servicio finalizado";
			}else{
				$response["status"] = "error";
				$response["message"] = "El Punto De Servicio Cuenta Con " . $ConteoTotalEmpleadosActivos . " Elementos Activos Deben Ser Cambiados De Puntos De Servicio Para Continuar ";
			}
		}else{
			$negocio -> actualizaEstatusPuntoServicio($idPuntoServicio, $esatusPunto, $fechaTerminoServicio);
			$response["status"] = "success";
			$response ["message"] = "Servicio finalizado";
		}
	}
	catch(Exception $e)
	{
		$response["status"] = "error";
		$response["message"] = "Error al indicar termino de servicio:" .$e -> getMessage(); 
	}



echo json_encode($response);

?>