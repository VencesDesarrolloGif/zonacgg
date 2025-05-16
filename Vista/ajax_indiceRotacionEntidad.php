<?php
session_start();
date_default_timezone_set('America/Mexico_City'); 
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio= new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");


	// $log = new KLogger ( "ajax_indicadorEntidad.log" , KLogger::DEBUG );
	// $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
if(!empty ($_POST))
{   
    $month = getValueFromPost ("month");
    $year = getValueFromPost ("anio");
    $entidadId = getValueFromPost ("entidadId");
    try{

        $day2 = date("d", mktime(0,0,0, $month+1, 0, $year));
        $day1=date('d', mktime(0,0,0, $month, 1, $year));
        
        $fecha2=$year."-".$month."-".$day2;
        $fecha1=$year."-".$month."-".$day1;

        $altasMes = $negocio -> getAltasDelMesByEntidad($month, $year,$entidadId);
        $bajasMes= $negocio -> getBajasDelMesByEntidad($month,$year,$entidadId);
        $elementosVentas=$negocio ->getNumeroElementosPlantillaByEntidad($fecha1, $fecha2, $entidadId);
        

        $plantillaGif= $negocio -> getEmpleadosByRangoFecha($fecha1,$fecha2);
        $numElementosGif=$negocio->getNumeroElementosGifByEntidad($fecha1, $fecha2,$entidadId);
        
        $response ["altasMes"] = $altasMes;
        $response ["bajasMes"] = $bajasMes;
        $response ["numElementosGif"] = $numElementosGif;
        $response ["elementosVentas"] = $elementosVentas;

        //$log->LogInfo("Valor de la variable \$folioRequisicion: " . var_export ($folioRequisicion, true));
        //$log->LogInfo("Valor de la variable \$response: " . var_export ($response, true));
    }
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] = "No se pudo obtener información";
    }
}

echo json_encode ($response);

?>