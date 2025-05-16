<?php
session_start();
require_once("../../libs/logger/KLogger.php");
require "../conexion.php";
$response = array("status" => "success");
$log = new KLogger ( "ajax_ConsultaIncidenciasPorcentajeAsistencia.log" , KLogger::DEBUG );


$fechaInicio = $_POST['fechaInicio'];
$fechaFin = $_POST['fechaFin'];
$NumSup=$_POST['NumSup'];
/////// Turnos Presupuestados ///////////
$PuntosServicioSupervisor = array();
$PlantilasXPuntosDeServicio = array();
$listaTurnosPresupuestados = array();
$ListaFechas = array();

/////// Incidencias por dia ///////////
$EmpleadosPorPuntoYSupervisor = array();
$catalogoIncidencias = array();
$listaIncidencias = array();
$datosInicidencias = array();

//////// incidencias especiales ////////
$catalogoIncidenciasEspeciales = array();
$listaincidenciasEspeciales = array();
$datosIncidenciasEspeciales = array();

// incidencias Por 24 horas n/////////
$listaincidencias24Horas = array();
$incidenciasDeMasDias = array();

// General 24 horas ////////////////
$listageneral24horas = array();
$incidenciasDeMasDiasGeneral = array();






try{
	//******************** Consultas para generar la tabla de  turnos presupuestados por supervisor ******************************************************************************************
	// Obtenemos los puntos de servicio por supervisor para obtener los turnos presupuestados y lo sempleados a su cargo
	$PuntosServicioSupervisor=[];
	$sql = "SELECT c.idPuntoServicio as IdPuntosDeServicio, c.puntoServicio as NombrePuntosDeServicio,sp.servicioPlantillaId as IdPlantilla,sp.fechaInicio as FechaInicioPlantilla,sp.fechaTerminoPlantilla, d.idDiasATrabajar as IdDiasTrabajoPlantillas,d.LunesTurnoDia, d.LunesTurnoNoche, d.MartesTurnoDia, d.MartesTurnoNoche, d.MiercolesTurnoDia, d.MiercolesTurnoNoche, d.JuevesTurnoDia, d.JuevesTurnoNoche, d.ViernesTurnoDia, d.ViernesTurnoNoche, d.SabadoTurnoDia, d.SabadoTurnoNoche, d.DomingoTurnoDia, d.DomingoTurnoNoche
		from supervisor_puntoservicio s
		left join catalogopuntosservicios c on (s.puntoServicioId=c.idPuntoServicio)
		left join servicios_plantillas sp on (s.puntoServicioId=sp.puntoServicioPlantillaId)
		left join diasdetrabajoplantilla d on (sp.servicioPlantillaId=d.servicioPlantillaId)
		where (concat_ws('-',s.supervisorEntidad,s.supervisorConsecutivo,s.supervisorTipo ) = '$NumSup')
		and c.esatusPunto='1'
		and sp.estatusPlantilla ='1'
		and sp.numeroElementos > 0"; 
    	$res = mysqli_query($conexion, $sql);
        while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
           	$PuntosServicioSupervisor[] = $reg;
        }

        ////////// Incidencias Se ponbe aqui para evitar realizar un doble for y no demore tiempo de mas /////////
        $catalogoIncidencias=[];
	$sql2 = "SELECT incidenciaId,descripcionIncidencia FROM catalogoincidencias"; 
    	$res2 = mysqli_query($conexion, $sql2);
        while(($reg2 = mysqli_fetch_array($res2, MYSQLI_ASSOC))){
           	$catalogoIncidencias[] = $reg2;
        }
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////
                ////////// Incidencias Se ponbe aqui para evitar realizar un doble for y no demore tiempo de mas /////////
        $catalogoIncidenciasEspeciales=[];
	$sql4 = "SELECT * FROM catalogoincidenciasespeciales
		where incidenciaEspecialId !='6' 
		and incidenciaEspecialId !='7'"; 
    	$res4 = mysqli_query($conexion, $sql4);
        while(($reg4 = mysqli_fetch_array($res4, MYSQLI_ASSOC))){
           	$catalogoIncidenciasEspeciales[] = $reg4;
        }
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////
        $largoFechas = 0;
        for($i = $fechaInicio; $i <=  $fechaFin; $i = date("Y-m-d", strtotime($i ."+ 1 days"))){ 
        	////////// Incidencias Se ponbe aqui para evitar realizar un doble for y no demore tiempo de mas /////////
        	for($l=0; $l <count($catalogoIncidencias) ; $l++){ 
        		$TipoTurnoInc = $catalogoIncidencias[$l]["descripcionIncidencia"];
        		$incidenciaId = $catalogoIncidencias[$l]["incidenciaId"];
        		if($incidenciaId =="10" || $incidenciaId =="11" || $incidenciaId =="12" || $incidenciaId =="13" || $incidenciaId =="14"){
        			$listaIncidencias[$i][$TipoTurnoInc]["dia"] = 0;
        		}else{
        			$listaIncidencias[$i][$TipoTurnoInc]["dia"] = 0;
        			$listaIncidencias[$i][$TipoTurnoInc]["noche"] = 0;
        		}
        	}
        	///////////////////////////////////////////////////////////////////////////////////////////////////////////

        	////////// Incidencias Se ponbe aqui para evitar realizar un doble for y no demore tiempo de mas incidnencias epseciales /////////
        	for($o=0; $o <count($catalogoIncidenciasEspeciales) ; $o++){ 
        		$TipoTurnoIncidenciaEspecial = $catalogoIncidenciasEspeciales[$o]["descripcionIncidenciaEspecial"];
        		$incidenciaEspecialId = $catalogoIncidenciasEspeciales[$o]["incidenciaEspecialId"];
        		if($incidenciaEspecialId =="1" || $incidenciaEspecialId =="2" ){
        			$listaincidenciasEspeciales[$i][$TipoTurnoIncidenciaEspecial]["dia"] = 0;
        			$listaincidenciasEspeciales[$i][$TipoTurnoIncidenciaEspecial]["noche"] = 0;
        		}else{
        			$listaincidenciasEspeciales[$i][$TipoTurnoIncidenciaEspecial]["dia"] = 0;
        		}
        	}
        	///////////////////////////////////////////////////////////////////////////////////////////////////////////
        	////////// Incidencias Se ponen aqui para evitar realizar un doble for y no demore tiempo de mas incidnencias Por 24 horas /////////
        	for($p=0; $p <24 ; $p++){ 
        		if($p < 10){
        			$Iteracion = "0".$p;
        		}else{
				$Iteracion = $p;
        		}
        		$listaincidencias24Horas[$i][$Iteracion]["dia"] = 0;
        		$listaincidencias24Horas[$i][$Iteracion]["noche"] = 0;
        		$listageneral24horas[$i]["dia"] = 0;
        		$listageneral24horas[$i]["noche"] = 0;
        	}
        	///////////////////////////////////////////////////////////////////////////////////////////////////////////

        	$ListaFechas[$largoFechas] = $i;
        	$largoFechas++;
        	$listaTurnosPresupuestados[$i]["dia"]= 0;
        	$listaTurnosPresupuestados[$i]["noche"] =0;
        	$dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
		$diaDeLaSemana = $dias[(date('N', strtotime($i))) - 1];
        	for($j=0; $j <count($PuntosServicioSupervisor) ; $j++){ 
        		$FechaPlantillaInicio = $PuntosServicioSupervisor[$j]["FechaInicioPlantilla"];
        		$FechaPlantillaTermino = $PuntosServicioSupervisor[$j]["fechaTerminoPlantilla"];
        		if($i >= $FechaPlantillaInicio && $i <= $FechaPlantillaTermino){
        			if($diaDeLaSemana == "Lunes"){
        				$listaTurnosPresupuestados[$i]["dia"] = $listaTurnosPresupuestados[$i]["dia"]+ $PuntosServicioSupervisor[$j]["LunesTurnoDia"];
        				$listaTurnosPresupuestados[$i]["noche"] = $listaTurnosPresupuestados[$i]["noche"]+ $PuntosServicioSupervisor[$j]["LunesTurnoNoche"];
        			}else if($diaDeLaSemana == "Martes"){
        				$listaTurnosPresupuestados[$i]["dia"] = $listaTurnosPresupuestados[$i]["dia"]+ $PuntosServicioSupervisor[$j]["MartesTurnoDia"];
        				$listaTurnosPresupuestados[$i]["noche"] = $listaTurnosPresupuestados[$i]["noche"]+ $PuntosServicioSupervisor[$j]["MartesTurnoNoche"];
        			}else if($diaDeLaSemana == "Miercoles"){
        				$listaTurnosPresupuestados[$i]["dia"] = $listaTurnosPresupuestados[$i]["dia"]+ $PuntosServicioSupervisor[$j]["MiercolesTurnoDia"];
        				$listaTurnosPresupuestados[$i]["noche"] = $listaTurnosPresupuestados[$i]["noche"]+ $PuntosServicioSupervisor[$j]["MiercolesTurnoNoche"];
        			}else if($diaDeLaSemana == "Jueves"){
        				$listaTurnosPresupuestados[$i]["dia"] = $listaTurnosPresupuestados[$i]["dia"]+ $PuntosServicioSupervisor[$j]["JuevesTurnoDia"];
        				$listaTurnosPresupuestados[$i]["noche"] = $listaTurnosPresupuestados[$i]["noche"]+ $PuntosServicioSupervisor[$j]["JuevesTurnoNoche"];
        			}else if($diaDeLaSemana == "Viernes"){
        				$listaTurnosPresupuestados[$i]["dia"] = $listaTurnosPresupuestados[$i]["dia"]+ $PuntosServicioSupervisor[$j]["ViernesTurnoDia"];
        				$listaTurnosPresupuestados[$i]["noche"] = $listaTurnosPresupuestados[$i]["noche"]+ $PuntosServicioSupervisor[$j]["ViernesTurnoNoche"];
        			}else if($diaDeLaSemana == "Sabado"){
        				$listaTurnosPresupuestados[$i]["dia"] = $listaTurnosPresupuestados[$i]["dia"]+ $PuntosServicioSupervisor[$j]["SabadoTurnoDia"];
        				$listaTurnosPresupuestados[$i]["noche"] = $listaTurnosPresupuestados[$i]["noche"]+ $PuntosServicioSupervisor[$j]["SabadoTurnoNoche"];
        			}else if($diaDeLaSemana == "Domingo"){
        				$listaTurnosPresupuestados[$i]["dia"] = $listaTurnosPresupuestados[$i]["dia"]+ $PuntosServicioSupervisor[$j]["DomingoTurnoDia"];
        				$listaTurnosPresupuestados[$i]["noche"] = $listaTurnosPresupuestados[$i]["noche"]+ $PuntosServicioSupervisor[$j]["DomingoTurnoNoche"];
        			}
        		}  
        	}//For Puntos de servicio 
        }// For de fechas 
	$response["ListaFechas"]= $ListaFechas;	
	$response["DatosTurnosPresupuestados"]= $listaTurnosPresupuestados;
	//******************** terminan las Consultas para generar la tabla de  turnos presupuestados por supervisor **************************************************************************************
	//******************** Comienzan las Consultas para generar la tabla de incidencias por dia (Asistencia) por supervisor ***************************************************************************
	$EmpleadosPorPuntoYSupervisor=[];
	$sql1 = "SELECT e.entidadFederativaId,e.empleadoConsecutivoId,e.empleadoCategoriaId
		from supervisor_puntoservicio s
		left join catalogopuntosservicios c on (s.puntoServicioId=c.idPuntoServicio)
		left join empleados e on (e.empleadoIdPuntoServicio = s.puntoServicioId)
		where (concat_ws('-',s.supervisorEntidad,s.supervisorConsecutivo,s.supervisorTipo ) = '$NumSup')
		and c.esatusPunto='1'
		and (e.empleadoEstatusId='1' or e.empleadoEstatusId='2')
		and concat_ws('-',e.idEntidadResponsableAsistencia,e.consecutivoResponsableAsistencia,e.tipoResponsableAsistencia) = '$NumSup'"; 
    	$res1 = mysqli_query($conexion, $sql1);
        while(($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
           	$EmpleadosPorPuntoYSupervisor[] = $reg1;
        }
        $response["catalogoIncidencias"]= $catalogoIncidencias;	
        
        for($k=0; $k <count($EmpleadosPorPuntoYSupervisor) ; $k++){
        	$entidadFederativaId = $EmpleadosPorPuntoYSupervisor[$k]["entidadFederativaId"];
        	$empleadoConsecutivoId = $EmpleadosPorPuntoYSupervisor[$k]["empleadoConsecutivoId"];
        	$empleadoCategoriaId = $EmpleadosPorPuntoYSupervisor[$k]["empleadoCategoriaId"];
        	// incidencias de 24 horas para el pocentahe por la fecha de ingreso de la incidencai sin importar a que fecha se realia la incidencia //////////////////////
        	$fechaInicio1 = $fechaInicio . " 00:00:00";
        	$fechaFin1 = $fechaFin . " 23:59:59";
        	$incidenciasDeMasDias=[];
        	$sql6 = "SELECT cia.IdIncidencia,ci.incidenciaId,a.fechaRegistroAsistencia
			FROM asistencia a 
			LEFT JOIN catalogoincidencias ci on (a.incidenciaAsistenciaId=ci.incidenciaId)
			LEFT JOIN turnoasistencia ta on (ta.entidadEmpTurno=a.empleadoEntidad AND ta.consecutivoEmpTurno=a.empleadoConsecutivo AND ta.categoriaEmpTurno=a.empleadoTipo AND a.fechaAsistencia=ta.fechaTurno)
			LEFT JOIN catalogoincidenciasturnoasistencia cia on (ta.tipoTurno=cia.IdIncidencia)
			where a.empleadoEntidad='$entidadFederativaId'
			and a.empleadoConsecutivo='$empleadoConsecutivoId'
			and a.empleadoTipo='$empleadoCategoriaId'
			and a.fechaRegistroAsistencia between CAST('$fechaInicio1' AS DATE) and CAST('$fechaFin1' AS DATE)
			and ci.incidenciaId !='10'
            		and ci.incidenciaId !='11'
            		and ci.incidenciaId !='14'"; 
    		$res6 = mysqli_query($conexion, $sql6);
        	while(($reg6 = mysqli_fetch_array($res6, MYSQLI_ASSOC))){
           		$incidenciasDeMasDias[] = $reg6;
        	}
        	
        	for($q=0; $q <count($incidenciasDeMasDias) ; $q++){
        		$incidenciaId = $incidenciasDeMasDias[$q]["incidenciaId"];
        		$IdIncidencia = $incidenciasDeMasDias[$q]["IdIncidencia"];
        		$fechaRegistroAsistencia1 = $incidenciasDeMasDias[$q]["fechaRegistroAsistencia"];
        		$fechaRegistroAsistenciaExplode1 = explode(' ', $fechaRegistroAsistencia1);
        		$FechaInsertMasDIas = $fechaRegistroAsistenciaExplode1[0];
        		$HoraInsert2= $fechaRegistroAsistenciaExplode1[1];
        		$HoraInsertExplode1 = explode(':', $HoraInsert2);
        		$HoraInsertMasDIas = $HoraInsertExplode1[0];
        		if($incidenciaId == "3" || $incidenciaId == "12" || $incidenciaId == "13"){
        			$listaincidencias24Horas[$FechaInsertMasDIas][$HoraInsertMasDIas]["dia"] = $listaincidencias24Horas[$FechaInsertMasDIas][$HoraInsertMasDIas]["dia"] + 1;// Turnos de 24 horas
        			$listaincidencias24Horas[$FechaInsertMasDIas][$HoraInsertMasDIas]["noche"] = $listaincidencias24Horas[$FechaInsertMasDIas][$HoraInsertMasDIas]["noche"] + 1;// Turnos de 24 horas
        			$listageneral24horas[$FechaInsertMasDIas]["dia"] = $listageneral24horas[$FechaInsertMasDIas]["dia"]+1;
        			$listageneral24horas[$FechaInsertMasDIas]["noche"] = $listageneral24horas[$FechaInsertMasDIas]["noche"]+1;
         			
        		}else{
        			if($IdIncidencia="1" || $IdIncidencia="3" || $IdIncidencia="5" || $IdIncidencia="8" || $IdIncidencia="10" ||$IdIncidencia="12" || $IdIncidencia="14" || $IdIncidencia="16"){//Vacaciones pagadas de dia ,vacaciones´disfrutadas de dia y incapacidad de dia
        				$listaincidencias24Horas[$FechaInsertMasDIas][$HoraInsertMasDIas]["dia"] = $listaincidencias24Horas[$FechaInsertMasDIas][$HoraInsertMasDIas]["dia"] + 1;// Turnos de 24 horas
        				$listageneral24horas[$FechaInsertMasDIas]["dia"] = $listageneral24horas[$FechaInsertMasDIas]["dia"]+1;
        			}else{
        				$listaincidencias24Horas[$FechaInsertMasDIas][$HoraInsertMasDIas]["noche"] = $listaincidencias24Horas[$FechaInsertMasDIas][$HoraInsertMasDIas]["noche"] + 1;// Turnos de 24 horas
        				$listageneral24horas[$FechaInsertMasDIas]["noche"] = $listageneral24horas[$FechaInsertMasDIas]["noche"]+1;
        			}

        		}
        	}

        	$incidenciasDeMasDiasGeneral=[];
        	$sql7 = "SELECT i.incidenciaFechaRegistro,i.incidenciaFecha,ci.descripcionIncidenciaEspecial,i.incidenciaId
        		from incidenciasespeciales i
			left join catalogoincidenciasespeciales ci on (i.incidenciaId=ci.incidenciaEspecialId)
			where i.incidenciaEmpleadoEntidad='$entidadFederativaId'
			and i.incidenciaEmpleadoConsecutivo='$empleadoConsecutivoId'
			and i.incidenciaEmpleadoTipo='$empleadoCategoriaId'
			and i.incidenciaId !='3'
			and i.incidenciaFechaRegistro between CAST('$fechaInicio1' AS DATE) and CAST('$fechaFin1' AS DATE);"; 
    		$res7 = mysqli_query($conexion, $sql7);
        	while(($reg7 = mysqli_fetch_array($res7, MYSQLI_ASSOC))){
           		$incidenciasDeMasDiasGeneral[] = $reg7;
        	}
        	for($r=0; $r <count($incidenciasDeMasDiasGeneral) ; $r++){
        		$incidenciaFechaRegistro = $incidenciasDeMasDiasGeneral[$r]["incidenciaFechaRegistro"];
        		$incidenciaIdEspecial = $incidenciasDeMasDiasGeneral[$r]["incidenciaId"];
        		$fechaRegistroIncidenciaEspecialExplode = explode(' ', $incidenciaFechaRegistro);
        		$FechaInsertE = $fechaRegistroIncidenciaEspecialExplode[0];
        		$HoraInsertE1= $fechaRegistroIncidenciaEspecialExplode[1];
        		$HoraInsertIEExplode = explode(':', $HoraInsertE1);
        		$HoraInsertE = $HoraInsertIEExplode[0];
        		if($incidenciaIdEspecial =='1' || $incidenciaIdEspecial =='2' || $incidenciaIdEspecial =='4' || $incidenciaIdEspecial =='5'){
        			$listaincidencias24Horas[$FechaInsertE][$HoraInsertE]["dia"] = $listaincidencias24Horas[$FechaInsertE][$HoraInsertE]["dia"] + 1;// Turnos de 24 horas
        			$listageneral24horas[$FechaInsertE]["dia"] = $listageneral24horas[$FechaInsertE]["dia"]+1;
        		}else{
        			$listaincidencias24Horas[$FechaInsertE][$HoraInsertE]["noche"] = $listaincidencias24Horas[$FechaInsertE][$HoraInsertE]["noche"] + 1;// Turnos de 24 horas
        			$listageneral24horas[$FechaInsertE]["noche"] = $listageneral24horas[$FechaInsertE]["noche"]+1;
        		}        		
        		
        	}
        	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        	$datosInicidencias=[];
        	$EmpleadosBajaExcepion="";
        	$sql3 = "SELECT a.fechaAsistencia,ci.descripcionIncidencia as TipoTurno,cia.DesacripcionIncidencia as tipoPosicion,ci.incidenciaId,a.fechaRegistroAsistencia
			FROM asistencia a 
			LEFT JOIN catalogoincidencias ci on (a.incidenciaAsistenciaId=ci.incidenciaId)
			LEFT JOIN turnoasistencia ta on (ta.entidadEmpTurno=a.empleadoEntidad AND ta.consecutivoEmpTurno=a.empleadoConsecutivo AND ta.categoriaEmpTurno=a.empleadoTipo AND a.fechaAsistencia=ta.fechaTurno)
			LEFT JOIN catalogoincidenciasturnoasistencia cia on (ta.tipoTurno=cia.IdIncidencia)
			where a.empleadoEntidad='$entidadFederativaId'
			and a.empleadoConsecutivo='$empleadoConsecutivoId'
			and a.empleadoTipo='$empleadoCategoriaId'
			and a.fechaAsistencia between CAST('$fechaInicio' AS DATE) and CAST('$fechaFin' AS DATE)"; 
    		$res3 = mysqli_query($conexion, $sql3);
        	while(($reg3 = mysqli_fetch_array($res3, MYSQLI_ASSOC))){
           		$datosInicidencias[] = $reg3;
        	}
        	for($m=0; $m <count($datosInicidencias) ; $m++){

        		// Para La lista de incidencias por hora de las 24 horas /////////////////////////
        		$fechaRegistroAsistencia = $datosInicidencias[$m]["fechaRegistroAsistencia"];
        		$fechaRegistroAsistenciaExplode = explode(' ', $fechaRegistroAsistencia);
        		$FechaInsert = $fechaRegistroAsistenciaExplode[0];
        		$HoraInsert1= $fechaRegistroAsistenciaExplode[1];
        		$HoraInsertExplode = explode(':', $HoraInsert1);
        		$HoraInsert = $HoraInsertExplode[0];
        		
        		//////////////////////////////////////////////////////////////////////////////////

        		$fechaAsistencia = $datosInicidencias[$m]["fechaAsistencia"];
        		$TipoTurno = $datosInicidencias[$m]["TipoTurno"];
        		$tipoPosicion = $datosInicidencias[$m]["tipoPosicion"];
        		$incidenciaId = $datosInicidencias[$m]["incidenciaId"];

        		if($incidenciaId =="10" || $incidenciaId =="11" || $incidenciaId =="12" || $incidenciaId =="13" || $incidenciaId =="14" || $incidenciaId =="8"){// Este incidencia 8 se debe de quitar en cuanto se resuelva el motivo por el cual las incapacidades si se insertan en la talba de asistencia que es la principal pero no en la talba de turnos asistencia que es de donde se saca si la incidencia es de dia o de noche es IMPORTANTE !!!!!!! 
        			if($incidenciaId =="11"){
        				$incidenciaIdSiguiente = $datosInicidencias[$m+1]["incidenciaId"];
        				if($incidenciaIdSiguiente !="11"){
        					$listaIncidencias[$fechaAsistencia][$TipoTurno]["dia"] = $listaIncidencias[$fechaAsistencia][$TipoTurno]["dia"] + 1;
        				}
        			}else if($incidenciaId =="10"){
        				$NumeroEmpleadoARevisar = $entidadFederativaId."-".$empleadoConsecutivoId."-".$empleadoCategoriaId;
        				if($NumeroEmpleadoARevisar != $EmpleadosBajaExcepion){
        					$listaIncidencias[$fechaAsistencia][$TipoTurno]["dia"] = $listaIncidencias[$fechaAsistencia][$TipoTurno]["dia"] + 1;
        					$EmpleadosBajaExcepion = $NumeroEmpleadoARevisar;
        				}
        			}else{
        				
        				$listaIncidencias[$fechaAsistencia][$TipoTurno]["dia"] = $listaIncidencias[$fechaAsistencia][$TipoTurno]["dia"] + 1;
        			}
        		}else if($incidenciaId =="3"){
        			$listaIncidencias[$fechaAsistencia][$TipoTurno]["dia"] = $listaIncidencias[$fechaAsistencia][$TipoTurno]["dia"] + 1;
        			$listaIncidencias[$fechaAsistencia][$TipoTurno]["noche"] = $listaIncidencias[$fechaAsistencia][$TipoTurno]["noche"] + 1;
        			
        		}else{
        			$incidenciaAComparar = $TipoTurno . " DIA";
        			if($tipoPosicion == $incidenciaAComparar){
        				$listaIncidencias[$fechaAsistencia][$TipoTurno]["dia"] = $listaIncidencias[$fechaAsistencia][$TipoTurno]["dia"] + 1;
        			}else{
        				$listaIncidencias[$fechaAsistencia][$TipoTurno]["noche"] = $listaIncidencias[$fechaAsistencia][$TipoTurno]["noche"] + 1;
        			}	
        		}			
        	}//ForIncidencia De Asistencia
 //******************** Terminan las Consultas para generar la tabla de incidencias por dia (Asistencia) por supervisor ***************************************************************************
//******************** Comienzan las Consultas para generar la tabla de incidencias especiales por dia (incidenciasEspeciales) por supervisor ************************************************************
        	$response["catalogoIncidenciasEspeciales"]= $catalogoIncidenciasEspeciales;	
        	$datosIncidenciasEspeciales=[];
        	$sql5 = "SELECT i.incidenciaFechaRegistro,i.incidenciaFecha,ci.descripcionIncidenciaEspecial,i.incidenciaId
        		from incidenciasespeciales i
			left join catalogoincidenciasespeciales ci on (i.incidenciaId=ci.incidenciaEspecialId)
			where i.incidenciaEmpleadoEntidad='$entidadFederativaId'
			and i.incidenciaEmpleadoConsecutivo='$empleadoConsecutivoId'
			and i.incidenciaEmpleadoTipo='$empleadoCategoriaId'
			and i.incidenciaFecha between CAST('$fechaInicio' AS DATE) and CAST('$fechaFin' AS DATE);"; 
    		$res5 = mysqli_query($conexion, $sql5);
        	while(($reg5 = mysqli_fetch_array($res5, MYSQLI_ASSOC))){
           		$datosIncidenciasEspeciales[] = $reg5;
        	}
        	for($n=0; $n <count($datosIncidenciasEspeciales) ; $n++){
        		
        		$incidenciaFecha = $datosIncidenciasEspeciales[$n]["incidenciaFecha"];
        		$des = $datosIncidenciasEspeciales[$n]["descripcionIncidenciaEspecial"];
        		$incidenciaId = $datosIncidenciasEspeciales[$n]["incidenciaId"];
        		if($incidenciaId == "6"){
        			$des1 = "TURNO EXTRA DIA"; // se nombra asi ya que se divide dia y npoche en los turnos extras
  			 	$listaincidenciasEspeciales[$incidenciaFecha][$des1]["noche"] = $listaincidenciasEspeciales[$incidenciaFecha][$des1]["noche"]+1;  	
        		}else if($incidenciaId == "7"){
        			$des1 = "RETARDO(DIA)";
  			 	$listaincidenciasEspeciales[$incidenciaFecha][$des1]["noche"] = $listaincidenciasEspeciales[$incidenciaFecha][$des1]["noche"]+1;  	
        		}else{
        		   	$listaincidenciasEspeciales[$incidenciaFecha][$des]["dia"] = $listaincidenciasEspeciales[$incidenciaFecha][$des]["dia"]+1;        			
        		}
        	}






//******************** Terminan las Consultas para generar la tabla de incidencias especiales por dia (incidenciasEspeciales) por supervisor ************************************************************	
        }//For consulta empleados 
        $response["datosIncidencias"]= $listaIncidencias;
        $response["listaincidenciasEspeciales"]= $listaincidenciasEspeciales;
        $response["listaincidencias24Horas"]= $listaincidencias24Horas;
        $response["listageneral24horas"]= $listageneral24horas;









	$log->LogInfo("Valor de la variable response: " . var_export ($response, true));	
		//$response["datosIncidenciasEsp"]= $listaTotalIncidenciasEspeciales;
		//$response["datosTurnosPresupuestados"]= $listaTurnosXDiaRI;
		//$response["listaIncidencias"]= $listaIncidencias;	
		//$response["listaIncidenciasEspeciales"]= $listaIncidenciasEspeciales;	
		//$response["listaTurnosPresupuesto"]= $listaTurnosPresupuesto;	
	}catch(Exception $e ){
		$response["status"]="error";
		$response["error"]="No se puedo obtener Empleado";
	}
echo json_encode($response);
?>