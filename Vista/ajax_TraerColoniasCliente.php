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
    //$log = new KLogger ( "ajax_TraerColoniasCliente.log" , KLogger::DEBUG );
    $txtMunicipio = getValueFromPost ("txtMunicipio");
    try{ 

        $listaColonias = $negocio -> negocio_TraerColoniasCliente($txtMunicipio);
        $response ["datos"] = $listaColonias;

        //$log->LogInfo("Valor de la variable \$listaDirecciones: " . var_export ($listaDirecciones, true));
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


