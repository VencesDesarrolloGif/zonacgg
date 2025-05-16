<?php
session_start();
require_once("../../libs/logger/KLogger.php");
require_once ("../Helpers.php");
$response           = array();
 // $log = new KLogger ( "ajax_ObtenerIpLocal.log" , KLogger::DEBUG );
 // $log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
// $response["SERVER_PORT"] = $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]);
$response["SERVER_NAME"] = $_SERVER["SERVER_NAME"];
$response["status"]= "success";
    echo json_encode($response);

   