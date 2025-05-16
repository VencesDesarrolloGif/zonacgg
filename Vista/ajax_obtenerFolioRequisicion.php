<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php"); 
require_once ("../libs/logger/KLogger.php");

$negocio= new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");


	//$log = new KLogger ( "ajaxObtenerFolioRequisicion.log" , KLogger::DEBUG );

	//$entidad = getValueFromPost ("entidad");
	//$tipo = getValueFromPost ("tipo");
		//$log->LogInfo("Valor de la variable \$entidad: " . var_export ($entidad, true));
        //$log->LogInfo("Valor de la variable \$tipo: " . var_export ($tipo, true));
    try{

        $folioRequisicion = $negocio -> selectFolioRequisicion();
        
        $response ["folioRequisicion"] = $folioRequisicion;

        //$log->LogInfo("Valor de la variable \$folioRequisicion: " . var_export ($folioRequisicion, true));
        //$log->LogInfo("Valor de la variable \$response: " . var_export ($response, true));
    }
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] = "No se pudo obtener folio para la requisición";
    }


echo json_encode ($response);

?>