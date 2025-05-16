<?php
session_start();
date_default_timezone_set('America/Mexico_City');
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio= new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");


	// $log = new KLogger ( "ajax_indicador.log" , KLogger::DEBUG );

if(!empty ($_POST))
{   
    $month = getValueFromPost ("month");
    $year = getValueFromPost ("anio");
    if($month <= "9"){
        $month = "0".$month;
    }
    try{

        $day2 = date("d", mktime(0,0,0, $month+1, 0, $year));
        $day1=date('d', mktime(0,0,0, $month, 1, $year));
        

        $fecha2=$year."-".$month."-".$day2;
        $fecha1=$year."-".$month."-".$day1;


        $altasMes = $negocio -> getAltasDelMes($month, $year);
        $bajasMes= $negocio -> getBajasDelMes($month, $year);
        

        $elementosVentas=$negocio ->getNumeroElementosPlantilla($fecha1,$fecha2);
        $numElementosGif=$negocio->getNumeroElementosGif($fecha1,$fecha2);
        
        $response ["altasMes"] = $altasMes;
        $response ["bajasMes"] = $bajasMes;
        $response ["numElementosGif"] = $numElementosGif;
        $response ["elementosVentas"] = $elementosVentas;

        // $log->LogInfo("Valor de la variable \$response: " . var_export ($response, true));
    }
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] = "No se pudo obtener datos";
    }
}
//$log->LogInfo("Valor de la variable \$response: " . var_export ($response, true));
echo json_encode ($response);

?>