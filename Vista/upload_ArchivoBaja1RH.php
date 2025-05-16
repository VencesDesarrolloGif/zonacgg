<?php
session_start ();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion($negocio);
// Obtenemos los datos del empleado
//$log = new KLogger ( "upload_ArchivoBaja1RH.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _FILES : " . var_export ($_FILES, true));
//$log->LogInfo("Valor de la variable _POST : " . var_export ($_POST, true));
$response = array ();
$response["status"] = "success";  


$MotivoBaja=$_POST["motivoBaja"]; 
$especifiqueMotivo1=$_POST["comentarioBaja"]; 
$numempleadoFirmahiddenRh=$_POST["numempleadoFirmahiddenRh"];  
$explodenumempFirma=explode("-",$numempleadoFirmahiddenRh);
$empleadoEntidadFirma=$explodenumempFirma[0];
$empleadoConsecutivoFirma=$explodenumempFirma[1]; 
$empleadoCategoriaFirma=$explodenumempFirma[2];
$FirmaInterna=$_POST["FirmaInternaRh"]; 
$asistenciaFecha=$_POST["fechaBaja"]; 
$FechaBajaEmpModal = date("Y-m-d");
$numeroEmpleado=$_POST["numeroEmpleado"];
$explodenumemp=explode("-",$numeroEmpleado);
$empleadoEntidadId=$explodenumemp[0];
$empleadoConsecutivoId=$explodenumemp[1];
$empleadoTipoId=$explodenumemp[2];
$usuarioRegistroFirma = $_SESSION ["userLog"]["usuario"]; 
$NombreEmpleado=$_POST["txtNombreEmpleadoModal"]; 
$Estado=$_POST["idEndidadFederativaEdited"]; 
$PuntoServicio=$_POST["selectPuntoServicioEdited"]; 
$Cliente=$_POST["clienteBajaRh"]; 
$NombreSupervisor=$_POST["dirigenteEdited"]; 
$FirmaInternaGuardiaRh=$_POST["FirmaInternaGuardiaRh"];
$ComentarioBetado=$_POST["ComentarioBetado"];
$banderaBetado=$_POST["banderaBetado"];

$ModuloBaja="RH";

try {
    $negocio -> InsertarRegistoArchivoBajaEmpleado($MotivoBaja,$especifiqueMotivo1,$empleadoEntidadFirma,$empleadoConsecutivoFirma,$empleadoCategoriaFirma,$FirmaInterna,$asistenciaFecha,$FechaBajaEmpModal,$empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$usuarioRegistroFirma,$NombreEmpleado,$Estado,$PuntoServicio,$Cliente,$NombreSupervisor,$ModuloBaja,$FirmaInternaGuardiaRh,$banderaBetado,$ComentarioBetado);
    $response["message"]='Baja Registrada Exitosamente';

} catch (Exception $e) {
    $response["status"] = "error";
    $response["message"]='Registro Fallido';
}
echo json_encode($response);

?> 