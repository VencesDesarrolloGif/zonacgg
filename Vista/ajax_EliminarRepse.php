<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
//$log = new KLogger ( "ajaxeliminarRepse.log" , KLogger::DEBUG );
$response           = array();
$response["status"] = "error";
$idRep     = $_POST['idRep'];

try {
    $repse = $negocio->eliminarRepse($idRep);
             $response["status"] = "success";
   }catch (Exception $e) {
    $response["message"] = "Error al eliminarRepse";
    }
echo json_encode($response);