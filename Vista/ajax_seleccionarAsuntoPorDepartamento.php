<?php

session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");


$negocio= new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");

if(!empty ($_POST))
{
	//$log = new KLogger ( "ajax.log" , KLogger::DEBUG );
	$departamentoId = getValueFromPost ("areaVisita");
    try{

        $listaAsuntos = $negocio -> negocio_obtenerListaAsuntosPorDepartamento($departamentoId);
        $response ["listaAsuntos"] = $listaAsuntos;

        //$log->LogInfo("Valor de la variable \$listaAsuntos: " . var_export ($listaAsuntos, true));
        //$log->LogInfo("Valor de la variable \$response: " . var_export ($response, true));
    }
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] = "No se pudieron obtener los posibles asuntos";
    }
}

echo json_encode ($response);
?>


