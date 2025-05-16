<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");


$negocio= new Negocio();

verificarInicioSesion ($negocio);

//$log = new KLogger ( "ajaxGetPuntosAndResponsables.log" , KLogger::DEBUG );

//$month= getValueFromPost ("month");
//$year=getValueFromPost("year");

$month= getValueFromPost ("month");
$year=getValueFromPost("year");

$day = date("d", mktime(0,0,0, $month+1, 0, $year));

$fecha1=$year."-".$month."-"."01";
$fecha2=$year."-".$month."-".$day;

//$log->LogInfo("Valor de la variable \$fecha1: " . var_export ($fecha1, true));
//$log->LogInfo("Valor de la variable \$fecha2: " . var_export ($fecha2, true));


$response = array("status" => "success");


    try{


        if($_SESSION ["userLog"]["rol"]=="Facturacion"){

        $puntos = $negocio -> getPuntosServiciosAndResponsables($fecha1, $fecha2);
        //$log->LogInfo("Valor de la variable \$supervisorTipo: " . var_export ($puntos, true));
        
        //$response ["puntos"] = $puntos;

        for($i=0; $i<count($puntos); $i++){

            $idPuntoServicio=$puntos[$i]["idPuntoServicio"];
            $puntoServicio=$puntos[$i]["puntoServicio"];
            $razonSocial=$puntos[$i]["razonSocial"];
            $nombreSupervisor=$puntos[$i]["nombreSupervisor"];
            
            $puntos [$i]["fatiga1"]=$negocio->getFatigasEnviadas($idPuntoServicio, $month, $year, 1);
            $puntos [$i]["fatiga2"]=$negocio->getFatigasEnviadas($idPuntoServicio, $month, $year, 2);

            
        }
        $response ["puntos"] = $puntos;

        //$log->LogInfo("Valor de la variable \$responseajax de puntos segun tipo: " . var_export ($response, true));

        }

        
        
    }
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] = "No se pudieron obtener los puntos";
    }
//$log->LogInfo("Valor de la variable \$response: " . var_export ($response, true));
echo json_encode ($response);
?>