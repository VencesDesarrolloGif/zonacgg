<?php
session_start();
require_once("../../libs/logger/KLogger.php");
require "../conexion.php";
// $log = new KLogger ( "ajax_ConsultaPendientesCRP.log" , KLogger::DEBUG );
$response = array("status" => "success");
$pendientesCRP= array ();

	try{
		////////////////////Se Obtienen Las Entidades Para La Consulta General Divida Por Entidades Y mandarlas  encapsuladas ////////////////////////////
		$sql = "SELECT concat_ws('-',
        			   e.entidadFederativaId,
        			   e.empleadoConsecutivoId,
        			   e.empleadoCategoriaId) as numeroEmpleado,
		 			   e.entidadFederativaId,
        			   e.empleadoConsecutivoId,
        			   e.empleadoCategoriaId,
					   concat_ws(' ',
        			   e.nombreEmpleado,
        			   e.apellidoPaterno,
        			   e.apellidoMaterno) as nombreEmpleado,
        			   di.registroPatronal,
        			   di.rpParaActualizar,
        			   cps.puntoServicio,
        			   ef.nombreEntidadFederativa
			    FROM  datosimss di
                LEFT JOIN empleados e on (e.entidadFederativaId=di.empladoEntidadImss AND e.empleadoConsecutivoId=di.empleadoConsecutivoImss AND e.empleadoCategoriaId=di.empleadoCategoriaImss)
                LEFT JOIN catalogopuntosservicios cps on e.empleadoIdPuntoServicio=cps.idPuntoServicio
                LEFT JOIN entidadesfederativas ef on ef.idEntidadFederativa=e.idEntidadTrabajo
                WHERE cambioRPxPS='1'"; 

    	$res = mysqli_query($conexion, $sql);
        while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
           	$pendientesCRP[] = $reg;
        }
		

		for ($i=0; $i < count($pendientesCRP); $i++){

			$entidadFederativaEmp= $pendientesCRP[$i]["entidadFederativaId"];
			$empleadoConsecutivoEmp= $pendientesCRP[$i]["empleadoConsecutivoId"];
			$empleadoCategoriaEmp= $pendientesCRP[$i]["empleadoCategoriaId"];
			$registroPatronalEmp= $pendientesCRP[$i]["registroPatronal"];
			$rpParaActualizarEmp= $pendientesCRP[$i]["rpParaActualizar"];
			$numeroEmpleado= $pendientesCRP[$i]["numeroEmpleado"];

			$nombreEmpleado= $pendientesCRP[$i]["nombreEmpleado"];
			$nombreEmpleado=str_replace(' ', '-', $nombreEmpleado);
			// $nombreEmpleado= $pendientesCRP[$i]["nombreEmpleado"];
			// $apellidoPaterno= $pendientesCRP[$i]["apellidoPaterno"];
			// $apellidoMaterno= $pendientesCRP[$i]["apellidoMaterno"];

        $pendientesCRP[$i]["cambiarRP"]="<img align='center' style='width: 24%;align=center' title='Modificar' src='img/editarEmpleado.png' class='cursorImg' id='cambiarRP' onclick=consultarRegistrosPatronales(\"".$entidadFederativaEmp."\",\"".$empleadoConsecutivoEmp."\",\"".$empleadoCategoriaEmp."\",\"".$registroPatronalEmp."\",\"".$numeroEmpleado."\",\"".$rpParaActualizarEmp."\",\"".$nombreEmpleado."\")>"; 
        
        $pendientesCRP[$i]["rechazarCRP"]="<img align='center' style='width: 24%;align=center' title='Rechazar' src='img/rechazarImss.png' class='cursorImg' id='btnRechazarCRP' onclick=cancelarCRP('$entidadFederativaEmp','$empleadoConsecutivoEmp','$empleadoCategoriaEmp')>"; 
		}

		$response["datos"]= $pendientesCRP;	
       	
	}catch(Exception $e ){
		$response["status"]="error";
		$response["error"]="No se puedo obtener Empleado";
	}
// $log->LogInfo("Valor de la variable response: " . var_export ($response, true));
echo json_encode($response);

?>