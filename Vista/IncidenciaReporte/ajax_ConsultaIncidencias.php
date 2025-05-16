<?php
session_start();
require_once("../../libs/logger/KLogger.php");
require "../conexion.php";
$response = array("status" => "success");
$datosTurnosCubiertosIncidencias= array ();
$datos= array ();
// $log = new KLogger ( "ajax_ConsultaIncidencias.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
$tipo = $_POST['tipo'];
$lineaNegocio= $_POST['lineaNegocio'];
$fechaInicio = $_POST['fechaInicio'];
$fechaFin = $_POST['fechaFin'];
$varCLienteOentidad=$_POST['entOclientElegido'];
$listaIncidencias = array ();
$listaIncidenciasEspeciales = array ();
$listaTotalIncidencias = array ();
$listaTotalIncidenciasEspeciales = array ();
$listaIncidenciasXdias = array ();
$listaIncidenciasEspecialesXDias = array ();
$arregloBajas = array ();
$arregloAltas = array ();
$listaIncidenciaBaja = array ();
$listaIncidenciaAlta = array ();
$listaFechas = array ();
$listaTurnosPresupuesto = array ();
$listaTurnosXDiaRI = array ();


	try{
		$sql = "SELECT incidenciaId,descripcionIncidencia
				FROM catalogoincidencias"; 

    	$res = mysqli_query($conexion, $sql);
        while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
           	$listaIncidencias[] = $reg;
        }

        $sql1 = "SELECT incidenciaEspecialId,descripcionIncidenciaEspecial
				 FROM catalogoincidenciasespeciales
				 WHERE incidenciaEspecialId!='6' 
				 AND incidenciaEspecialId!='7'"; //excluimos un turno extra y un retardo(en este caso noche) ya que no nos sirve al momento de hacer el for y hacer el conteo de dia y noche

    	$res1 = mysqli_query($conexion, $sql1);
        while(($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
           	$listaIncidenciasEspeciales[] = $reg1;
        }

        for($i=0; $i <count($listaIncidencias) ; $i++){ 
        	$idIncidencia  = $listaIncidencias[$i]["incidenciaId"];
        	$descIncidencia= $listaIncidencias[$i]["descripcionIncidencia"];

		    $contador='0';
        	for($j = $fechaInicio; $j <=  $fechaFin; $j = date("Y-m-d", strtotime($j ."+ 1 days"))){ 

       		    $sql2 ="SELECT ";

        		if($idIncidencia=='1') {//DESCANSO
        			$sql2.="COUNT(
								 CASE 
								 	WHEN ta.tipoTurno = 8 THEN 'dia'
                				     END)AS dia,
                				     COUNT(
								 CASE 
								 	WHEN ta.tipoTurno = 9 THEN 'noche'
                				     END)AS noche";
        		}if($idIncidencia=='2') {//1212
        			$sql2.="COUNT(
								 CASE 
								 	WHEN ta.tipoTurno = 1 THEN 'dia'
                				     END)AS dia,
                				     COUNT(
								 CASE 
								 	WHEN ta.tipoTurno = 2 THEN 'noche'
                				     END)AS noche";
        		}if($idIncidencia=='3') {//24x24 aqui se repite el mismo por que es un turno 24x24 y lo pondremos en una sola columna
        			$sql2.="COUNT(
								 CASE 
								 	WHEN ta.tipoTurno = 7 THEN 'dia'
                				     END)AS dia,
                				     COUNT(
								 CASE 
								 	WHEN ta.tipoTurno = 7 THEN 'noche'
                				     END)AS noche";
        		}if($idIncidencia=='4') {//FALTA
        			$sql2.="COUNT(
								 CASE 
								 	WHEN ta.tipoTurno = 10 THEN 'dia'
                				     END)AS dia,
                				     COUNT(
								 CASE 
								 	WHEN ta.tipoTurno = 11 THEN 'noche'
                				     END)AS noche";
        		}if($idIncidencia=='5') {//VACACIONES PAGADAS
        			$sql2.="COUNT(
								 CASE 
								 	WHEN ta.tipoTurno = 5 THEN 'dia'
                				     END)AS dia,
                				     COUNT(
								 CASE 
								 	WHEN ta.tipoTurno = 6 THEN 'noche'
                				     END)AS noche";
        		}if($idIncidencia=='6') {//VACACIONES DISFRUTADAS
        			$sql2.="COUNT(
								 CASE 
								 	WHEN ta.tipoTurno = 12 THEN 'dia'
                				     END)AS dia,
                				     COUNT(
								 CASE 
								 	WHEN ta.tipoTurno = 13 THEN 'noche'
                				     END)AS noche";
        		}if($idIncidencia=='7') {//PERMISO
        			$sql2.="COUNT(
								 CASE 
								 	WHEN ta.tipoTurno = 14 THEN 'dia'
                				     END)AS dia,
                				     COUNT(
								 CASE 
								 	WHEN ta.tipoTurno = 15 THEN 'noche'
                				     END)AS noche";
        		}
        		if($idIncidencia=='8') {//INCAPACIDAD
        			$sql2.="COUNT(
								 CASE 
								 	WHEN ta.tipoTurno = 16 THEN 'dia'
                				     END)AS dia,
                				     COUNT(
								 CASE 
								 	WHEN ta.tipoTurno = 17 THEN 'noche'
                				     END)AS noche";
        		}if($idIncidencia=='9') {//DESCANSO TRABAJADO 12X12
        			$sql2.="COUNT(
								 CASE 
								 	WHEN ta.tipoTurno = 3 THEN 'dia'
                				     END)AS dia,
                				     COUNT(
								 CASE 
								 	WHEN ta.tipoTurno = 4 THEN 'noche'
                				     END)AS noche";
        		}
        		if($idIncidencia=='10') {//BAJA
        			$sql2.="count(incidenciaAsistenciaId) AS dia,count(incidenciaAsistenciaId) AS noche";
        		}
        		if($idIncidencia=='11') {//INGRESO
        			$sql2.="count(incidenciaAsistenciaId) AS dia,count(incidenciaAsistenciaId) AS noche";
        		}
        		if($idIncidencia=='12') {//VACACIONES PAGADAS 24X24
        			$sql2.="COUNT(
								 CASE 
								 	WHEN ta.tipoTurno = 18 THEN 'dia'
                				     END)AS dia,
                				     COUNT(
								 CASE 
								 	WHEN ta.tipoTurno = 18 THEN 'noche'
                				     END)AS noche";
        		}if($idIncidencia=='13') {//VACACIONES DISFRUTADAS 24X24
        			$sql2.="COUNT(
								 CASE 
								 	WHEN ta.tipoTurno = 19 THEN 'dia'
                				     END)AS dia,
                				     COUNT(
								 CASE 
								 	WHEN ta.tipoTurno = 19 THEN 'noche'
                				     END)AS noche";
        		}if($idIncidencia=='14') {//CAPACITACIÓN
        			$sql2.="count(incidenciaAsistenciaId) AS dia,count(incidenciaAsistenciaId) AS noche";
        		}

        		$sql2.=" FROM asistencia a";

				// if ($tipo=='2' || $tipo=='3'){//por cliente o por entidad se ocupa indistinto por la linea d enegocio delpunto de servicio donde fue la incidencia
					$sql2.=" LEFT JOIN catalogopuntosservicios cps on (cps.idPuntoServicio=a.puntoServicioAsistenciaId)";
				// }
				
				if ($tipo=='2'){//por cliente
					$sql2.=" LEFT JOIN catalogoclientes cc on (cc.idCliente=cps.idClientePunto)";
				}

				if ($tipo=='3'){//por entidad
					$sql2.=" LEFT JOIN entidadesfederativas ef on (cps.idEntidadPunto=ef.idEntidadFederativa)";
				}
							 
				$sql2.=" LEFT JOIN turnoasistencia ta on (ta.entidadEmpTurno=a.empleadoEntidad AND ta.consecutivoEmpTurno=a.empleadoConsecutivo AND ta.categoriaEmpTurno=a.empleadoTipo AND ta.puntoServicioTurno=a.puntoServicioAsistenciaId AND ta.fechaTurno=a.fechaAsistencia)
						 LEFT JOIN empleados emp on (emp.entidadFederativaId= a.empleadoEntidad  AND emp.empleadoConsecutivoId=a.empleadoConsecutivo AND emp.empleadoCategoriaId=a.empleadoTipo)
						 WHERE a.incidenciaAsistenciaId='$idIncidencia'
					  	 AND a.fechaAsistencia='$j'
					  	 AND cps.idLineaNegocioPunto='$lineaNegocio'
					  	 AND emp.idTipoPuesto='03'";//puede ser que falten datos por que son operativos pero el turno es null checar ese caso es en gif(cubre??) 

				if ($tipo=='2'){//por cliente
					$sql2.=" AND cc.idCliente='$varCLienteOentidad'";
				}

				if ($tipo=='3'){//por entidad
					$sql2.=" AND ef.idEntidadFederativa='$varCLienteOentidad'";
				}

				if ($tipo=='3'){//por entidad
					$sql2.=" AND ef.idEntidadFederativa='$varCLienteOentidad'";
				}

				/*
				if ($tipo=='4'){//por supervisor
					$sql2.=" AND supervisorEntidad='$entidadSup'
							 AND supervisorConsecutivo='$consecutivoSup'
							 AND supervisorTipo='$tipoSup'";
				}*/
			    // $log->LogInfo("Valor de la variable sql2: " . var_export ($sql2, true));

     		   	$res2 = mysqli_query($conexion, $sql2);
        	   	while(($reg2 = mysqli_fetch_array($res2, MYSQLI_ASSOC))){
           			   $listaIncidenciasXdias[$i] = $reg2;
           		}
        	    $listaTotalIncidencias[$contador]["fecha"]=$j;
        	    $totalDia=$listaIncidenciasXdias[$i]["dia"];//era el resultado
        	    $totalNoche=$listaIncidenciasXdias[$i]["noche"];//era el resultado
        	    $listaTotalIncidencias[$contador][$idIncidencia]["diaTurnos"]=$totalDia;
        	    $listaTotalIncidencias[$contador][$idIncidencia]["nocheTurnos"]=$totalNoche;
        	    $contador = $contador+1; 
        	}//for j
        }//for i

        for($k=0; $k <count($listaIncidenciasEspeciales) ; $k++){ 
        	$idIncidenciaIE  = $listaIncidenciasEspeciales[$k]["incidenciaEspecialId"];
        	$descIncidencia= $listaIncidenciasEspeciales[$k]["descripcionIncidenciaEspecial"];
        	$contadorIE='0';
        	for($l = $fechaInicio; $l <=  $fechaFin; $l = date("Y-m-d", strtotime($l ."+ 1 days"))){
       		
       		   $sql3 ="SELECT ";

       		   if($idIncidenciaIE=='1'){//TURNO EXTRA 
       		   	  $sql3 .="COUNT(
								CASE 
									WHEN ie.incidenciaId = 1 THEN 'dia'
                    				END)AS dia,
                    				COUNT(
								CASE 
									WHEN ie.incidenciaId = 6 THEN 'noche'
                				    END)AS noche";
       		   }if($idIncidenciaIE=='2'){//RETARDO 
       		   	  $sql3 .="COUNT(
								CASE 
									WHEN ie.incidenciaId = 2 THEN 'dia'
                    				END)AS dia,
                    				COUNT(
								CASE 
									WHEN ie.incidenciaId = 7 THEN 'noche'
                				    END)AS noche";
       		   }if($idIncidenciaIE=='3'){//UNIFORME INCOMPLETO
       		   	  $sql3 .=" count(incidenciaId) AS dia,count(incidenciaId) AS noche";
       		   }
       		   if($idIncidenciaIE=='4'){//DESCUENTO
       		   	  $sql3 .=" count(incidenciaId) AS dia,count(incidenciaId) AS noche";
       		   }
       		   if($idIncidenciaIE=='5'){//TURNO EXTRA DIA FESTIVO
       		   	  $sql3 .=" count(incidenciaId) AS dia,count(incidenciaId) AS noche";
       		   }

       		   $sql3 .=" FROM incidenciasespeciales ie";
				// if ($tipo=='2' || $tipo=='3'){//por cliente o por entidad
					$sql3.=" LEFT JOIN catalogopuntosservicios cps on (cps.idPuntoServicio=ie.incidenciaPuntoServicio)";
				// }
				
				if ($tipo=='2'){//por cliente
					$sql3.=" LEFT JOIN catalogoclientes cc on (cc.idCliente=cps.idClientePunto)";
				}

				if ($tipo=='3'){//por entidad
					$sql3.=" LEFT JOIN entidadesfederativas ef on (cps.idEntidadPunto=ef.idEntidadFederativa)";
				}
							 
				$sql3.=" WHERE ie.incidenciaId='$idIncidenciaIE'
					  	 AND ie.incidenciaFecha='$l'
					  	 AND cps.idLineaNegocioPunto='$lineaNegocio'"; 

				if ($tipo=='2'){//por cliente
					$sql3.=" AND cc.idCliente='$varCLienteOentidad'";
				}

				if ($tipo=='3'){//por entidad
					$sql3.=" AND ef.idEntidadFederativa='$varCLienteOentidad'";
				}
				/*
				if ($tipo=='4'){//por supervisor
					$sql3.=" AND incidenciaSupervisorEntidad='$entidadSup'
							 AND incidenciaSupervisorConsecutivo='$consecutivoSup'
							 AND incidenciaSupervisorTipo='$tipoSup'";
				}*/
     		   	$res3 = mysqli_query($conexion, $sql3);
        	   	while(($reg3 = mysqli_fetch_array($res3, MYSQLI_ASSOC))){
           			   $listaIncidenciasEspecialesXDias[$k] = $reg3;
        	  	}
        	    $listaTotalIncidenciasEspeciales[$contadorIE]["fecha"]=$l;
        	    $totalIEdia=$listaIncidenciasEspecialesXDias[$k]["dia"];
        	    $totalIEnoche=$listaIncidenciasEspecialesXDias[$k]["noche"];
        	    $listaTotalIncidenciasEspeciales[$contadorIE][$idIncidenciaIE]["diaTurnosIE"]=$totalIEdia; 
        	    $listaTotalIncidenciasEspeciales[$contadorIE][$idIncidenciaIE]["nocheTurnosIE"]=$totalIEnoche; 
        	    $contadorIE = $contadorIE+1;

        	}//for l
        }//for k

