<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");

	    // $log = new KLogger ( "ajax_getPuntosServiciosReporte2.log" , KLogger::DEBUG );
		$fecha1=getValueFromPost("fecha1");
		$fecha2=getValueFromPost("fecha2");

	try{
		

		$lista= $negocio -> getPuntosServicios($fecha1, $fecha2);
		


           for ($i = 0; $i < count($lista); $i++)
        {   

        	$turnosPorCobrar=0;
        	$turnos31=0;
            $idPuntoServicio = $lista[$i] ["idPuntoServicio"];
            $puntoServicio = $lista[$i] ["puntoServicio"];
            $numeroCentroCosto = $lista[$i] ["numeroCentroCosto"];
            $nombreEntidadFederativa = $lista[$i] ["nombreEntidadFederativa"];
            $razonSocial = $lista[$i] ["razonSocial"];
            $fechaInicioServicio = $lista[$i] ["fechaInicioServicio"];
            $cobraDescansos = $lista[$i] ["cobraDescansos"];
            $cobra31=$lista[$i]["cobra31"];
            $cobraDiaFestivo=$lista[$i]["cobraDiaFestivo"];

            $lista[$i]["requisiciones"]= $negocio -> getDetallesRequisiciones($idPuntoServicio,$fecha1, $fecha2);
            $lista[$i]["turnosPagados"]= $negocio -> getTurnosPagados($fecha1, $fecha2, $idPuntoServicio);
            $sumaDiasFestivos= $negocio -> getSumaDiasFestivosByFechaAndPuntoServicio($fecha1, $fecha2, $idPuntoServicio);

            //$log->LogInfo("Valor de la variable \$response punto: " . var_export ($lista[$i]["puntoServicio"], true));

            $coberturas= $negocio ->getAsistenciaByFechaAndPuntoServicio($fecha1, $fecha2, $idPuntoServicio);

            //$log->LogInfo("Valor de la variable \$coberturas : " . var_export ($coberturas, true));


            for ($j=0; $j < count($coberturas) ; $j++) {
            	
            

            		if($coberturas[$j]["nomenclaturaIncidencia"]=='DES' and $cobraDescansos==1){
            			
            			$valorTurnoCobro=1;

            		} else{

            		$valorTurnoCobro=$coberturas[$j]["valorCobertura"];
            		}
            	
            	
            	
            	$dia=substr($coberturas[$j]["fechaAsistencia"], 8);

            	if($dia==31){

            		$turnos31=$turnos31+$valorTurnoCobro;
            	}

            	

            	$turnosPorCobrar=$turnosPorCobrar+$valorTurnoCobro;

            	//$log->LogInfo("Valor de la variable \$turnosPorCobrar punto: " . var_export ($turnosPorCobrar, true));



            }

            if($cobra31==0){
            	$turnosPorCobrar=$turnosPorCobrar-$turnos31;
            }

            if($cobraDiaFestivo==1){
            	$turnosPorCobrar=$turnosPorCobrar+$sumaDiasFestivos["diasFestivos"];
            }

            //$log->LogInfo("Valor de la variable \$turnosPorCobrar punto: " . var_export ($turnosPorCobrar, true));



            $lista[$i]["turnosPorCobrar"]= $turnosPorCobrar;
            $lista[$i]["turnos31"]= $turnos31;

           	//$lista[$i]["detalles"] =$negocio ->  getDetallesRequisiciones2($idPuntoServicio,$fecha1, $fecha2);
           
        }

        
		$response["data"]= $lista;


		//$log->LogInfo("Valor de la variable \$response punto: " . var_export ($response, true));

	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se pudo obtener Empleados";
	}
/*
}
*/

echo json_encode($response);

?>