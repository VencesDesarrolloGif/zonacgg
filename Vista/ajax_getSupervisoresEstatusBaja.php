<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");


$negocio= new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");

    try{

        $supervisores = $negocio -> getSupervisoresForTransferencia();
        
        $response ["supervisores"] = $supervisores;

        
    }
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] = "No se pudieron obtener los supervisores";
    }


echo json_encode ($response);
?>