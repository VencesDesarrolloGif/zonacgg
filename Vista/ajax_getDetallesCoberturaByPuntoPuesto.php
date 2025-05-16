
 <?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajax_getDetallesCoberturaByPuntoPuesto.log" , KLogger::DEBUG );

$response = array("status" => "success");

if (!empty ($_POST))
{

	try{

		$month=getValueFromPost("month");
		$year=getValueFromPost("year");
		$puntoServicioId=getValueFromPost("puntoServicioId");
		$puestoId=getValueFromPost("puestoId");
		$idEntidadFederativa=getValueFromPost("idEntidadFederativa");

		//$log->LogInfo("Valor de la variable \$puntoServicioId: " . var_export ($puntoServicioId, true));
		//$log->LogInfo("Valor de la variable \$puestoId: " . var_export ($puestoId, true));
		//$log->LogInfo("Valor de la variable \$idPuntoServicio: " . var_export ($idPuntoServicio, true));
	    // ajax_getDetallesCoberturaByPuntoPuesto.php

	    $fecha1= date('Y-m-d', mktime(0,0,0, $month, 1, $year));
	    $fecha2= date("Y-m-d", mktime(0,0,0, $month+1, 0, $year));

	    //$log->LogInfo("Valor de la variable \$fecha1: " . var_export ($fecha1, true));
	    //$log->LogInfo("Valor de la variable \$fecha2: " . var_export ($fecha2, true));
		//$log->LogInfo("Valor de la variable \$lista: " . var_export ($response, true));
//
		$datosRequisicion= $negocio -> getDetallesRequisicionByPuntoServicioIdAndPuesto($puntoServicioId, $puestoId, $fecha1, $fecha2);
		
		$turnosPagadosNomina= $negocio-> getTurnosPagadosNomina($puntoServicioId, $puestoId, $fecha1, $fecha2);

		$montoPagado=$negocio -> getMontoPagadoByPuntoPuestoFecha($puntoServicioId, $puestoId, $fecha1, $fecha2);
		
		//$log->LogInfo("Valor de la variable \$datosRequisicion: " . var_export ($datosRequisicion, true));
		//$log->LogInfo("Valor de la variable \$turnosPagadosNomina: " . var_export ($turnosPagadosNomina, true));

		$totalElementos=0;
		$totalTurnosDiarios=0;
		$totalTurnosPeriodo=0;
		$dias=0;

		if(count($datosRequisicion)==0){

			$response["totalElementos"]=0;
	    	$response["totalTurnosDiarios"]=0;
	    	$response["turnosPeriodo"]=0;
	    	$response["costoPorTurno"]=0;

		}else{

			for ($i = 0; $i < count($datosRequisicion); $i++)
	    	{
	        $fechaInicio = $datosRequisicion [$i]["fechaInicio"];
	        $fechaTermino= $datosRequisicion [$i]["fechaTerminoPlantilla"];
	        $costoPorTurno=$datosRequisicion [$i]["costoPorTurno"];

	        $totalElementos+=$datosRequisicion [$i]["elementosSolicitados"];
	        $totalTurnosDiarios+=$datosRequisicion [$i]["turnosPorDia"];


	        if($fechaInicio<$fecha1){

	        	$start_time=$fecha1;

	        }else{

	        	$start_time=$fechaInicio;

	        }

	        if($fechaTermino<$fecha2){

	        	$end_time=$fechaTermino;

	        }else{

	        	$end_time=$fecha2;

	        }
	        $dias=0;

	        for($l=$start_time;$l<=$end_time;$l = date("Y-m-d", strtotime($l ."+ 1 days"))){
	        	$dias=$dias+1;
	        	

	        }
        
	        $turnosPeriodo=$dias*$totalTurnosDiarios;
	        //$totalTurnosPeriodo+=$turnosPeriodo;

	        //$log->LogInfo("Valor de la variable \$dias: " . var_export ($dias, true));
	        //$log->LogInfo("Valor de la variable \$totalTurnosDiarios: " . var_export ($totalTurnosDiarios, true));
	        //$log->LogInfo("Valor de la variable \$totalTurnosPeriodo: " . var_export ($totalTurnosPeriodo, true));

	        //$datosRequisicion[$i]["totalElementos"]= $totalElementos;
	        //$datosRequisicion[$i]["totalTurnosDiarios"]= $totalTurnosDiarios;
	        //$datosRequisicion[$i]["totalTurnosPeriodo"]= $totalTurnosPeriodo;
	    	}
	    

    		//$response["datos"]= $datosRequisicion;
	    	$response["totalElementos"]=$totalElementos;
	    	$response["totalTurnosDiarios"]=$totalTurnosDiarios;
	    	$response["turnosPeriodo"]=$turnosPeriodo;
	    	$response["costoPorTurno"]=$costoPorTurno;


	    	
		}

		$response["turnosPagadosNomina"]=$turnosPagadosNomina["turnosPagadosNomina"];
		$response["montoPagado"]=$montoPagado["montoPagado"];
		$response["idEntidadFederativa"]=$idEntidadFederativa;

	} catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se puedo obtener datos";
	}

}else{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}


//$log->LogInfo("Valor de la variable \$response: " . var_export ($response, true));

echo json_encode($response);

?>