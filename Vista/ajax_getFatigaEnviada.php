<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");


$negocio= new Negocio();

verificarInicioSesion ($negocio);

// $log = new KLogger ( "ajax_getFatigaEnviada.log" , KLogger::DEBUG );

$month= getValueFromPost ("month");
$year=getValueFromPost("year");
$puntoServicioFatigaId=getValueFromPost("idPuntoServicio");

//$day = date("d", mktime(0,0,0, $month+1, 0, $year));

//$fecha1=$year."-".$month."-"."01";
//$fecha2=$year."-".$month."-".$day;

//$log->LogInfo("Valor de la variable \$month: " . var_export ($month, true));
//$log->LogInfo("Valor de la variable \$year: " . var_export ($year, true));
//$log->LogInfo("Valor de la variable \$puntoServicioFatigaId: " . var_export ($puntoServicioFatigaId, true));


$response = array("status" => "success");

    try{

        if($_SESSION ["userLog"]["rol"]=="Facturacion"){
      
        $fatiga1= $negocio -> getFatigasEnviadas($puntoServicioFatigaId, $month, $year, 1);
        
        

        //$fatiga2= $negocio -> getFatigasEnviadas($puntoServicioFatigaId, $month, $year, 2);

        if (count($fatiga1)==0){

            $response["fatiga1"] = "NO ENVIADA";


       }


        
        //$response["fatiga2"] = $fatiga2;

        //$log->LogInfo("Valor de la variable \$fatiga1 \$puntoServicioFatigaId : " . var_export ($fatiga1, true));
        //$log->LogInfo("Valor de la variable \$fatiga2: \$puntoServicioFatigaId " . var_export ($fatiga2, true));
        



        }
                
    }
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] = "No se pudieron obtener los puntos";
    }
// $log->LogInfo("Valor de la variable \$response: " . var_export ($response, true));
echo json_encode ($response);
?>