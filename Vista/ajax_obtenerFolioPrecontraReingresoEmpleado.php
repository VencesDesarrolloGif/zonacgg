<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
//verificarInicioSesion ($negocio);
$response = array("status" => "success");
if(!empty ($_POST))
{
		//$log = new KLogger ( "ajaxConsultaEmpleado.log" , KLogger::DEBUG );


		$curpBusqueda=$_POST["curp"];
		$numeroAfiliacionImss=$_POST["numafiliacionimss"];
		$folioPreseleccion=$_POST["folioPreseleccion"];
		
	try{
if($folioPreseleccion==0){
		$datosEmpleado= $negocio -> negocio_obtenerFolioPreseleccionReingreso($curpBusqueda,$numeroAfiliacionImss);
		if(count($datosEmpleado)==0){
			$response = array("status" => "sinDatos");
		}else{
			$response["datosEmpleado"]= $datosEmpleado;
		}
	}else if($folioPreseleccion!=0){

		$datosAspitante= $negocio -> negocio_obtenerAspirante($folioPreseleccion);
		$response["datosAspitante"]= $datosAspitante;
	}	
	//$log->LogInfo("Valor de la variable \$response empleado: " . var_export ($folioPreseleccion, true));
	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se obtuvieron datos";
	}
}
echo json_encode($response);

?>