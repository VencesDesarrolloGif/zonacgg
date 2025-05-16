<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
// $log = new KLogger ( "ajax_UpdateFiniquitoVacacionesPendientes.log" , KLogger::DEBUG ); 
$entidad=$_POST["entidad"];
$consecutivo=$_POST["consecutivo"];
$tipo=$_POST["tipo"];
$TotalDias=$_POST["TotalDias"];
$contraseniaInsertadaCifrada=$_POST["contraseniaInsertadaCifrada"];
$NumEmpModalVacFin=$_POST["NumEmpModalVacFin"];
$usuarioCapturaVac = $_SESSION ["userLog"]["usuario"];
try {
    // $log->LogInfo("Valor de _POST  " . var_export ($_POST, true));
    //$log->LogInfo("Valor de NuevoIngresoAcumulable  " . var_export ($NuevoIngresoAcumulable, true));

    $negocio->UpdateFiniquitoVacacionesPendientes($entidad,$consecutivo,$tipo,$TotalDias,$contraseniaInsertadaCifrada,$NumEmpModalVacFin,$usuarioCapturaVac);//Dias De Vacaciones Tomadas
} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No Se Obtuvieron Los Dias Disponibles";
}

echo json_encode($response);
