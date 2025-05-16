<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_getSueldosEmpleados.log" , KLogger::DEBUG );
$usuario             = $_SESSION["userLog"]["usuario"];
$idIncidenciaEspecial     = $_POST["idIncidenciaEspecial"];
$accion = $_POST["accion"];
  
try {
    $lista = $negocio->confirmarorechazarpeticionincidencia($idIncidenciaEspecial, $accion); 
    //$log->LogInfo("Valor de variable de lista:" . var_export ($lista, true));
    $response["data"] = $lista;
} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No se pudo realizar ninguna accion";
}
echo json_encode($response);
