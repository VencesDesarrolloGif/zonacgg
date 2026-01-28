<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php"; 
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio(); 
verificarInicioSesion($negocio);
$response = array("status" => "success");
// $log = new KLogger ( "ajax_UpdateReplicacionPlantilla.log" , KLogger::DEBUG ); 
$txtTotalFacturaReplicacionplantilla=$_POST["txtTotalFacturaReplicacionplantilla"];
$txtCostoTurnoReplicacionplantilla1=$_POST["txtCostoTurnoReplicacionplantilla"];
$FechaMontajeReplicacionplantilla=$_POST["FechaMontajeReplicacionplantilla"];
$servicioPlantillaId=$_POST["servicioPlantillaId"];
$contraseniaInsertadaCifrada=$_POST["contraseniaInsertadaCifrada"];
$NumEmpModalBaja=$_POST["NumEmpModalBaja"];
$idPuntoServicio=$_POST["idPuntoServicio"];
$usuario = $_SESSION ["userLog"]["usuario"];
$txtCostoTurnoReplicacionplantilla = str_replace(',', '', $txtCostoTurnoReplicacionplantilla1);
// $log->LogInfo("Valor de post" . var_export ($_POST, true));

try {
    $negocio->ActualizarReplicacionPlantilla($txtTotalFacturaReplicacionplantilla,$txtCostoTurnoReplicacionplantilla,$FechaMontajeReplicacionplantilla,$servicioPlantillaId,$contraseniaInsertadaCifrada,$NumEmpModalBaja,$usuario,$idPuntoServicio);

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No Fue Posible Actualizar Peticion De Capacitación";
}

echo json_encode($response);
