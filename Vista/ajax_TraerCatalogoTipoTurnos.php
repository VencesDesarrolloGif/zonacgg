<?php
    session_start();
    require_once("../Negocio/Negocio.class.php");
    require_once ("Helpers.php");
    require_once("../libs/logger/KLogger.php");
    $negocio= new Negocio();
    verificarInicioSesion ($negocio);
    $response = array("status" => "success"); 
    try{
            $datos = $negocio -> obtenerCatalogoTipoTurnos();
            $response ["datos"] = $datos;
       //     $log->LogInfo("Valor de la variable \$responseajax de puesto segun tipo: " . var_export ($response, true));
        } 
        catch (Exception $e)
        {
            $response ["status"] = "error";
            $response ["message"] = "No se pudieron obtener los puestos";
        }
    echo json_encode ($response); 
?>