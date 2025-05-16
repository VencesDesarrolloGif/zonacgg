<?php

session_start();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

$response = array ();

verificarInicioSesion($negocio);


	// $log = new KLogger ( "ajaxActualizarEstatusMovimientoFinanciero.log" , KLogger::DEBUG );

    $usuario = $_SESSION ["userLog"]["usuario"];
	
	$movimiento = array (

    "idEstatusM" => getValueFromPost("idEstatusM"),
    "usuarioCaptura" => $usuario,
    "idMovimiento" => getValueFromPost("idMovimiento") ,
    

   	);



	
		// $log->LogInfo("Valor de la variable \$movimiento: " . var_export ($movimiento, true));
    try
    {
        $negocio -> editarEstatusMovimientoFinanciero($movimiento);
        
        $response ["status"] = "success";
        $response ["message"] = "Movimiento Editado";
    } 
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }

echo json_encode ($response);
?>