<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_obtenerSupervisoresXLineaNegocio.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de _SESSION" . var_export ($_SESSION, true));

$LineaNegocio = $_POST['LineaNegocioElegida'];
try {

	if($_SESSION["userLog"]["rol"]=='Supervisor' || $_SESSION["userLog"]["rol"]=='Consulta Supervisor') {
		$caso=1;
		$noSupervisor = $_SESSION["userLog"]['empleadoId'];
	     $entidades = '0';//solo para igual variables a la funcion
     	$supervisores = $negocio->obtenerSupervisoresXLineaNegocio($LineaNegocio,$noSupervisor,$caso,$entidades);
	}else if($_SESSION["userLog"]["rol"]=='Gerente Regional') {
		$caso='3';
		$noSupervisor=0;
		$entidadGerente = $_SESSION["userLog"]['entidadFederativaUsuario'][0];//para obtener suregion
	     $entidades = $negocio->obtenerEntidadesDeRegiionXentTrabajo($LineaNegocio,$entidadGerente);
	     $supervisores = $negocio->obtenerSupervisoresXLineaNegocio($LineaNegocio,$noSupervisor,$caso,$entidades);
	}else{
		$caso='2';
		$noSupervisor=0;
	     $entidades = '0';//solo para igual variables a la funcion
	     $supervisores = $negocio->obtenerSupervisoresXLineaNegocio($LineaNegocio,$noSupervisor,$caso,$entidades);
	}
     $response["datos"] = $supervisores;
   //$log->LogInfo("Valor de supervisores" . var_export ($response, true));
   } 
	catch (Exception $e){
	    $response["status"] = "error";
	    $response["error"]  = "No se puedo obtener lista supervisores";
		}
echo json_encode($response);
