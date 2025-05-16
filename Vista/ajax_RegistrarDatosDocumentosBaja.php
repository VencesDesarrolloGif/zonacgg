<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio (); 

$response = array ();
$response ["status"] = "error"; 
verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajax_RegistrarDatosDocumentosBaja.log" , KLogger::DEBUG );


$banderaBetadoAsistencia=getValueFromPost("banderaBetadoAsistencia");
$ComentarioBetadoAsistencia=getValueFromPost("ComentarioBetadoAsistencia");
$MotivoBaja=getValueFromPost("MotivoBaja");
$especifiqueMotivo1=getValueFromPost("especifiqueMotivo1");
$numempleadoFirmahidden=getValueFromPost("numempleadoFirmahidden");
$FirmaInterna=getValueFromPost("FirmaInterna");
$asistenciaFecha=getValueFromPost("asistenciaFecha");
$FechaBajaEmpModal=getValueFromPost("FechaBajaEmpModal");
$empleadoEntidadId=getValueFromPost("empleadoEntidadId");
$empleadoConsecutivoId=getValueFromPost("empleadoConsecutivoId");
$empleadoTipoId=getValueFromPost("empleadoTipoId"); 
$numempleado = $empleadoEntidadId . "-" . $empleadoConsecutivoId . "-" . $empleadoTipoId; 
$usuarioRegistroFirma = $_SESSION ["userLog"]["usuario"];
$usuariorol = $_SESSION ["userLog"]["rol"];
$empleadoidd = explode("-", $numempleadoFirmahidden);
$empleadoEntidadFirma=$empleadoidd[0];
$empleadoConsecutivoFirma=$empleadoidd[1];
$empleadoCategoriaFirma=$empleadoidd[2];
$ModuloBaja="Supervisor";
$FirmaInternaGuardiaRh='BajaSupervisor';
//$log->LogInfo("Valor de la variable poos: " . var_export ($usuariorol, true));

try{ 
    $datos= $negocio -> getDatosEmpBaja($numempleado,$usuariorol);
    //$log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));
    //$log->LogInfo("Valor de la variable numempleado: " . var_export ($numempleado, true));
    //$log->LogInfo("Valor de la variable usuariorol: " . var_export ($usuariorol, true));
    $NombreEmpleado = $datos[0]["NombreEmpleado"];
    $Estado = $datos[0]["Estado"];
    $PuntoServicio = $datos[0]["PuntoServicio"];
    $Cliente = $datos[0]["Cliente"];
    $NombreSupervisor = $datos[0]["NombreSupervisor"];
    if($NombreSupervisor=="" || $NombreSupervisor==null || $NombreSupervisor=="null" || $NombreSupervisor==NULL || $NombreSupervisor=="NULL"){
        $NombreSupervisor="Sin Supervisor";
    }
    
    $negocio -> InsertarRegistoArchivoBajaEmpleado($MotivoBaja,$especifiqueMotivo1,$empleadoEntidadFirma,$empleadoConsecutivoFirma,$empleadoCategoriaFirma,$FirmaInterna,$asistenciaFecha,$FechaBajaEmpModal,$empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$usuarioRegistroFirma,$NombreEmpleado,$Estado,$PuntoServicio,$Cliente,$NombreSupervisor,$ModuloBaja,$FirmaInternaGuardiaRh,$banderaBetadoAsistencia,$ComentarioBetadoAsistencia);
    $response["status"]="success";
    $response["message"]="El registro de la baja del empleado fue exitoso";
}catch( Exception $e )
    {
    $response["status"]="error";
    $response["message"]="No Fue posible registrar baja empleado datos incorrectos";
    }
echo json_encode ($response);

?>

