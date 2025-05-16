<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
// $log = new KLogger ( "ajaxInsertRecepcionTMP.log" , KLogger::DEBUG );
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array ();
$response ["status"] = "error";
$idUniforme =getValueFromPost("idUniforme");
$estatusRecepcion=getValueFromPost("estatusRecepcion");
$entidadUsuario  =getValueFromPost("entidadUsuario");
$usuarioCaptura= $_SESSION ["userLog"]["usuario"];
$fechaAsignacion =getValueFromPost("fechaAsignacion");
$tipoMerca  =getValueFromPost("tipoMerca");
$monto      =getValueFromPost("monto");
$idUniformeSupervisor=getValueFromPost("idUniformeSupervisor");
$empleadoId =getValueFromPost("numeroEmpleado");
$porcentajeCobro =getValueFromPost("porcentajeCobro");
$coberturaEmpleado =getValueFromPost("coberturaEmpleado");
$costoActualUniforme =getValueFromPost("costoActualUniforme");
$sucursalUsuario =getValueFromPost("sucursalUsuario");
//$log->LogInfo("Valor de empleadoId" . var_export ($empleadoId, true));
try {
     $empleadoidd = explode("-", $empleadoId);
     $empleadoEntidad    =$empleadoidd[0];
     $empleadoConsecutivo=$empleadoidd[1];
     $empleadoCategoria  =$empleadoidd[2];

     $insertInfoAlmFin = $negocio->insertRecepcionTMP($idUniforme,$empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria,$estatusRecepcion,$entidadUsuario,$usuarioCaptura,$fechaAsignacion,$tipoMerca,$monto,$idUniformeSupervisor,$porcentajeCobro,$coberturaEmpleado,$costoActualUniforme,$sucursalUsuario);
     $response ["status"] = "success";
    }catch(Exception $e){
           $response["status"] = "error";
       }
     // $log->LogInfo("Valor de response" . var_export ($response, true));
echo json_encode($response);
?>