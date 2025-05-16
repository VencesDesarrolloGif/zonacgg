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
$entidadempleado     = $_POST["entidadempleado"];
$consecutivoempleado = $_POST["consecutivoempleado"];
$categoriaempleado   = $_POST["categoriaempleado"];
$cuotanueva          = $_POST["cuotanueva"];
$sueldonuevo         = $_POST["sueldonuevo"];
$idpeticion          = $_POST["idpeticion"];
$accion              = $_POST["accion"];
try {
    $lista = $negocio->confirmarorechazarsueldo($entidadempleado, $consecutivoempleado, $categoriaempleado, $cuotanueva, $sueldonuevo, $idpeticion, $accion, $usuario);
    //$log->LogInfo("Valor de variable de lista:" . var_export ($lista, true));
    $response["data"] = $lista;
} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No se pudo obtener lista de sueldos de empleados";
}
echo json_encode($response);
