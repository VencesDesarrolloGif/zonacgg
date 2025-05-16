<?php
session_start();
require_once("../../libs/logger/KLogger.php");
require "../conexion.php";
$response = array("status" => "success");
$datosConsultaEntidades= array ();
$datosPlantillasPorEntidad= array ();
$datosdiasSolicitados= array ();
$datosTurnosCubiertosNormales= array ();
$datosTurnosCubiertosIncidencias= array ();
$datos= array ();
//$log = new KLogger ( "ajax_ConsultaDetalleCobertura.log" , KLogger::DEBUG );
if(!empty ($_POST)){
	$LineaNegocio=$_POST['lineaNegocio'];
	$anio=$_POST['anio'];
	$mes=$_POST['mes'];
	$fechaInicial = $anio . "-" . $mes . "-01"; 
	$fechaFinal = date("Y-m-t", strtotime($fechaInicial));
	try{
		////////////////////Se Obtienen Las Entidades Para La Consulta General Divida Por Entidades Y mandarlas  encapsuladas ////////////////////////////
		$sql = "SELECT * FROM entidadesfederativas
                where idEntidadFederativa !='50'
                AND idEntidadFederativa !='33'"; 
    	$res = mysqli_query($conexion, $sql);
        while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
           	$datosConsultaEntidades[] = $reg;
        }
        $largo = count($datosConsultaEntidades);
       	for ($h=0; $h < count($datosConsultaEntidades)+1 ; $h++) { 
       		if($h == $largo){
	        	$datos [$h]["Entidad"] = 0;
	        	$datos [$h]["turnosSolicitadosPorDia"] = 0;
       			$datos [$h]["turnoSolicitadosDeDia"] = 0;
       			$datos [$h]["turnosSolicitadosDeNoche"] = 0;  
				$datos [$h]["turnosCubiertos"] = 0;
       			$datos [$h]["turnosCubiertosDia"] = 0;
				$datos [$h]["turnosCubiertosNoche"] = 0;
	        }else{
       			$idEntidad = $datosConsultaEntidades[$h]['idEntidadFederativa'];
       			$NombreEntidad = $datosConsultaEntidades[$h]['nombreEntidadFederativa'];
       			$turnosPorDiaFinal=0;
       			$turnoDeDiaFinal=0;
       			$turnosDeNocheFinal=0;
       			$turnosDeTurnosFinal=0;
       			$turnosCubiertosDiaFinal=0;
       			$turnosCubiertosNocheFinal=0;
       			$datosPlantillasPorEntidad = [];
				////////////////////////// Se Realiza La consulta de Las Plantilla Activas Por Entidad Y Linea De Negocio //////////////////////////////////////////////
				//////////////////////// Se obitneen Las Requisiciones Por Vetnas Tanto eL Total Con De Dia y Noche ///////////////////////////////////////////////
       			$sql1 = "SELECT * from servicios_plantillas sp
       					left join catalogopuntosservicios cps on cps.idPuntoServicio=sp.puntoServicioPlantillaId
       			        where estatusPlantilla='1' 
       			        and sp.lineaNegocioRequisicion='$LineaNegocio'
       			        and cps.idEntidadPunto='$idEntidad'"; 
       			$res1 = mysqli_query($conexion, $sql1);
       			while(($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
       			 	$datosPlantillasPorEntidad[] = $reg1;
       			}
       			for ($i =$fechaInicial; $i <=$fechaFinal; $i = date("Y-m-d", strtotime($i ."+ 1 days"))){      
       				$turnosPorDia=0;
       				$turnoDeDia=0;
       				$turnosDeNoche=0;
       				$turnosCubiertosDia=0;
       				$turnosCubiertosNoche=0;
       				$turnosCubiertos=0;
       			    $LargoDatosplantilla = count($datosPlantillasPorEntidad);
       			    $dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
       			    $dia = $dias[(date('N', strtotime($i))) - 1];
       			    $turnoDiaC = $dia."TurnoDia";
       			    $turnoNocheC = $dia."TurnoNoche";
       			    for($j=0; $j<$LargoDatosplantilla;$j++){
       			       	$PlantillaId = $datosPlantillasPorEntidad[$j]["servicioPlantillaId"];
       			       	$TurnoDiaSolicitado = 0;
       			       	$TurnoNocheSolicitado = 0;
       			       	$contadorArray = 0;
       			       	$datosdiasSolicitados = [];
      					//////////////////////// Se Realiza la Consulta de Los Dias y Se Obtiene el resultado En result///////////////////////////////////////
       			       	$sql2 = "SELECT $turnoDiaC,$turnoNocheC 
       			     			from diasdetrabajoplantilla
       			    			where servicioPlantillaId='$PlantillaId'"; 
    					$res2 = mysqli_query($conexion, $sql2);
       			    	while(($reg2 = mysqli_fetch_array($res2, MYSQLI_ASSOC))){
       			     		$datosdiasSolicitados[] = $reg2;
       			    	}
       			       	$contadorArray = count($datosdiasSolicitados);
       			       	if($contadorArray==0)
       			       	{
       			       	   $TurnoDiaSolicitado = $TurnoDiaSolicitado + 0;
       			       	   $TurnoNocheSolicitado = $TurnoNocheSolicitado + 0;
       			       	}else{
       			       	    $TurnoDiaSolicitado = $datosdiasSolicitados[0][$turnoDiaC];
       			       	    $TurnoNocheSolicitado = $datosdiasSolicitados[0][$turnoNocheC];
       			       	}
       			       	$turnosPorDia = $turnosPorDia + $TurnoDiaSolicitado + $TurnoNocheSolicitado; 
       			       	$turnoDeDia = $turnoDeDia + $TurnoDiaSolicitado; 
       			       	$turnosDeNoche = $turnosDeNoche +  $TurnoNocheSolicitado; 
       			    }
       			    $turnosPorDiaFinal = $turnosPorDia + $turnosPorDiaFinal;
       			    $turnoDeDiaFinal = $turnoDeDia + $turnoDeDiaFinal;
       			    $turnosDeNocheFinal = $turnosDeNoche + $turnosDeNocheFinal;
       				///////////////////////////////////////////////////// Se Genera La Consulta De Los Turnos Cubiertos ////////////////////////////////////////////////////////
       				$datosTurnosCubiertosIncidencias = [];
       				$datosTurnosCubiertosNormales = [];
       			    
       			    $sql3 = "SELECT * FROM turnoasistencia ta
       			            left join catalogopuntosservicios cps on cps.idPuntoServicio=ta.puntoServicioTurno
       			            where fechaTurno ='$i' 
       			            and idLineaNegocioPunto='$LineaNegocio'
       			            and idEntidadPunto='$idEntidad'
       			            and cps.idClientePunto!='2'"; 
    				$res3 = mysqli_query($conexion, $sql3);
       			    while(($reg3 = mysqli_fetch_array($res3, MYSQLI_ASSOC))){
       			     	$datosTurnosCubiertosNormales[] = $reg3;
       			    }
       				////////////////////////////////////// Se Calculan Los Turnos cubiertos Normales /////////////////////////////////////////////
       			    for($k=0; $k<count($datosTurnosCubiertosNormales);$k++){
       			       	$tipoTurno = $datosTurnosCubiertosNormales[$k]["tipoTurno"];
       			       	if($tipoTurno=='1' || $tipoTurno=='3' || $tipoTurno=='5' || $tipoTurno=='7' || $tipoTurno=='18'){
       			           	$turnosCubiertosDia = $turnosCubiertosDia+1;//AA
       			       	}
       			       	if($tipoTurno=='2' || $tipoTurno=='4' || $tipoTurno=='6' || $tipoTurno=='7' || $tipoTurno=='18'){
       			           	$turnosCubiertosNoche = $turnosCubiertosNoche+1;
       			       	}
       			    }
       			    ////////////////////////////////////// Se Calculan Los Turnos cubiertos De Incidencias Especiales /////////////////////////////////////////////
       			    $sql4 = "SELECT incidenciaId
       			            FROM incidenciasespeciales ie
       			            inner join catalogoincidenciasespeciales cie ON (cie.incidenciaEspecialId=ie.incidenciaId)
       			            left join catalogopuntosservicios cps on cps.idPuntoServicio=ie.incidenciaPuntoServicio
       			            where ie.incidenciaFecha ='$i'
       			            and cps.idEntidadPunto='$idEntidad'
       			            and cps.idClientePunto !='2'"; 
    				$res4 = mysqli_query($conexion, $sql4);
       			    while(($reg4 = mysqli_fetch_array($res4, MYSQLI_ASSOC))){
       			     	$datosTurnosCubiertosIncidencias[] = $reg4;
       			    }
       			    for($l=0; $l<count($datosTurnosCubiertosIncidencias);$l++){
       			        $incidenciaId = $datosTurnosCubiertosIncidencias[$l]["incidenciaId"];
       			        if($incidenciaId=='1'){
       			        	$turnosCubiertosDia = $turnosCubiertosDia+1;
       			        }
       			        if($incidenciaId=='6'){
       			            $turnosCubiertosNoche = $turnosCubiertosNoche+1;
       			        }
	        	    }
	        	    $turnosCubiertosDiaFinal = $turnosCubiertosDiaFinal + $turnosCubiertosDia;
       			    $turnosCubiertosNocheFinal = $turnosCubiertosNocheFinal + $turnosCubiertosNoche;
       			    $turnosCubiertos=($turnosCubiertosDia + $turnosCubiertosNoche);
       			    $turnosDeTurnosFinal = $turnosDeTurnosFinal + $turnosCubiertos;
	        	}
	        
	        	$datos [$h]["Entidad"] = $NombreEntidad;
	        	$datos [$h]["turnosSolicitadosPorDia"] = $turnosPorDiaFinal;
       			$datos [$h]["turnoSolicitadosDeDia"] = $turnoDeDiaFinal;
       			$datos [$h]["turnosSolicitadosDeNoche"] = $turnosDeNocheFinal;  
				$datos [$h]["turnosCubiertos"] = $turnosDeTurnosFinal;
       			$datos [$h]["turnosCubiertosDia"] = $turnosCubiertosDiaFinal;
				$datos [$h]["turnosCubiertosNoche"] = $turnosCubiertosNocheFinal;
			}
		}
		$response["datos"]= $datos;	
	}catch(Exception $e ){
		$response["status"]="error";
		$response["error"]="No se puedo obtener Empleado";
	}
}
//$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
echo json_encode($response);

?>