<?php
session_start ();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
verificarInicioSesion ($negocio);
$response = array ();
// $log = new KLogger ( "ajaxRegistroAsistencia.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable post: " . var_export ($_POST, true));
 // $log->LogInfo("Valor de la variable SEsion: " . var_export ($_SESSION, true));
if (!empty ($_POST)){ 
    
    $empleado ["entidadId"] = getValueFromPost ("empleadoEntidadId");
    $empleado ["consecutivoId"] = getValueFromPost ("empleadoConsecutivoId");
    $empleado ["tipoId"] = getValueFromPost ("empleadoTipoId");
    $empleado ["puntoServicioId"] = getValueFromPost ("empleadoPuntoServicioId");
    $supervisor ["entidadId"] = getValueFromPost ("supervisorEntidadId");
    $supervisor ["consecutivoId"] = getValueFromPost ("supervisorConsecutivoId");
    $supervisor ["tipoId"] = getValueFromPost ("supervisorTipoId");
    $comentariIncidencia=strtoupper(getValueFromPost ("comentariIncidencia"));
    $incidenciaId = getValueFromPost ("incidenciaId");
    $asistenciaFecha = getValueFromPost ("asistenciaFecha");
    $usuarioCapturaAsistencia = $_SESSION ["userLog"]["usuario"];
    $tipoPeriodo=getValueFromPost ("tipoPeriodo");
    $puestoCubiertoId=getValueFromPost("puestoCubiertoId");
    $puntoServicioId=getValueFromPost ("empleadoPuntoServicioId");
    $idCliente=getValueFromPost("idCliente");
    $valordia=getValueFromPost("valordia");//1 si es de dia 2 si es de noche 0 si es 24X24
    $plantilladeservicio=getValueFromPost("plantilladeservicio");//roloperativo
    $idlineanegocioPunto=getValueFromPost("idlineanegocioPunto");//roloperativo
    $idPlantillaServicio=getValueFromPost("idPlantillaServicio");//is¨Planyilla

    try{
        // IMPORTANTEEEEEEE  crear una consulta por fecha a ingresar apuntando a la plantilla y si la plantilla esta dada de baja no podra continuar y le mandara un mnesaje de error diciendole la fecha en la que culmino esa plantilla 
        $Vigenciaplantilla = $negocio -> consultaVigenciaplantilla($idPlantillaServicio);
         // $log->LogInfo("Valor de la variable Vigenciaplantilla: " . var_export ($Vigenciaplantilla, true));
        $fecha_actual1 = $asistenciaFecha;
        // $log->LogInfo("Valor de la variable fecha_actual1: " . var_export ($fecha_actual1, true));
        $Fechaplantilla1 = $Vigenciaplantilla[0]["fechaTerminoPlantilla"]; 
        // $log->LogInfo("Valor de la variable Fechaplantilla1: " . var_export ($Fechaplantilla1, true));
        $fecha_actual = explode('-', $fecha_actual1);
        // $log->LogInfo("Valor de la variable fecha_actual: " . var_export ($fecha_actual, true));
        $fecha_actual_Anio = $fecha_actual[0];
        $fecha_actual_Mes = $fecha_actual[1];
        $fecha_actual_Dia = $fecha_actual[2];
        $Fechaplantilla = explode('-', $Fechaplantilla1);
        // $log->LogInfo("Valor de la variable Fechaplantilla: " . var_export ($Fechaplantilla, true));
        $Fechaplantilla_Anio = $Fechaplantilla[0];
        $Fechaplantilla_Mes = $Fechaplantilla[1];
        $Fechaplantilla_Dia = $Fechaplantilla[2];
        if($Fechaplantilla_Anio > $fecha_actual_Anio){
            $CondicionFecha = "1";
        }else{
            if($Fechaplantilla_Mes > $fecha_actual_Mes){
                $CondicionFecha = "1";
            }else{
                if($Fechaplantilla_Dia >= $fecha_actual_Dia){
                    $CondicionFecha = "1";
                }else{
                    $CondicionFecha = "0";
                }
            }
        }
        // $log->LogInfo("Valor de la variable CondicionFecha: " . var_export ($CondicionFecha, true));
        if($CondicionFecha=="1"){
            if($idCliente==2){
                $bandera=true;
            }else{
                $bandera=false;

                if($incidenciaId==4 || $incidenciaId==6 || $incidenciaId==7 || $incidenciaId==8 || $incidenciaId==10 || $incidenciaId==11 || $incidenciaId==13 || $incidenciaId==14){
                    $bandera=true;
                }else{
                    $plantillaturnosdiaonoche= $negocio -> consultaturnosdiaonochebyplantillaservicio($asistenciaFecha, $plantilladeservicio, $valordia,$puntoServicioId, $puestoCubiertoId,$idPlantillaServicio,1);
                    $cuentaturnosdiaonoche=$negocio -> consultaturnosdiaonochebyplantillaservicio($asistenciaFecha, $plantilladeservicio, $valordia,$puntoServicioId, $puestoCubiertoId,$idPlantillaServicio,2);
                    // $log->LogInfo("Valor de la variable plantillaturnosdiaonoche: " . var_export ($plantillaturnosdiaonoche, true));
                    // $log->LogInfo("Valor de la variable cuentaturnosdiaonoche: " . var_export ($cuentaturnosdiaonoche, true));
                    if(count($plantillaturnosdiaonoche)!=0){
                        $dias = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sabado");
                        $fechats = strtotime($asistenciaFecha); //fecha en yyyy-mm-dd
                        $diaSemana=$dias[date('w', $fechats)];
                        switch($diaSemana){

                            case ($diaSemana=="Lunes" && $valordia==1  || $diaSemana=="Lunes" && $valordia==2): 
                                $turnosDia=$plantillaturnosdiaonoche[0]["LunesTurnoDia"];
                                $turnosNoche=$plantillaturnosdiaonoche[0]["LunesTurnoNoche"];
                                $turnosdianocheconteo=$cuentaturnosdiaonoche[0]["turnosdiaonoche"];
                                break;
                            case ($diaSemana=="Lunes" && $valordia==0): 
                                $turnosDia=$plantillaturnosdiaonoche[0]["LunesTurnoDia"];
                                $turnosNoche=$plantillaturnosdiaonoche[0]["LunesTurnoNoche"];
                                $turnosdia24x24=$cuentaturnosdiaonoche[0]["turnosdiaonoche"];
                                $turnosnoche24x24=$cuentaturnosdiaonoche[1]["turnosdiaonoche"]; 
                                break;
                            case (($diaSemana=="Martes" && $valordia==1)  || ($diaSemana=="Martes" && $valordia==2)): 
                                $turnosDia=$plantillaturnosdiaonoche[0]["MartesTurnoDia"];
                                $turnosNoche=$plantillaturnosdiaonoche[0]["MartesTurnoNoche"];
                                $turnosdianocheconteo=$cuentaturnosdiaonoche[0]["turnosdiaonoche"];
                                break;
                            case ($diaSemana=="Martes" && $valordia==0): 
                                $turnosDia=$plantillaturnosdiaonoche[0]["MartesTurnoDia"];
                                $turnosNoche=$plantillaturnosdiaonoche[0]["MartesTurnoNoche"];
                                $turnosdia24x24=$cuentaturnosdiaonoche[0]["turnosdiaonoche"];
                                $turnosnoche24x24=$cuentaturnosdiaonoche[1]["turnosdiaonoche"]; 
                                break;
                            case ($diaSemana=="Miércoles" && $valordia==1  || $diaSemana=="Miércoles" && $valordia==2): 
                                $turnosDia=$plantillaturnosdiaonoche[0]["MiercolesTurnoDia"];
                                $turnosNoche=$plantillaturnosdiaonoche[0]["MiercolesTurnoNoche"];
                                $turnosdianocheconteo=$cuentaturnosdiaonoche[0]["turnosdiaonoche"];
                                break;
                            case ($diaSemana=="Miércoles" && $valordia==0): 
                                $turnosDia=$plantillaturnosdiaonoche[0]["MiercolesTurnoDia"];
                                $turnosNoche=$plantillaturnosdiaonoche[0]["MiercolesTurnoNoche"];
                                $turnosdia24x24=$cuentaturnosdiaonoche[0]["turnosdiaonoche"];
                                $turnosnoche24x24=$cuentaturnosdiaonoche[1]["turnosdiaonoche"]; 
                                break;
                            case ($diaSemana=="Jueves" && $valordia==1  || $diaSemana=="Jueves" && $valordia==2): 
                                $turnosDia=$plantillaturnosdiaonoche[0]["JuevesTurnoDia"];
                                $turnosNoche=$plantillaturnosdiaonoche[0]["JuevesTurnoNoche"];
                                $turnosdianocheconteo=$cuentaturnosdiaonoche[0]["turnosdiaonoche"];
                                break;
                            case ($diaSemana=="Jueves" && $valordia==0): 
                                $turnosDia=$plantillaturnosdiaonoche[0]["JuevesTurnoDia"];
                                $turnosNoche=$plantillaturnosdiaonoche[0]["JuevesTurnoNoche"];
                                $turnosdia24x24=$cuentaturnosdiaonoche[0]["turnosdiaonoche"];
                                $turnosnoche24x24=$cuentaturnosdiaonoche[1]["turnosdiaonoche"]; 
                                break;
                            case ($diaSemana=="Viernes" && $valordia==1  || $diaSemana=="Viernes" && $valordia==2): 
                                $turnosDia=$plantillaturnosdiaonoche[0]["ViernesTurnoDia"];
                                $turnosNoche=$plantillaturnosdiaonoche[0]["ViernesTurnoNoche"];
                                $turnosdianocheconteo=$cuentaturnosdiaonoche[0]["turnosdiaonoche"];
                                break;
                            case ($diaSemana=="Viernes" && $valordia==0): 
                                $turnosDia=$plantillaturnosdiaonoche[0]["ViernesTurnoDia"];
                                $turnosNoche=$plantillaturnosdiaonoche[0]["ViernesTurnoNoche"];
                                $turnosdia24x24=$cuentaturnosdiaonoche[0]["turnosdiaonoche"];
                                $turnosnoche24x24=$cuentaturnosdiaonoche[1]["turnosdiaonoche"]; 
                                break;
                            case ($diaSemana=="Sabado" && $valordia==1  || $diaSemana=="Sabado" && $valordia==2): 
                                $turnosDia=$plantillaturnosdiaonoche[0]["SabadoTurnoDia"];
                                $turnosNoche=$plantillaturnosdiaonoche[0]["SabadoTurnoNoche"];
                                $turnosdianocheconteo=$cuentaturnosdiaonoche[0]["turnosdiaonoche"];
                                break;
                            case ($diaSemana=="Sabado" && $valordia==0): 
                                $turnosDia=$plantillaturnosdiaonoche[0]["SabadoTurnoDia"];
                                $turnosNoche=$plantillaturnosdiaonoche[0]["SabadoTurnoNoche"];
                                $turnosdia24x24=$cuentaturnosdiaonoche[0]["turnosdiaonoche"];
                                $turnosnoche24x24=$cuentaturnosdiaonoche[1]["turnosdiaonoche"]; 
                                break;
                            case ($diaSemana=="Domingo" && $valordia==1  || $diaSemana=="Domingo" && $valordia==2): 
                                $turnosDia=$plantillaturnosdiaonoche[0]["DomingoTurnoDia"];
                                $turnosNoche=$plantillaturnosdiaonoche[0]["DomingoTurnoNoche"];
                                $turnosdianocheconteo=$cuentaturnosdiaonoche[0]["turnosdiaonoche"];
                                break;
                            case ($diaSemana=="Domingo" && $valordia==0): 
                                $turnosDia=$plantillaturnosdiaonoche[0]["DomingoTurnoDia"];
                                $turnosNoche=$plantillaturnosdiaonoche[0]["DomingoTurnoNoche"];
                                $turnosdia24x24=$cuentaturnosdiaonoche[0]["turnosdiaonoche"];
                                $turnosnoche24x24=$cuentaturnosdiaonoche[1]["turnosdiaonoche"]; 
                                break;
                            default:  $turnosDia="";  $turnosNoche="";
                        }

                        if($incidenciaId==1){// se tuvo que hace por casos ya que los descansos son variados dependiendo el rol y no se tiene una secuencia fija 
                            $DescansosDisponibles= $negocio -> ConsultaDescansosDisponibles($idPlantillaServicio);
                            $NumeroElementos = intval($DescansosDisponibles[0]["numeroElementos"]);
                            // $ElementosPorCelula = intval($DescansosDisponibles[0]["MultiploParaCelula"]);
                            // $DescansosPorCelula = intval($DescansosDisponibles[0]["DescansosPorCelula"]);
                            $IdRolOperativoPlantilla = $DescansosDisponibles[0]["IdRolOperativoPlantilla"]; 
                            
                            if($IdRolOperativoPlantilla == "1" || $IdRolOperativoPlantilla==1){// Roles 12x12x7  DescansosXDIa = 5 x Mes Por Cada Elemento
                                $explodeFechaAsis = explode('-', $asistenciaFecha);
                                $anioInicioAsist = $explodeFechaAsis[0];
                                $mesInicioAsist = $explodeFechaAsis[1];
                                $diaInicioAsist = $explodeFechaAsis[2];
                                $FechaInicio = $anioInicioAsist."-".$mesInicioAsist."-01";
                                $FechaFin = $anioInicioAsist."-".$mesInicioAsist."-31";
                                $ConsultaTurnosCubiertosDiaNoche= $negocio -> ConsultaTurnosCubiertosDiaYNoche($idPlantillaServicio,$FechaInicio,$FechaFin);//8 = descanso Dia 9=Descanso noche
                                $DescansosTomados = intval($ConsultaTurnosCubiertosDiaNoche[0]["desacansodiaonoche"]);
                                // $log->LogInfo("Valor de la variable asistenciaFecha: " . var_export ($asistenciaFecha, true));
                                if($diaInicioAsist < 16 || $diaInicioAsist < "16"){
                                    $DescansosQuincenales =$NumeroElementos * 3;
                                }else{
                                    $DescansosQuincenales =$NumeroElementos * 5;
                                }
                                $DescansosDisponiblesQuincena = $DescansosQuincenales-$DescansosTomados;
                                if($DescansosDisponiblesQuincena < 1){
                                    $bandera=false;
                                    $mensaje = "No Puedes realizar registro de asistencia debido a que has culminado con los descansos disponibles para esta plantilla";
                                }else{
                                    $bandera=true;
                                }
                            }else if($IdRolOperativoPlantilla == "2" || $IdRolOperativoPlantilla==2 || $IdRolOperativoPlantilla == "3" || $IdRolOperativoPlantilla==3 || $IdRolOperativoPlantilla == "4" || $IdRolOperativoPlantilla==4 || $IdRolOperativoPlantilla == "5" || $IdRolOperativoPlantilla==5 || $IdRolOperativoPlantilla == "9" || $IdRolOperativoPlantilla==9){// Roles 12x12x6,12x12x5,12x12x3,12x12x1 formula #elementos-(TurnodDia+TurnosNoche)=DescanDiarios

                                $ConsultaTurnosCubiertosDiaNoche= $negocio -> ConsultaTurnosCubiertosDiaYNoche($idPlantillaServicio,$asistenciaFecha,100);//8 = descanso Dia 9=Descanso noche
                                $DescansosTomados = intval($ConsultaTurnosCubiertosDiaNoche[0]["desacansodiaonoche"]);
                                $TurnosTotalesPorDia = $turnosDia+$turnosNoche;
                                $DescansosPorDia = $NumeroElementos-$TurnosTotalesPorDia;// ventas
                                $DesacansosPorDiaDisponibles = $DescansosPorDia-$DescansosTomados;
                                if($DesacansosPorDiaDisponibles < 1){
                                    $bandera=false;
                                    $mensaje = "No Puedes realizar registro de asistencia debido a que has culminado con los descansos disponibles de este dia para esta plantilla";
                                }else{
                                    $bandera=true;
                                }
                            }else if($IdRolOperativoPlantilla == "6" || $IdRolOperativoPlantilla==6){// termina el caso 12X12X5,6,3,1, comienza el caso 12X24X7 id 5 en el catalogo roles
                                $bandera=false;
                                $mensaje = "No Puedes realizar registro de descansos para esta plantilla";
                            }else{ // termina el caso 24X24X7 Y Comienza los casos adicionales que hasta la fecha son HORARIO OFICINA id 7 y NO DEFINIDO id 8
                                $bandera=true; 
                            }
                            // $log->LogInfo("Valor de la variable bandera: " . var_export ($bandera, true));
                        }else{
                            // $log->LogInfo("Valor de la variable turnosDia: " . var_export ($turnosDia, true));
                            // $log->LogInfo("Valor de la variable turnosNoche: " . var_export ($turnosNoche, true));
                            if(($turnosDia!="NULL" && $turnosDia!=NULL && $turnosDia!="") || ( $turnosNoche!="NULL" && $turnosNoche!=NULL && $turnosNoche!="")) {
                                if( $idlineanegocioPunto == "1"){
                                    if( $valordia==1){//tuenos de dia
                                        if($turnosDia>$turnosdianocheconteo){
                                            $bandera=true;
                                        }else{
                                            $mensaje="No Puedes realizar registro de asistencia debido a que has culminado con los turnos disponibles por Día para esta plantilla";
                                        }
                                    }else if($valordia==2){ //turnosdenoche
                                        if($turnosNoche>$turnosdianocheconteo){
                                            $bandera=true;
                                        }else{
                                            $mensaje="No Puedes realizar registro de asistencia debido a que has culminado con los turnos disponibles por Noche para esta plantilla";
                                        }
                                    }else if( $valordia==0){
                                        if($turnosDia<=$turnosdia24x24 && $turnosNoche<=$turnosnoche24x24){
                                            $mensaje="No Puedes realizar registro de asistencia debido a que has culminado con los turnos disponibles por Día y Noche para esta plantilla";
                                        }
                                        else if( $turnosDia<=$turnosdia24x24){
                                            $mensaje="No Puedes realizar registro de asistencia debido a que has culminado con los turnos disponibles por Día para esta plantilla";
                                        }else if($turnosNoche<=$turnosnoche24x24){
                                            $mensaje="No Puedes realizar registro de asistencia debido a que has culminado con los turnos disponibles por Noche para esta plantilla";
                                        }else{
                                            $bandera=true; 
                                        }
                                    } 
                                }else{
                                    $bandera=true;
                                }  
                            }else{
                                $mensaje = "No Puedes registrar asistencia debido a que no se especificaron turnos para este dia";
                            }
                        }    
                    }else{
                        $mensaje = "No se encontro plantilla de servicio definida para pasar asistencia,por favor verifica que la plantilla del empleado coincida con la plantillade servicio del punto de servicio";
                    }
                }
            }//else de cliente 
            if($bandera){
                $caso = "2";
                $requisiciones= $negocio -> getDetalleRequisicionesByPuntoServicioId($puntoServicioId,$idPlantillaServicio,$caso);
                //$log->LogInfo("Valor de la variable requisiciones: " . var_export ($requisiciones, true));
                $puestos=array();
                $descripcionPuesto=array();
                for($i=0; $i<count($requisiciones); $i++){
                    $puestos[$i]=$requisiciones[$i]["puestoPlantillaId"];
                    $descripcionPuesto[$i]=$requisiciones[$i]["descripcionPuesto"];
                }
                if($idCliente<>2){
                    //$log->LogInfo("Valor de la variable puestoCubiertoId: " . var_export ($puestoCubiertoId, true));
                    //$log->LogInfo("Valor de la variable puestos: " . var_export ($puestos, true));
                    //$log->LogInfo("Valor de la variable aaaaaaaaaaaaaaaaaaaa: " . var_export (in_array($puestoCubiertoId, $puestos), true));
                    if (in_array($puestoCubiertoId, $puestos)==false) {
                        $response ["status"] = "errorCobertura";
                        $response ["message"] = "Puesto de cobertura invalido";
                        $response["puestosCobertura"]=$descripcionPuesto;
                    }else{
                        $response = $negocio -> registrarAsistencia ( 
                            $empleado, 
                            $supervisor, 
                            $incidenciaId, 
                            $asistenciaFecha, 
                            $usuarioCapturaAsistencia,
                            $comentariIncidencia,
                            $tipoPeriodo, $puestoCubiertoId,
                            $plantilladeservicio,$idPlantillaServicio);
                        //$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
                        $fechasPeriodo = $negocio -> obtenerListaDiasParaAsistencia ($tipoPeriodo);
                        //$log->LogInfo("Valor de la variable fechasPeriodo: " . var_export ($fechasPeriodo, true));
                             // Recupera la lista de asistencias del empleado por todo el periodo
                        $response ["asistencia"] =  $negocio -> getAsistenciaByEmpleadoPeriodo ($fechasPeriodo[0]["fecha"], 
                            $fechasPeriodo[count($fechasPeriodo) - 1]["fecha"], 
                            $empleado["entidadId"], 
                            $empleado ["consecutivoId"], 
                            $empleado ["tipoId"]);
                        // $log->LogInfo("Valor de la variable asis: " . var_export ($response ["asistencia"], true));
                        //$log->LogInfo("Valor de la variable response1: " . var_export ($response, true));
                    }
                }else{
                    $response = $negocio -> registrarAsistencia (
                    $empleado, 
                    $supervisor, 
                    $incidenciaId, 
                    $asistenciaFecha, 
                    $usuarioCapturaAsistencia,
                    $comentariIncidencia,
                    $tipoPeriodo, $puestoCubiertoId,
                    $plantilladeservicio,$idPlantillaServicio);
                    $fechasPeriodo = $negocio -> obtenerListaDiasParaAsistencia ($tipoPeriodo);
                    // Recupera la lista de asistencias del empleado por todo el periodo
                    $response ["asistencia"] =  $negocio -> getAsistenciaByEmpleadoPeriodo ($fechasPeriodo[0]["fecha"], 
                    $fechasPeriodo[count($fechasPeriodo) - 1]["fecha"], 
                    $empleado["entidadId"], 
                    $empleado ["consecutivoId"], 
                    $empleado ["tipoId"]);
                }
                if($response ["status"] == "success"){
                    $negocio -> negocio_registrarTipoTurno($incidenciaId,$valordia,$asistenciaFecha,$empleado,$puntoServicioId);
                }else{
                    $response ["status"] = "error";
                    $response ["message"] = $mensaje;
                }
            }else{
            $response ["status"] = "error";
            $response ["message"] = $mensaje;
            }
        }else{
            $response ["status"] = "error";
            $response ["message"] = "Error en la plantilla seleccionada, Ya culmino la vigencia de esta plantilla"; 
        }
    }catch(Exception $e){
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }
}
else
{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}
echo json_encode ($response);
?>
