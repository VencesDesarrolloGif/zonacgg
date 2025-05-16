<?php
// file: ajax_registrarAsistencia.php

// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo. 
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");

$negocio = new Negocio ();

verificarInicioSesion ($negocio);

$response = array ();

if (!empty ($_POST))
{
    $log = new KLogger ( "ajaxRegistroIncicenciaEspecial.log" , KLogger::DEBUG );
    $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));

    $empleado ["entidadId"] = getValueFromPost ("empleadoEntidadId");
    $empleado ["consecutivoId"] = getValueFromPost ("empleadoConsecutivoId");
    $empleado ["tipoId"] = getValueFromPost ("empleadoTipoId");
    $empleado ["puntoServicioId"] = getValueFromPost ("empleadoPuntoServicioId");
    $supervisor ["entidadId"] = getValueFromPost ("supervisorEntidadId");
    $supervisor ["consecutivoId"] = getValueFromPost ("supervisorConsecutivoId");
    $supervisor ["tipoId"] = getValueFromPost ("supervisorTipoId");       
    $comentariIncidencia=strtoupper(getValueFromPost ("comentariIncidencia"));
    $puntoServicioId=getValueFromPost ("empleadoPuntoServicioId");
    $incidenciaId = getValueFromPost ("incidenciaId");
    $asistenciaFecha = getValueFromPost ("asistenciaFecha");
    $usuarioCapturaAsistencia = $_SESSION ["userLog"]["usuario"];
    $tipoPeriodo=getValueFromPost ("tipoPeriodo");
    $incidenciaPuesto=getValueFromPost("incidenciaPuesto");
    $idCliente=getValueFromPost("idCliente");
    $selplantillaservicioincidencia=getValueFromPost("selplantillaservicioincidencia");
    $lineanegocioincidenciaespecial=getValueFromPost("lineanegocioincidenciaespecial");
    $idPlantillaServicio=getValueFromPost("idPlantillaServicio");
    $selectMotivoIncidenciaEspecial=getValueFromPost("selectMotivoIncidenciaEspecial");
    //$log->LogInfo("Valor de la variable incidenciaPuesto: " . var_export ($incidenciaPuesto, true));
    if($incidenciaId==1 || $incidenciaId==2){
        $valordia =1;
    }else if($incidenciaId==6 || $incidenciaId==7){
        $valordia =2;
    }
    try{
        $Vigenciaplantilla = $negocio -> consultaVigenciaplantilla($idPlantillaServicio);
        $fecha_actual1 = $asistenciaFecha;
        $Fechaplantilla1 = $Vigenciaplantilla[0]["fechaTerminoPlantilla"]; 
        $fecha_actual = explode('-', $fecha_actual1);
        $fecha_actual_Anio = $fecha_actual[0];
        $fecha_actual_Mes = $fecha_actual[1];
        $fecha_actual_Dia = $fecha_actual[2];
        $Fechaplantilla = explode('-', $Fechaplantilla1);
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
        if($CondicionFecha=="1"){
            $banderapeticion=false;
            if($lineanegocioincidenciaespecial!=1){
                if($incidenciaId==1 || $incidenciaId==6){
                    $caso = "2";
                    $requisiciones= $negocio -> getDetalleRequisicionesByPuntoServicioId($puntoServicioId,$idPlantillaServicio,$caso);
                    $puestos=array();
                    $descripcionPuesto=array();
                    for($i=0; $i<count($requisiciones); $i++){
                        $puestos[$i]=$requisiciones[$i]["puestoPlantillaId"];
                        $descripcionPuesto[$i]=$requisiciones[$i]["descripcionPuesto"];
                    }      
                    if (in_array($incidenciaPuesto, $puestos)==false) {
                        $response ["status"] = "errorCobertura";
                        $response ["message"] = "Puesto de cobertura invalido";
                        $response["puestosCobertura"]=$descripcionPuesto;
                        $mensaje="Puesto de cobertura invalido";
                        $bandera=false;
                    }else{
                        $log->LogInfo("Valor de la variable selectMotivoIncidenciaEspecial: " . var_export ($selectMotivoIncidenciaEspecial, true));
                        $response = $negocio -> PeticionIncidenciaEspecial (
                        $empleado, 
                        $supervisor, 
                        $incidenciaId, 
                        $asistenciaFecha,  
                        $usuarioCapturaAsistencia,
                        $comentariIncidencia,
                        $tipoPeriodo, $incidenciaPuesto,$selplantillaservicioincidencia,$idPlantillaServicio,$selectMotivoIncidenciaEspecial);
                        $status=$response["status"];
                        if($status=="error"){
                            $mensaje= 'No se proporcionaron todos los datos necesarios para el registro de asistencia';
                            $bandera=false;
                            $banderapeticion=false;
                        }else{
                            $mensaje="Tu peticion de incidencia especial sera procesada una vez confirmada se contabilizara tu incidencia";
                            $bandera=false;
                            $banderapeticion=true;
                        }
                    }
                }else{
                    $response = $negocio -> registrarIncidenciaEspecial (
                    $empleado, 
                    $supervisor, 
                    $incidenciaId, 
                    $asistenciaFecha, 
                    $usuarioCapturaAsistencia,
                    $comentariIncidencia,
                    $tipoPeriodo, $incidenciaPuesto,$selplantillaservicioincidencia,$idPlantillaServicio,$selectMotivoIncidenciaEspecial);
                }if($banderapeticion){
                    $response ["status"] = "error2";
                }
            }else{
                if($idCliente==2){
                    $bandera=true;
                }else{
                    $bandera=false;
                    if($incidenciaId==3 || $incidenciaId==4 || $incidenciaId==5 ){
                        $bandera=true;
                    }else{
                        $plantillaturnosdiaonoche= $negocio -> consultaturnosdiaonochebyplantillaservicio($asistenciaFecha, $selplantillaservicioincidencia, $valordia,$puntoServicioId, $incidenciaPuesto,$idPlantillaServicio,1);
                        $cuentaturnosdiaonoche=$negocio -> consultaturnosdiaonochebyplantillaservicio($asistenciaFecha, $selplantillaservicioincidencia, $valordia,$puntoServicioId, $incidenciaPuesto,$idPlantillaServicio,2);
                        if(count($plantillaturnosdiaonoche)!=0){
                            $dias = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sabado");
                            $fechats = strtotime($asistenciaFecha); //fecha en yyyy-mm-dd
                            $diaSemana=$dias[date('w', $fechats)];
                            switch($diaSemana)
                            {
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
                            if(($turnosDia!="NULL" && $turnosDia!=NULL && $turnosDia!="") || ( $turnosNoche!="NULL" && $turnosNoche!=NULL && $turnosNoche!="")) {
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
                                $mensaje = "No Puedes registrar asistencia debido a que no se especificaron turnos para este dia";
                            }
                        }else{
                            $mensaje = "No se encontro plantilla de servicio definida para pasar asistencia,por favor verifica que la plantilla del empleado coincida con la plantillade servicio del punto de servicio";
                        } 
                    }
                }
                if($bandera){
                    $caso = "2";
                    $requisiciones= $negocio -> getDetalleRequisicionesByPuntoServicioId($puntoServicioId,$idPlantillaServicio,$caso);
                    $puestos=array();
                    $descripcionPuesto=array();
                    for($i=0; $i<count($requisiciones); $i++){
                        $puestos[$i]=$requisiciones[$i]["puestoPlantillaId"];
                        $descripcionPuesto[$i]=$requisiciones[$i]["descripcionPuesto"];
                    }
                    if($idCliente<>2){
                        if (in_array($incidenciaPuesto, $puestos)==false) {
                            $response ["status"] = "errorCobertura";
                            $response ["message"] = "Puesto de cobertura invalido";
                            $response["puestosCobertura"]=$descripcionPuesto;
                        }else{
                            $response = $negocio -> registrarIncidenciaEspecial (
                                $empleado, 
                                $supervisor, 
                                $incidenciaId, 
                                $asistenciaFecha, 
                                $usuarioCapturaAsistencia,
                                $comentariIncidencia,
                                $tipoPeriodo, $incidenciaPuesto,$selplantillaservicioincidencia,$idPlantillaServicio,$selectMotivoIncidenciaEspecial);
                        }
                    }else{
                        $response = $negocio -> registrarIncidenciaEspecial (
                        $empleado, 
                        $supervisor, 
                        $incidenciaId, 
                        $asistenciaFecha, 
                        $usuarioCapturaAsistencia,
                        $comentariIncidencia,
                        $tipoPeriodo, $incidenciaPuesto,$selplantillaservicioincidencia,$idPlantillaServicio,$selectMotivoIncidenciaEspecial);
                    }
                }else{
                    $response ["status"] = "error";
                    $response ["message"] = $mensaje;
                }
            }
        }else{
            $response ["status"] = "error";
            $response ["message"] = "Error en la plantilla seleccionada, Ya culmino la vigencia de esta plantilla"; 
        }
    }catch(Exception $e){
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }
}else
{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}
echo json_encode ($response);
?>
