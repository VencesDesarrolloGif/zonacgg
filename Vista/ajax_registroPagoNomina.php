 <?php
//session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

//verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajax_registroPagoNomina.log" , KLogger::DEBUG );

$response = array("status" => "success");

	

		//$month=getValueFromPost("month");
		//$year=getValueFromPost("year");
		//$puntoServicioId=getValueFromPost("puntoServicioId");
		//$puestoId=getValueFromPost("puestoId");
		//$idEntidadFederativa=getValueFromPost("idEntidadFederativa");

		//$log->LogInfo("Valor de la variable \$puntoServicioId: " . var_export ($puntoServicioId, true));
		//$log->LogInfo("Valor de la variable \$puestoId: " . var_export ($puestoId, true));
		//$log->LogInfo("Valor de la variable \$idPuntoServicio: " . var_export ($idPuntoServicio, true));
	    // ajax_getDetallesCoberturaByPuntoPuesto.php

	    //$fecha1= date('Y-m-d', mktime(0,0,0, $month, 1, $year));
	    //$fecha2= date("Y-m-d", mktime(0,0,0, $month+1, 0, $year));

	    $fecha1="2017-01-16";
	    $fecha2="2017-01-31";

	    //$log->LogInfo("Valor de la variable \$fecha1: " . var_export ($fecha1, true));
	    //$log->LogInfo("Valor de la variable \$fecha2: " . var_export ($fecha2, true));

			$listaEmpleados= $negocio -> getEmpleadosByRangoFecha($fecha1, $fecha2);
			
	
		    for ($i = 0; $i < 5; $i++)
		    {
		        $empleadoEntidadId = $listaEmpleados [$i]["entidadFederativaId"];
		        $empleadoConsecutivoId = $listaEmpleados [$i]["empleadoConsecutivoId"];
		        $empleadoTipoId = $listaEmpleados [$i]["empleadoCategoriaId"];
		        echo $empleadoEntidadId."-".$empleadoConsecutivoId."-".$empleadoTipoId."<br>";

		        $asistencia= $negocio -> getAsistenciaByEmpleadoPeriodo ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId);
		        echo json_encode ($asistencia);
		        //$listaEmpleados [$i]["turnosExtras"] = $negocio -> getSumaTurnosExtras ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId);
		        //$listaEmpleados [$i]["descuentos"] = $negocio -> getSumDescuentos ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId);
		        //$listaEmpleados [$i]["incidenciasEspeciales"] = $negocio -> getSumaIncidenciasEspeciales ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId);
		        //$listaEmpleados [$i]["diasFestivos"] = $negocio -> getSumaDiasFestivos ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId);
		        //$asistenciaEmpleado = $negocio -> getAsistenciaByEmpleadoPeriodo ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId);
		        //echo $empleadoEntidadId."-".$empleadoConsecutivoId."-".$empleadoTipoId." ".$asistenciaEmpleado."<br>";
		        //json_encode ($listaEmpleados [$i]["asistencia"]);

		        //echo count($listaEmpleados [$i]["asistencia"]);
		        
		        
		        $turnos=0;
		        for($j=0; $j<count($asistencia); $j++){

		        	$turnos=$turnos+$asistencia[$j]["valorAsistencia"];
		        	

		        	
		        	
		        	

		        }

		        echo $empleadoEntidadId."-".$empleadoConsecutivoId."-".$empleadoTipoId."-".$turnos."<br>";
				
		        
		        
		        
	    	}
	    	$response["listaEmpleados"]= $listaEmpleados;
	    	//$log->LogInfo("Valor de la variable \$response: " . var_export ($response, true));
	    	//echo json_encode($response);


?>