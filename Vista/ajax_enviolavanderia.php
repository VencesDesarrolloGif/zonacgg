<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
$log = new KLogger ( "ajax_enviolavanderia.log" , KLogger::DEBUG );
$response = array("status" => "success");
    //$entidadEnvio=$usuarioCaptura=$_SESSION ["userLog"]["entidadFederativaUsuario"];
	$idUniformes=$_POST["idIncrementUniformes"];
	$ultimofolio=$_POST["ultimofolio"];
	$iteracion=$_POST["iteracion"];
	$entidadEnvio=getValueFromPost("EntidadesUsuario");
	$sucursalEnvio=getValueFromPost("sucursalUsuario");
	// $log->LogInfo("Valor de la variable post : " . var_export ($_POST, true));
	//$log->LogInfo("Valor de la variable entidad : " . var_export ($entidadEnvio, true));	
	try{
		$negocio -> updateBajas_Uniformes_envioLavanderia($idUniformes,$ultimofolio,$iteracion,$entidadEnvio,$sucursalEnvio);
		//$log->LogInfo("Valor de la variable \$entidadConsulta : " . var_export ($entidadConsulta, true));
	}catch( Exception $e ){
	$response["status"]="error";
	$response["error"]="No se pudieron obtener uniformes recibidos";
	}
echo json_encode($response);
?>