<?php

session_start();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

$response = array ();

verificarInicioSesion($negocio);


	//$log = new KLogger ( "ajax_updatePuntoServicio.log" , KLogger::DEBUG );

    $usuario = $_SESSION ["userLog"]["usuario"];
	
	$puntoServicio = array (
	"idPuntoServicio" => getValueFromPost("idPuntoServicio"),
    "nombrePuntoFacturacion" =>  strtoupper(getValueFromPost("nombrePuntoFacturacion")),
    "centroCostoFacturacion" => strtoupper(getValueFromPost("centroCostoFacturacion")),
   

   	);

    try
    {
        $negocio -> updatePuntoServicioFacturacion($puntoServicio);
        
        $response ["status"] = "success";
        $response ["message"] = "El punto de servicio fue Editado";
    } 
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }

echo json_encode ($response);
?>