//empieza para bajas y altas
// ------------------------------------------BAJAS
        $contadorBajas='0';
        $z=0;
        for($n = $fechaInicio; $n <=  $fechaFin; $n = date("Y-m-d", strtotime($n ."+ 1 days"))){
			
			$listaIncidenciaBaja=[];
        	$sql4 = "SELECT CONCAT_WS('-',a.empleadoEntidad,a.empleadoConsecutivo,a.empleadoTipo) as numeroEmp 
					FROM asistencia a 
					LEFT JOIN catalogopuntosservicios cps on (cps.idPuntoServicio=a.puntoServicioAsistenciaId) 
					LEFT JOIN turnoasistencia ta on (ta.entidadEmpTurno=a.empleadoEntidad AND ta.consecutivoEmpTurno=a.empleadoConsecutivo AND ta.categoriaEmpTurno=a.empleadoTipo AND ta.puntoServicioTurno=a.puntoServicioAsistenciaId AND ta.fechaTurno=a.fechaAsistencia)
					LEFT JOIN empleados emp on (emp.entidadFederativaId= a.empleadoEntidad  AND emp.empleadoConsecutivoId=a.empleadoConsecutivo AND emp.empleadoCategoriaId=a.empleadoTipo)
					WHERE a.incidenciaAsistenciaId='10'
					AND a.fechaAsistencia='$n'
					AND cps.idLineaNegocioPunto='$lineaNegocio'
					AND emp.idTipoPuesto='03'
					ORDER BY numeroEmp";

			$res4 = mysqli_query($conexion, $sql4);
        	while(($reg4 = mysqli_fetch_array($res4, MYSQLI_ASSOC))){
          		   $listaIncidenciaBaja[]= $reg4;
        	} 
        	if(empty($arregloBajas)){
		    	  $arregloBajas=$listaIncidenciaBaja;
		    	  $arregloBajas["fecha"]=$n;
		    	  $listaTotalIncidencias[$z][10]['diaTurnos']=count($arregloBajas);
		    	  $listaTotalIncidencias[$z][10]['nocheTurnos']=count($arregloBajas);
        	}else{
        	$z=$z+1;
        		$contadorBajas=count($listaIncidenciaBaja);
        		for($m=0; $m < count($listaIncidenciaBaja); $m++){//empleados 
        			$numeroConsulta=$listaIncidenciaBaja[$m]["numeroEmp"];
        			for ($o=0; $o < count($arregloBajas); $o++) { 
        				$NumeroAVerificar = $arregloBajas[$o]["numeroEmp"];
        				if($numeroConsulta==$NumeroAVerificar){
        					$contadorBajas=$contadorBajas-1;
				  		}
        			}//for o
        		}//for m
					$listaTotalIncidencias[$z][10]['diaTurnos']=$contadorBajas;
					$listaTotalIncidencias[$z][10]['nocheTurnos']=$contadorBajas;
        	}//else empty arreglo bajas
        	$arregloBajas=$listaIncidenciaBaja;
        }//for n
