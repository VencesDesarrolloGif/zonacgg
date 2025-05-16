<?php
session_start();
require_once "../Negocio/Negocio.class.php";  
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
$valorgifTipo=getValueFromPost ("valorgifTipo");
$Linea=getValueFromPost ("Linea");
//mweter el rol del usuario si es gerente traer solo las entidades de su region
$log = new KLogger ( "ajax_entidadesGeneral.log" , KLogger::DEBUG );
$log->LogInfo("Valor de la variable _SESSION: " . var_export ($_SESSION, true));
if(count($_SESSION["userLog"]['entidadFederativaUsuario'])>0){
	$entidadGerente = $_SESSION["userLog"]['entidadFederativaUsuario'][0];//para obtener su region
}else{
	$entidadGerente ="";
}
try{
    if ($_SESSION["userLog"]["rol"]=='Gerente Regional') {
	     $entidades = $negocio->obtenerEntidadesDeRegiionXentTrabajo($Linea,$entidadGerente);//no tomo en cuenta condicion de cliente 13(esta funcion se usa en otros lados)
    }else{
   	 	 $entidades = $negocio->obtenerEntidadGeneral($valorgifTipo,$Linea);
   		}
  	 $response["datos"] = $entidades;
  
  }catch(Exception $e) {
	    	$response["status"] = "error";
	    	$response["error"]  = "No se puedo obtener lista de Marcas";
         //$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
	}
echo json_encode($response);
