<?php

session_start();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

$response = array ();

verificarInicioSesion($negocio);


	//$log = new KLogger ( "ajax_updateFolioVaca.log" , KLogger::DEBUG );
    //$log->LogInfo("Valor de la variable post: " . var_export ($_POST, true));

    $empleadoEntidadId = getValueFromPost ("empleadoEntidadId");
    $empleadoConsecutivoId = getValueFromPost ("empleadoConsecutivoId");
    $empleadoTipoId = getValueFromPost ("empleadoTipoId");
    $empleadoPuntoServicioId = getValueFromPost ("empleadoPuntoServicioId");
    $inpFoliovacaciones = getValueFromPost ("inpFoliovacaciones");
    $asistenciaFecha = getValueFromPost ("asistenciaFecha");
	$AnioAniversario = getValueFromPost ("selectPeriodoInicio");
	
    try
    {
        $negocio -> UpdateAsistenciaFolioVacaciones($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$empleadoPuntoServicioId,$inpFoliovacaciones,$asistenciaFecha,$AnioAniversario);
        
        $response ["status"] = "success";
        $response ["message"] = "El Folio Se Cargo Correctamente A La Asistencia";
    } 
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] =  "Ocurrio Un error Al Actualizar La sistencia Con El folio De Vacaciones";
    }

echo json_encode ($response);
?>