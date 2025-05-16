<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
$caso=getValueFromPost ("caso");
$pregunta1=getValueFromPost ("pregunta1");
$pregunta2=getValueFromPost ("pregunta2");

//$log = new KLogger ( "ajax_obtenerEntidadGeneral.log" , KLogger::DEBUG );
   try {
        $Municipios = $negocio->GetPreguntasPorCasos($caso,$pregunta1,$pregunta2);
        $response["datos"] = $Municipios;
       } 
    catch (Exception $e) {
        $response["status"] = "error";
        $response["error"]  = "No se puedo obtener lista de Municipios";
        //$log->LogInfo("Valor de la variable response: " . var_export ($response, true));

    }
echo json_encode($response);
 