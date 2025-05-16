<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio            = new Negocio ();
$response           = array();
$response ["status"] = "success";
//$log = new KLogger ( "ajax_InsertRolOperativo.log" , KLogger::DEBUG );
$idTipoT    = $_POST['idTipoT'];
$descContrato = $_POST['descContrato']; 
$usuario = $_SESSION ["userLog"]["usuario"];
//$log->LogInfo("Valor de variable _SESSION" . var_export ($_POST, true));
//$log->LogInfo("Valor de variable _SESSION" . var_export ($_SESSION, true));
//$log->LogInfo("Valor de variable _SESSION" . var_export ($_SESSION, true));

try {
        $negocio->insertRolOperativo($idTipoT,$descContrato,$usuario);
    }
catch(Exception $e)
{
           $response["status"] = "error";
    }
    // $log->LogInfo("Valor de response" . var_export ($response, true));
echo json_encode($response);
?>

