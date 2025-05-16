<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();  
$response = array(); 
verificarInicioSesion($negocio);

//$log = new KLogger("ajax_UpdateCostoPlantilla.log", KLogger::DEBUG);
$usuario            = $_SESSION["userLog"]["usuario"];
$punto              = getValueFromPost("txtPuntoServicioIdEdited");

$servicioPlantillaId = getValueFromPost("servicioPlantillaId");
$contraseniaInsertadaCifrada = getValueFromPost("contraseniaInsertadaCifrada");
$NumEmpModalBaja = getValueFromPost("NumEmpModalBaja");
$TotalFacturaEdited = getValueFromPost("txtTotalFacturaEdited");
$costoTurno         = str_replace('$', '', getValueFromPost("txtCostoTurnoEdited"));
$CostoTurnoEdited = str_replace(',', '', $costoTurno);
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));

//$log->LogInfo("Valor de la variable \$requisicion: " . var_export ($requisicion, true));
try
{
    $negocio->updateRequisicionCosto($usuario,$servicioPlantillaId,$contraseniaInsertadaCifrada,$NumEmpModalBaja,$TotalFacturaEdited,$CostoTurnoEdited);
    $response["status"]  = "success";
    $response["message"] = "La requisicion fue editada";

} catch (Exception $e) {
    $response["status"]  = "error";
    $response["message"] = $e->getMessage();
}

echo json_encode($response);
