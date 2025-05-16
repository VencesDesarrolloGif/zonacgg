<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
// $log = new KLogger("ajaxReporteDetalle.log", KLogger::DEBUG);
// $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
$response = array("status" => "success");
$fecha1   = getValueFromPost("fecha1");
$fecha2   = getValueFromPost("fecha2");
$idClientePunto= getValueFromPost("idClientePunto");
$tipoConsulta  = getValueFromPost("tipoConsulta");
$diasElegidos  = getValueFromPost("diasElegidos");

$dt1  = date($fecha1); 
$dt1  = new DateTime($dt1);   
$anio1= $dt1->format('Y');
$mes1 = $dt1->format('m');
$dia1 = $dt1->format('d');

$dt2  = date($fecha2);    
$dt2  = new DateTime($dt2); 
$anio2= $dt2->format('Y');
$mes2 = $dt2->format('m');

$fecha= $anio2 . "-" . $mes2;
$ban  = 0;
$aux  = date('Y-m-d', strtotime("{$fecha} + 1 month"));
$last_day= date('Y-m-d', strtotime("{$aux} -1  day"));
         
if($anio1== $anio2 && $mes1==$mes2 && $last_day == $fecha2 && $dia1=='01'){
   $ban=1;
}

try{
    $lista = $negocio -> getPuntosServiciosByClienteId($fecha1, $fecha2, $idClientePunto);//, $LineaNegocioRF
    $listaUnificada = array ();
    $listaToGrafica = array ();

    for($i = 0; $i < count($lista); $i++){
        $item= $lista[$i];
        $servicio   = $item ["puntoServicioPlantillaId"];
        $supervisor = $negocio -> negocio_getSupervisorPunto($servicio);
        $key = $item ["puntoServicioPlantillaId"]."_" . $item ["puestoPlantillaId"] ."_".  $item ["rolOperativoPlantilla"] ;
        $fechaInicioSer= $item["fechaInicio"];//fechas punto de servicio
        $fechaFinSer   = $item["fechaTerminoPlantilla"];//fechas punto de servicio
        $fechaInicioPL = $item["fechaInicioPlantilla"];//fechas plantilla
        $fechaFinPL    = $item["fechaFinPlantilla"];//fechas plantilla
        $fechaFinPLOriginal= $item["fechaFinPlantilla"];//fechas plantilla
        $idPlantilla   = $item["servicioPlantillaId"];
        $statusPlantilla= $item["estatusPlantilla"];
        $replicada = $item["replicada"];
        $statusPs  = $item["esatusPunto"];
        $entidadPS = $item["nombreEntidadFederativa"];
        // agregado 
        $result = array ();
        $turnosPorDia =0;
        $turnoDeDia   =0;
        $turnosDeNoche=0;
        $turnosCubiertosDia[$idPlantilla]  =0;
        $turnosCubiertosNoche[$idPlantilla]=0;
        
        if($replicada=='1'){//Original Replicada
           $fechaFinPLXplod = explode("-", $fechaFinPL);
           $aniofechaFinPL= $fechaFinPLXplod[0];
           $mesfechaFinPL = $fechaFinPLXplod[1];
           $ultimoDiafechaFinPL = $fechaFinPLXplod[2];
           $diaFinNuevoFin = $ultimoDiafechaFinPL-1;
           if ($diaFinNuevoFin<10) {
                $diaFinNuevoFin="0".$diaFinNuevoFin;
           }
           $fechaFinPL = $aniofechaFinPL."-".$mesfechaFinPL."-".$diaFinNuevoFin;
           $item["fechaFinPlantilla"]=$fechaFinPL;  
        }  

        if(strtotime($item["fechaInicioPlantilla"])<strtotime($fecha1)){
           $item["fechaInicioPlantilla"]=$fecha1;
        }else{
              $item["fechaInicioPlantilla"]=$item["fechaInicioPlantilla"];
        }

        if(strtotime($item["fechaFinPlantilla"])>strtotime($fecha2)){
              $item["fechaFinPlantilla"]=$fecha2;
        }

        $item["dias"]=0;
        $diasC31=0;
        $diasSinCondiciones=0;

        for($j = $item["fechaInicioPlantilla"]; $j <=  $item["fechaFinPlantilla"]; $j = date("Y-m-d", strtotime($j ."+ 1 days"))){

            $item["dias"]=$item["dias"]+1;
            $TurnoDiaSolicitado  = 0;
            $TurnoNocheSolicitado= 0;
            $dias= array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
            $dia = $dias[(date('N', strtotime($j))) - 1];
            $turnoDiaC   = $dia."TurnoDia";
            $turnoNocheC = $dia."TurnoNoche";
            $TurnoDiaSolicitado  = 0;
            $TurnoNocheSolicitado= 0;
            $DiasSolicitud= $negocio -> DiasSolicitados($idPlantilla,$turnoDiaC,$turnoNocheC);//se utiliza la funcion  del ajax_ConteoTurnosXDia
            $contadorArray = count($DiasSolicitud);

            if($contadorArray==0){
               $TurnoDiaSolicitado  = $TurnoDiaSolicitado + 0;
               $TurnoNocheSolicitado= $TurnoNocheSolicitado + 0;
            }else{
                  $TurnoDiaSolicitado  = $DiasSolicitud[0][$turnoDiaC];
                  $TurnoNocheSolicitado= $DiasSolicitud[0][$turnoNocheC];
            }

            $turnosPorDia = $turnosPorDia + $TurnoDiaSolicitado + $TurnoNocheSolicitado; 
            $turnoDeDia   = $turnoDeDia + $TurnoDiaSolicitado; 
            $turnosDeNoche= $turnosDeNoche +  $TurnoNocheSolicitado;
            $listaTurnosCubiertosSeparados= $negocio -> TurnosCubiertoXPs($j,$servicio);
                      
            for($k=0; $k<count($listaTurnosCubiertosSeparados);$k++){
                $tipoTurno = $listaTurnosCubiertosSeparados[$k]["tipoTurno"];
                $plantillaCob = $listaTurnosCubiertosSeparados[$k]["requisicionId"];
                
                if($tipoTurno=='1' || $tipoTurno=='3' || $tipoTurno=='5' || $tipoTurno=='7' || $tipoTurno=='18'){
                    if($idPlantilla==$plantillaCob){
                       $turnosCubiertosDia[$idPlantilla] = $turnosCubiertosDia[$idPlantilla]+1;//AA
                    }
                }

                if($tipoTurno=='2' || $tipoTurno=='4' || $tipoTurno=='6' || $tipoTurno=='7' || $tipoTurno=='18'){
                    if($idPlantilla==$plantillaCob){
                       $turnosCubiertosNoche[$idPlantilla] = $turnosCubiertosNoche[$idPlantilla]+1;
                    }
                }   
            }

            $listaTurnosIncidencias = $negocio -> TurnosCubiertoIncidenciasSeparadosXPS($j,$servicio,$idClientePunto);//Turnos Extras AUIIIIIIIIIIIIIIIIII
                      
            for($m=0; $m<count($listaTurnosIncidencias);$m++){

                $incidenciaId = $listaTurnosIncidencias[$m]["incidenciaId"];
                $plantillaInc = $listaTurnosIncidencias[$m]["requisicionId"];

                if($incidenciaId=='1'){
                    if($idPlantilla==$plantillaInc){
                       $turnosCubiertosDia[$idPlantilla] = $turnosCubiertosDia[$idPlantilla]+1;
                    }
                }

                if($incidenciaId=='6'){
                    if($idPlantilla==$plantillaInc){
                       $turnosCubiertosNoche[$idPlantilla] = $turnosCubiertosNoche[$idPlantilla]+1;
                    }
                }
            }//for m
        }//for j

        $diasSinCondiciones = $item["dias"];

        if($item["estatusPlantilla"]==0 and strtotime($item["fechaFinPlantilla"])>strtotime("now")){
           $item["dias"]=0;
        }

        if($item["turnosFlat"]=='1' && $ban==1){
           $fi = $item["fechaInicioPlantilla"];
           $fechIni   = new DateTime($fi); 
           $fechFinInp= new DateTime($fecha2); 
           $a = $item["fechaFinPlantilla"];
           $dt1 = new DateTime($a); 
            
            if(strtotime($item["fechaInicioPlantilla"])>strtotime($fecha1) && strtotime($item["fechaFinPlantilla"])<strtotime($fecha2)){
               $diast1    = $fechIni->diff($dt1);
               $dtstr1    = $diast1->format('%R%a');
               $dtstring1 = substr($dtstr1, 1);
               $diast1    = (int) $dtstring1;
               $item["dias"]=$diast1 ;
            }else if(strtotime($item["fechaInicioPlantilla"])>strtotime($fecha1) && strtotime($item["fechaInicioPlantilla"])<strtotime($fecha2)){
                     $diast    = $fechIni->diff($fechFinInp);
                     $dtstr    = $diast->format('%R%a');
                     $dtstring = substr($dtstr, 1);
                     $diast    = (int) $dtstring;
                     $item["dias"]=$diast ;
            }else if(strtotime($item["fechaFinPlantilla"])>strtotime($fecha1) && strtotime($item["fechaFinPlantilla"])<strtotime($fecha2)){
                    $diass  = $dt1->format('d'); 
                    $item["dias"]=$diass ;
            }else{
                  $item["dias"]='30';
            }
        }

        if(!isset ($listaUnificada [$key])){
           $listaUnificada[$key] = array ();
           $listaUnificada[$key]["RegistrosUnificados"] = 0;
           $listaUnificada[$key]["turnosPresupuestadosPeriodo"] = 0;
           $listaUnificada[$key]["cobroPresupuestado"] = 0;
           $listaUnificada[$key]["numEle"] = 0;
           $listaUnificada[$key]["turnosPresupuesto"]=0;
           $listaUnificada[$key]["CostoTurno"]=0;
        }

        $listaUnificada[$key]["replicada"] = $replicada; 
        $listaUnificada[$key]["cobra31"]   = $item ["cobra31"]; 
        $listaUnificada[$key]["turnosFlat"]= $item ["turnosFlat"]; 
        $listaUnificada[$key]["numEle"]   += intval ($item ["numEle"]);

        $resultado1  = 0;
        $ultimoDiaM  = explode("-", $last_day);
        $ultimoDiaMes=$ultimoDiaM[2];

        $fecha1Xplod    = explode("-", $fecha1);
        $primerDiafecha1=$fecha1Xplod[2];

        $fecha2Xplod    = explode("-", $fecha2);
        $ultimoDiaFecha2=$fecha2Xplod[2];

        $fechaInicioSerXplod = explode("-", $fechaInicioPL);
        $diafechaInicioSer   = $fechaInicioSerXplod[2];

        $fechaFinSerXplod    = explode("-", $fechaFinPL);
        $ultimoDiafechaFinSer= $fechaFinSerXplod[2];

        if($item["turnosFlat"] =='1'){

            if(strtotime($fechaInicioPL)<=strtotime($fecha1) && strtotime($fechaFinPL)>strtotime($fecha2)){

                if($tipoConsulta=='3'){//mes

                   $resultadoF= $item ["numEle"]*30;

                }if($tipoConsulta=='2'){//15na

                    $resultadoF= $item ["numEle"]*15;

                }if($tipoConsulta=='1'){//semana

                    if($diasElegidos=='4'){
                       $resultadoF= $item ["numEle"]*9;
                    }else{
                       $resultadoF= $item ["numEle"]*7;
                    }
                }
            }if(strtotime($fechaInicioPL)>strtotime($fecha1) && strtotime($fechaFinPL)>strtotime($fecha2)){

                if($diafechaInicioSer=='30' || $diafechaInicioSer=='31') {
                   $resultadoF= 1*$item ["numEle"];
                }else{

                    if($tipoConsulta=='3'){//mes

                       $resultado1= (30-$diafechaInicioSer)+1;

                    }if($tipoConsulta=='2'){//15na

                        if ($ultimoDiaFecha2<=15) {
                            $resultado1= ($ultimoDiaFecha2-$diafechaInicioSer)+1;
                        }else{
                            $resultado1= (30-$diafechaInicioSer)+1;
                        }
 
                    }if($tipoConsulta=='1'){//semana

                        if($diasElegidos=='4'){
                           $resultado1= (30-$diafechaInicioSer)+1;
                        }else{
                          $resultado1= ($ultimoDiaFecha2-$diafechaInicioSer)+1;
                        }
                    }
                    $resultadoF= $item ["numEle"]*$resultado1;
                }
            }if(strtotime($fechaInicioPL)>strtotime($fecha1) && strtotime($fechaFinPL)<strtotime($fecha2)){
                
                $resultado1 = ($ultimoDiafechaFinSer-$diafechaInicioSer)+1;
                $resultadoF =  $item ["numEle"]*$resultado1;

            }if(strtotime($fechaInicioPL)<strtotime($fecha1) && strtotime($fechaFinPL)<=strtotime($fecha2)){
  
                    $fecha2Xplod = explode("-", $fecha2);
                    $ultimoDiaFecha2=$fecha2Xplod[2];

                    if($tipoConsulta=='3'){//mes

                        if($ultimoDiafechaFinSer=='31') {
                            $resultado1= 30;
                        }else{
                            $resultado1= $ultimoDiafechaFinSer;
                        }

                    }if($tipoConsulta=='2'){//15na

                        if($ultimoDiaFecha2<=15) {
                           $resultado1= $ultimoDiafechaFinSer;
                        }else{
                            if($ultimoDiafechaFinSer=='31') {
                               $resultado1= (30-$primerDiafecha1)+1;
                            }else{
                                $resultado1= ($ultimoDiafechaFinSer-$primerDiafecha1)+1;
                            }
                        }
 
                    }if($tipoConsulta=='1'){//semana

                        if($diasElegidos=='4'){
                            if($ultimoDiafechaFinSer!='31'){
                               $resultado1= ($ultimoDiafechaFinSer-$primerDiafecha1)+1;
                            }else{
                               $resultado1= (30-$primerDiafecha1)+1;
                            }
                        }else{
                              $resultado1= ($ultimoDiafechaFinSer-$primerDiafecha1)+1;
                        }
                    }
                    $resultadoF= $item ["numEle"]*$resultado1;
            }//if condicion ffin
        }//if turnos Flat
        else{//cobra 31
            if(strtotime($fechaInicioPL)<=strtotime($fecha1) && strtotime($fechaFinPL)>strtotime($fecha2)){

                if($tipoConsulta=='3'){//mes

                   $resultadoF= $item ["numEle"]*$ultimoDiaMes;

                }if($tipoConsulta=='2'){//15na

                    if($diasElegidos=='1'){
                       $resultadoF= $item ["numEle"]*15;
                    }else{
                       $resultado1= ($ultimoDiaFecha2-$primerDiafecha1)+1;
                       $resultadoF= $item ["numEle"]*$resultado1;
                    }

                }if($tipoConsulta=='1'){//semana

                    if($diasElegidos=='4'){
                       $resultado1 = ($ultimoDiaFecha2-$primerDiafecha1)+1;
                       $resultadoF = $item ["numEle"]*$resultado1;
                    }else{
                       $resultadoF = $item ["numEle"]*7;

                    }
                }
            }if(strtotime($fechaInicioPL)>strtotime($fecha1) && strtotime($fechaFinPL)>strtotime($fecha2)){

                if($diafechaInicioSer==$ultimoDiaMes) {
                   $resultadoF= 1*$item ["numEle"];//poner solo numero de elementos
                }else{

                    if($tipoConsulta=='3'){//mes

                       $resultado1= ($ultimoDiaFecha2-$diafechaInicioSer)+1;

                    }if($tipoConsulta=='2'){//15na

                        if($ultimoDiaFecha2<=15) {
                           $resultado1= ($ultimoDiaFecha2-$diafechaInicioSer)+1;
                        }else{
                            $resultado1= ($ultimoDiaMes-$diafechaInicioSer)+1;
                        }
 
                    }if($tipoConsulta=='1'){//semana
                        if($diasElegidos=='4'){
                           $resultado1= ($ultimoDiaMes-$diafechaInicioSer)+1;
                        }else{
                          $resultado1 = ($ultimoDiaFecha2-$diafechaInicioSer)+1;
                        }
                    }
                    $resultadoF= $item ["numEle"]*$resultado1;
                }

            }if(strtotime($fechaInicioPL)>strtotime($fecha1) && strtotime($fechaFinPL)<strtotime($fecha2)){
                $resultado1=($ultimoDiafechaFinSer-$diafechaInicioSer)+1;
                $resultadoF= $item ["numEle"]*$resultado1;

            }if(strtotime($fechaInicioPL)<strtotime($fecha1) && strtotime($fechaFinPL)<=strtotime($fecha2)){
               if($tipoConsulta=='3'){//mes

                  $resultado1= $ultimoDiafechaFinSer;

               }if($tipoConsulta=='2'){//15na

                   if ($ultimoDiaFecha2<=15) {
                       $resultado1= $ultimoDiafechaFinSer;
                   }else{
                       $resultado1= ($ultimoDiafechaFinSer-$primerDiafecha1)+1;
                   }

               }if($tipoConsulta=='1'){

                      $resultado1= ($ultimoDiafechaFinSer-$primerDiafecha1)+1;

               }
               $resultadoF= $item ["numEle"]*$resultado1;
            }
        }//if cobra 31
        $listaUnificada[$key]["turnosPresupuesto"]+= $resultadoF;
        $listaUnificada[$key]["Puesto"]       = $item ["descripcionPuesto"];
        $listaUnificada[$key]["LineaNegocio"] = $item ["descripcionLineaNegocio"];
        $listaUnificada[$key]["idPuesto"]     = $item ["puestoPlantillaId"];
        $listaUnificada[$key]["Rol"]          = $item ["descripcionTurno"];
        $listaUnificada[$key]["PuntoServicio"]= $item ["puntoservicio"];
        $listaUnificada[$key]["centroCosto"]  = $item ["numeroCentroCosto"];
        $listaUnificada[$key]["rolOperativo"] = $item ["rolOperativoPlantilla"];
        $listaUnificada[$key]["Entidad"]      = $item ["nombreEntidadFederativa"];
        $listaUnificada[$key]["idEstado"]     = $item ["idEntidadPunto"];
        $listaUnificada[$key]["idPunto"]      = $item ["puntoServicioPlantillaId"];

        if($statusPlantilla=='0' && $listaUnificada[$key]["CostoTurno"]==0){
            $listaUnificada[$key]["CostoTurno"] = $item ["costoPorTurno"];
        }else if($statusPlantilla=='0' && $listaUnificada[$key]["CostoTurno"]!=0){
            $listaUnificada[$key]["CostoTurno"] = $listaUnificada[$key]["CostoTurno"];
        }else if ($statusPlantilla=='1') {
            $listaUnificada[$key]["CostoTurno"]=$item ["costoPorTurno"];
        }

        $listaUnificada[$key]["fechaInicio"]  = $fechaInicioSer;
        $listaUnificada[$key]["fechaTermino"] = $fechaFinSer;
        $listaUnificada[$key]["supervisor"]   = $supervisor;
        $listaUnificada[$key]["region"]       = $item ["region"];  
        $listaUnificada[$key]["idPuntoServicio"]= $item ["idPuntoServicio"];
        $listaUnificada[$key]["CobroCobertura"] = $item ["costoNetoFactura"];
        $listaUnificada[$key]["cobraDescansos"] = $item ["cobraDescansos"];
        $listaUnificada[$key]["cobraDiaFestivo"]= $item ["cobraDiaFestivo"];
        $listaUnificada[$key]["TurnosPresupuestados"]= $item ["turnosPorDia"];
        $listaUnificada[$key]["claveClienteNomina"]  = $item ["claveClienteNomina"];
        $listaUnificada[$key]["turnosPresupuestadosPeriodo"] += intval($turnosPorDia);
        $listaUnificada[$key]["asistencia"]= $negocio -> getTurnosCubiertos($fecha1, $fecha2, $item["puntoServicioPlantillaId"],$item["puestoPlantillaId"], $item["rolOperativoPlantilla"]);
        $listaUnificada[$key]["RegistrosUnificados"] = $listaUnificada [$key]["RegistrosUnificados"] + 1;
        $listaUnificada[$key]["fechaInicioPlantilla"]= $item ["fechaInicioPlantilla"];  
        $listaUnificada[$key]["fechaFinPlantilla"]   = $item ["fechaFinPlantilla"];  
        $listaUnificada[$key]["cobroPresupuestado"]  +=$turnosPorDia*$item["costoPorTurno"];

        $listaToGrafica[$i]["rolOperativo2"]        = $item ["descripcionTurno"]; 
        $listaToGrafica[$i]["rolOperativoCompleto2"]= $item ["rolOperativoPlantilla"]; 
        $listaToGrafica[$i]["descripcionPuesto"]    = $item ["descripcionPuesto"]; 
        $listaToGrafica[$i]["noElementos"]          = $item ["numeroElementos"];
        $listaToGrafica[$i]["PuntoServicio"]        = $servicio;  
        $listaToGrafica[$i]["plantilla"]            = $idPlantilla;  
        $listaToGrafica[$i]["statusplantilla"]      = $statusPlantilla;
        $listaToGrafica[$i]["statusps"]             = $statusPs;
        $listaToGrafica[$i]["entidadPS"]            = $entidadPS;  
        $listaToGrafica[$i]["nombrePunto"]          = $item ["puntoservicio"]; 
        $listaToGrafica[$i]["costoPorTurnoPL"]          = $item ["costoPorTurno"]; 
        $listaToGrafica[$i]["fechaInicioPL"]= $fechaInicioPL;  
        $listaToGrafica[$i]["fechaFinPL"]   = $fechaFinPLOriginal;  
        $listaToGrafica[$i][$idPlantilla]["turnosXDia"] = $turnosPorDia;  
        $listaToGrafica[$i][$idPlantilla]["turnoDiaTotales"] = $turnoDeDia;  
        $listaToGrafica[$i][$idPlantilla]["turnosNocheTotales"]  = $turnosDeNoche; 
        $listaToGrafica[$i][$idPlantilla]["turnosCubiertosDia"]  = $turnosCubiertosDia[$idPlantilla];  
        $listaToGrafica[$i][$idPlantilla]["turnosCubiertosNoche"]= $turnosCubiertosNoche[$idPlantilla];

        if($item ["cobra31"]=='0') {
           $listaToGrafica[$i]["cobra31"] ="NO";  
        }else{
            $listaToGrafica[$i]["cobra31"]="SI";
        }

        if($item ["turnosFlat"]=='0') {
           $listaToGrafica[$i]["flat"] ="NO";  
        }else{
            $listaToGrafica[$i]["flat"]="SI";
        }

        $listaToGrafica[$i]["dias"]   = $item["dias"];  
        $listaToGrafica[$i]["numeroElementos"] = $listaUnificada[$key]["numEle"];  //es el acomulado
        $turnosXPlantillaNuevo = $item["dias"]*$item ["numeroElementos"];
        $listaToGrafica[$i]["turnosXPlantillaNuevo"] = $turnosXPlantillaNuevo;  
    }//for i
        $response["lista"] = $listaUnificada;
        $response["listaGrafica"] = $listaToGrafica;
}catch(Exception $e ){
	   $response["status"]="error";
	   $response["error"]="No se pudo obtener Empleados";
       $response ["message"] =  $e -> getMessage ();
}
echo json_encode($response);
?>