// ------------------------------------------INGRESOS
        $contadoAltas='0';
        $x=0;
        for($u = $fechaInicio; $u <=  $fechaFin; $u = date("Y-m-d", strtotime($u ."+ 1 days"))){
			
			$listaIncidenciaAlta=[];
        	$sql5 = "SELECT CONCAT_WS('-',a.empleadoEntidad,a.empleadoConsecutivo,a.empleadoTipo) as numeroEmp 
					FROM asistencia a 
					LEFT JOIN catalogopuntosservicios cps on (cps.idPuntoServicio=a.puntoServicioAsistenciaId) 
					LEFT JOIN turnoasistencia ta on (ta.entidadEmpTurno=a.empleadoEntidad AND ta.consecutivoEmpTurno=a.empleadoConsecutivo AND ta.categoriaEmpTurno=a.empleadoTipo AND ta.puntoServicioTurno=a.puntoServicioAsistenciaId AND ta.fechaTurno=a.fechaAsistencia)
					LEFT JOIN empleados emp on (emp.entidadFederativaId= a.empleadoEntidad  AND emp.empleadoConsecutivoId=a.empleadoConsecutivo AND emp.empleadoCategoriaId=a.empleadoTipo)
					WHERE a.incidenciaAsistenciaId='11'
					AND a.fechaAsistencia='$u'
					AND cps.idLineaNegocioPunto='$lineaNegocio'
					AND emp.idTipoPuesto='03'
					ORDER BY numeroEmp";

			$res5 = mysqli_query($conexion, $sql5);
        	while(($reg5 = mysqli_fetch_array($res5, MYSQLI_ASSOC))){
          		   $listaIncidenciaAlta[]= $reg5;
        	} 
        	if($u != $fechaInicio){
        		$contadoAltas=count($arregloAltas);
        		if(is_array($listaIncidenciaAlta)){
        			if(is_array($arregloAltas)){
        				for($g=0; $g < count($listaIncidenciaAlta); $g++){//empleados 
        					$numeroConsulta=$listaIncidenciaAlta[$g]["numeroEmp"];
        					for ($oo=0; $oo < count($arregloAltas); $oo++) { 
        						$NumeroAVerificar = $arregloAltas[$oo]["numeroEmp"];
        						if($numeroConsulta==$NumeroAVerificar){
        							$contadoAltas=$contadoAltas-1;
						  		}
        					}//for o
        				}//for m
						$listaTotalIncidencias[$x][11]['diaTurnos']=$contadoAltas;
						$listaTotalIncidencias[$x][11]['nocheTurnos']=$contadoAltas;
        				$x=$x+1;
        				if($u == $fechaFin){
        					$contadoAltas1=count($arregloAltas);
        					$contadoAltas=$contadoAltas1-$contadoAltas;
        					$listaTotalIncidencias[$x][11]['diaTurnos']=$contadoAltas;
							$listaTotalIncidencias[$x][11]['nocheTurnos']=$contadoAltas;
        				}
        			}else{
        				$listaTotalIncidencias[$x][11]['diaTurnos']=0;
						$listaTotalIncidencias[$x][11]['nocheTurnos']=0;
						$x=$x+1;
        			}
        		}else{
        			$listaTotalIncidencias[$x][11]['diaTurnos']=$contadoAltas;
					$listaTotalIncidencias[$x][11]['nocheTurnos']=$contadoAltas;
        			$x=$x+1;
        		}
        	}//else empty arreglo bajas
        	$arregloAltas=$listaIncidenciaAlta;
        }//for n

        $sql6 = "SELECT sp.servicioPlantillaId,sp.fechaInicio,sp.fechaTerminoPlantilla
		 FROM servicios_plantillas sp
		 LEFT JOIN catalogopuntosservicios cps on (cps.idPuntoServicio=sp.puntoServicioPlantillaId)
		 LEFT JOIN diasdetrabajoplantilla dt on (dt.servicioPlantillaId=sp.servicioPlantillaId)
		 WHERE lineaNegocioRequisicion='$lineaNegocio'";

		if($tipo=='2'){//por cliente
		   $sql6.=" AND cps.idClientePunto='$varCLienteOentidad'";
		}

		if($tipo=='3'){//por entidad
			$sql6.=" AND cps.idEntidadPunto='$varCLienteOentidad'";
		}

		$sql6.=" AND ((sp.estatusPlantilla='1' 
			 AND sp.fechaInicio<=cast('$fechaFin' as date))
		 	 OR(sp.estatusPlantilla='0' AND sp.fechaInicio<=cast('$fechaFin' as date ) 
		   	 AND sp.fechaTerminoPlantilla>=cast('$fechaInicio' as date )))
		   	 and dt.idDiasATrabajar is not null"; 
    		$res6 = mysqli_query($conexion, $sql6);
        	while(($reg6 = mysqli_fetch_array($res6, MYSQLI_ASSOC))){
        	   	$listaPlantillas[] = $reg6;
        	}
    		for($aa = 0; $aa < count($listaPlantillas); $aa++){
		    $itemPlantilla = $listaPlantillas[$aa];
		    $idPlantilla   = $itemPlantilla["servicioPlantillaId"];
		    $fechaInicioPlantilla  = $itemPlantilla["fechaInicio"];
		    $fechaTerminoPlantilla = $itemPlantilla["fechaTerminoPlantilla"];

        	    if($fechaInicioPlantilla>$fechaInicio){
        	       $fechaInicioNueva=$fechaInicioPlantilla;
        	    }else{
	        	  $fechaInicioNueva=$fechaInicio;
        	    }

        	    if($fechaTerminoPlantilla<$fechaFin){
        	       $fechaFinNueva=$fechaTerminoPlantilla;
        	    }else{
	        	  $fechaFinNueva=$fechaFin;
        	    }

        	    for($bb = $fechaInicioNueva; $bb <=  $fechaFinNueva; $bb = date("Y-m-d", strtotime($bb ."+ 1 days"))){
        		$turnoDeDia   =0;
        		$turnosDeNoche=0;
	   		$listaTurnosPresupuesto=[];
        		$TurnoDiaSolicitado  = 0;
        		$TurnoNocheSolicitado= 0;

        		if( $aa == 0){
        			for($bb1 = $fechaInicio; $bb1 <=  $fechaFin; $bb1 = date("Y-m-d", strtotime($bb1 ."+ 1 days"))){
			   		$listaTurnosXDiaRI[$bb1]["turnoDiaTotales"]=0;
			   		$listaTurnosXDiaRI[$bb1]["turnosNocheTotales"]=0;
			   	}
        		}
        		$dias= array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
        		$dia = $dias[(date('N', strtotime($bb))) - 1];
        		$turnoDiaC   = $dia."TurnoDia";
        		$turnoNocheC = $dia."TurnoNoche";

        		$sql7 = "SELECT $turnoDiaC,$turnoNocheC 
        			 FROM diasdetrabajoplantilla
        		    	 WHERE servicioPlantillaId='$idPlantilla'"; 
    			$res7 = mysqli_query($conexion, $sql7);
        		while(($reg7 = mysqli_fetch_array($res7, MYSQLI_ASSOC))){
        		   	$listaTurnosPresupuesto[] = $reg7;
        		}
            		if(!is_array($listaTurnosPresupuesto)){
            		   $TurnoDiaSolicitado  = $TurnoDiaSolicitado   + 0;
            		   $TurnoNocheSolicitado= $TurnoNocheSolicitado + 0;
            		}else{

            		      $TurnoDiaSolicitado  = $listaTurnosPresupuesto[0][$turnoDiaC];
            		      $TurnoNocheSolicitado= $listaTurnosPresupuesto[0][$turnoNocheC];
            		}
			
			$listaTurnosXDiaRI[$bb]["turnoDiaTotales"]   += $TurnoDiaSolicitado;  
			$listaTurnosXDiaRI[$bb]["turnosNocheTotales"]+= $TurnoNocheSolicitado;
        	    }//for bb
        	}//for aa
		// $log->LogInfo("Valor de la variable listaTurnosXDiaRI:" . var_export ($listaTurnosXDiaRI, true));
		$response["datosIncidencias"]= $listaTotalIncidencias;	
		$response["datosIncidenciasEsp"]= $listaTotalIncidenciasEspeciales;
		$response["datosTurnosPresupuestados"]= $listaTurnosXDiaRI;
		$response["listaIncidencias"]= $listaIncidencias;	
		$response["listaIncidenciasEspeciales"]= $listaIncidenciasEspeciales;	
		$response["listaTurnosPresupuesto"]= $listaTurnosPresupuesto;	
	}catch(Exception $e ){
		$response["status"]="error";
		$response["error"]="No se puedo obtener Empleado";
	}
echo json_encode($response);
?>