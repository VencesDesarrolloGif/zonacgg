<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();   
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_UpdateBajaPlantilla.log" , KLogger::DEBUG ); 
$servicioPlantillaId=$_POST["servicioPlantillaId"];
$contraseniaInsertadaCifrada=$_POST["contraseniaInsertadaCifrada"];
$NumEmpModalBaja=$_POST["NumEmpModalBaja"];
$idMoivoBajaForzada=$_POST["idMoivoBajaForzada"];
$usuario = $_SESSION ["userLog"]["usuario"];
//$log->LogInfo("Valor de idpuntoservicio" . var_export ($idpuntoservicio, true));

try {
    $negocio->ActualizarBajaPlantilla($servicioPlantillaId,$contraseniaInsertadaCifrada,$NumEmpModalBaja,$usuario,$idMoivoBajaForzada);
   // $response["datos"] = $RevisionPeticionM;
    

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No Fue Posible Actualizar Peticion De Capacitación";
}

echo json_encode($response);
