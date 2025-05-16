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
    //$log = new KLogger ( "ajax_TraerMunicipiosCliente.log" , KLogger::DEBUG );
    $Accion = getValueFromPost ("Accion");
    $txtEntidadCliente = getValueFromPost ("txtEntidadCliente");
    try{

        $listaMunicipios = $negocio -> negocio_TraerMunicipiosCliente($txtEntidadCliente);
        $response ["datos"] = $listaMunicipios; 

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


