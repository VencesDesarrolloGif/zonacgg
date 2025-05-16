<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_UpdateDeleteArchivoBajaEmpleado.log" , KLogger::DEBUG );
$numeroEmpleado=$_POST["numeroEmpleado"];
$fechaBaja=$_POST["fechaBaja"];
$caso=$_POST["caso"];
$usuarioProcesarBaja = $_SESSION ["userLog"]["usuario"]; 
//$log->LogInfo("Valor de _POST" . var_export ($_POST, true));

try {
   	$negocio->actualizarBorrarArchivoBajaEmpleado($numeroEmpleado,$fechaBaja,$caso,$usuarioProcesarBaja);
   // $response["datos"] = $RevisionPeticionM;
    

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No Se Obtuvieron Puestos";
}

echo json_encode($response);
