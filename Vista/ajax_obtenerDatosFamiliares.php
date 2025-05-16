<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio= new Negocio();
verificarInicioSesion ($negocio);
$response = array("status" => "success");
if(!empty ($_POST)){
	//$log = new KLogger ( "ajaxObtenerDatosFamiliares.log" , KLogger::DEBUG );
    //$log->LogInfo("Valor de la variable \$idTipoEmpleado: " . var_export ($idTipoEmpleado, true));
    $empleadoId=getValueFromPost("numeroEmpleado");
    $empleadoidd = explode("-", $empleadoId);
    $idEntidadEmpleado=$empleadoidd[0];
    $cosecutivoEmpleado=$empleadoidd[1];
    $idTipoEmpleado=$empleadoidd[2];
    try{
        $listaFamiliares = $negocio -> negocio_obtenerDatosFamiliares($idEntidadEmpleado, $cosecutivoEmpleado, $idTipoEmpleado);
        $response ["listaFamiliares"] = $listaFamiliares;
    }
    catch (Exception $e){
        $response ["status"] = "error";
        $response ["message"] = "No se pudieron obtener Datos Familiares";
    }
}
echo json_encode ($response);
?>


