<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");


$negocio= new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");

if(!empty ($_POST))
{

	$puestoId = getValueFromPost ("puestoId");
    try{

        $posiblesJefes = $negocio -> obtenerPosiblesJefesPorPuesto($puestoId);

        
        $response ["posiblesJefes"] = $posiblesJefes;
    }
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] = "No se pudieron obtener los posiblesJefes";
    }
}

echo json_encode ($response);
?>