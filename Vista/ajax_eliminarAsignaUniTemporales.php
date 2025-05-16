<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
// $log = new KLogger ( "ajaxElimAsigUniTMP.log" , KLogger::DEBUG );
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array ();
$response ["status"] = "error";
$usuario = $_SESSION ["userLog"]["usuario"];

try {
     $ElimUni = $negocio->eliminarTMP($usuario);
     $response ["status"] = "success";
    }catch(Exception $e){
           $response["status"] = "error";
          }
    // $log->LogInfo("Valor de response" . var_export ($response, true));
echo json_encode($response);
?>



