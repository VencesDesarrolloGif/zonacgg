<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio (); 
$response = array ();     
$response ["status"] = "success";
verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajax_consultaultimofolio.log" , KLogger::DEBUG );
    try
    {        
        //$log->LogInfo("Valor de la variable \$lista: " . var_export (count($listaUniformes), true));
        $ultimoFolio= $negocio -> negocio_consultaultimofolioenviarLavanderia();
        $ultimofolioGenerado=$ultimoFolio['folioEnvioLavanderia'];
        $response["datos"]= $ultimofolioGenerado;
        //$log->LogInfo("Valor de la variable \$ultimoFolio: " . var_export ($ultimofolioGenerado, true));    
    } 
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }


echo json_encode ($response);
?> 