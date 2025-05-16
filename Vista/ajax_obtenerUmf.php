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
	//$log = new KLogger ( "ajaxObtenerUmf.log" , KLogger::DEBUG );
	$idMunicipio = getValueFromPost ("idMunicipio");
    try{

        $listaUmf = $negocio -> negocio_obtenerUmfPorMunicipio($idMunicipio);
        $response ["listaUmf"] = $listaUmf;

        //$log->LogInfo("Valor de la variable \$listaUmf: " . var_export ($listaUmf, true));
        //$log->LogInfo("Valor de la variable \$listaUmf: " . var_export ($idMunicipio, true));
        //$log->LogInfo("Valor de la variable \$response: " . var_export ($response, true));
    }
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] = "No se pudieron obtener direcciones";
    }
}

echo json_encode ($response);
?>


