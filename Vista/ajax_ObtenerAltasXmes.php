<?php
session_start();
date_default_timezone_set('America/Mexico_City');
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
//$log = new KLogger ( "ajaxObtenerAltasXmes.log" , KLogger::DEBUG );
$negocio= new Negocio();
verificarInicioSesion ($negocio);
$response = array("status" => "success");
if(!empty ($_POST))
{   
    $month = getValueFromPost ("month");
    $year = getValueFromPost ("anio");
    $lineaNegocio = getValueFromPost ("lineaNegocio");
    //$log->LogInfo("Valor de la variable LineaNegocio: " . var_export ($lineaNegocio, true));
    try{
        $day2 = date("d", mktime(0,0,0, $month+1, 0, $year));
        $day1 = date('d', mktime(0,0,0, $month, 1, $year));
        
        $fecha2=$year."-".$month."-".$day2;
        $fecha1=$year."-".$month."-".$day1;

        $altasMes = $negocio -> ObtenerAltasDelMes($month, $year, $lineaNegocio);
        $bajasMes = $negocio -> ObtenerBajasDelMes($month, $year, $lineaNegocio);
        
        $elementosVentas=$negocio ->ObtenerNumeroElementosPlantilla($fecha1,$fecha2,$lineaNegocio);
        $numElementosGif=$negocio->ObtenerNumeroElementosGif($fecha1,$fecha2,$lineaNegocio);
        
        $response ["altasMes"] = $altasMes;
        $response ["bajasMes"] = $bajasMes;
        $response ["numElementosGif"] = $numElementosGif;
        $response ["elementosVentas"] = $elementosVentas;
    }
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] = "No se pudo obtener datos";
    }
}
echo json_encode ($response);
?>