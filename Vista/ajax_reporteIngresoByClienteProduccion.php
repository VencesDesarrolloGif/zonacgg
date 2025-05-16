<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio();

// Descomentar al finalizar el desarrollo de este modulo y las pruebas
verificarInicioSesion ($negocio);
// $log              = new KLogger("ajaxReporteDetalle.log", KLogger::DEBUG);
$response = array("status" => "success");

		$fecha1=getValueFromPost("fecha1");
		$fecha2=getValueFromPost("fecha2");
        $idClientePunto=getValueFromPost("idClientePunto");
	//	$LineaNegocioRF=getValueFromPost("selLineaNegocioRporteF");

       // $log->LogInfo("Valor de la variable \$idClientePunto : " . var_export ($idClientePunto, true));  

        $dt1=date($fecha1); 
        $dt1   = new DateTime($dt1);   
        $anio1 = $dt1->format('Y');
        $mes1  = $dt1->format('m');
        $dia1  = $dt1->format('d');

        $dt2=date($fecha2);    
        $dt2   = new DateTime($dt2); 
        $anio2 = $dt2->format('Y');
        $mes2  = $dt2->format('m');

        $fecha    = $anio2 . "-" . $mes2;

        $ban=0;
        $aux      = date('Y-m-d', strtotime("{$fecha} + 1 month"));
        $last_day = date('Y-m-d', strtotime("{$aux} -1  day"));
         

        if($anio1== $anio2 && $mes1==$mes2 && $last_day == $fecha2 && $dia1=='01'){
            $ban=1;
        }

        //$log->LogInfo("Valor de la variable \$dt1 : " . var_export ($dt1, true)); 
        /*
        if ($fecha1 == "") {$fecha1 = "2016-11-01";}
        if ($fecha2 == "") {$fecha2 = "2016-11-30";}
        if ($idClientePunto == "") {$idClientePunto = "28";}
        */
        
	try{
//$idClientePunto=98;

        $lista= $negocio -> getPuntosServiciosByClienteId($fecha1, $fecha2, $idClientePunto);//, $LineaNegocioRF


      
        
        $listaUnificada = array ();

       for ($i = 0; $i < count($lista); $i++)
        {
            $item = $lista [$i];
            //$costoMaximo=$negocio -> negocio_getCostoMaximoPunto($fecha1, $fecha2, $item["servicioPlantillaId"]);
            //$log->LogInfo("Valor de la variable \$costoMaximo : " . var_export ($costoMaximo, true));
            /*if($costoMaximo!=0.0){
                $item ["costoPorTurno"]=$costoMaximo;
            }*/
            $key = $item ["puntoServicioPlantillaId"]."_" .
            //$item ["puestoPlantillaId"] . "_" . 
            $item ["puestoPlantillaId"] ."_".  $item ["rolOperativoPlantilla"] ;
            //$item ["tipoTurnoPlantillaId"];
            //echo $key."<br><br><br>";
            //echo "fecha inicio requisicion".$item["fechaInicio"]."<br><br><br>";
            //echo "fecha termino requisicion".$item["fechaTerminoPlantilla"]."<br><br><br>";
            $servicio=$item ["puntoServicioPlantillaId"];
            $supervisor=$negocio -> negocio_getSupervisorPunto($servicio);
            //$log->LogInfo("Valor de la variable \$item[fechaInicio] : " . var_export (strtotime($item["fechaInicio"]), true));
            //$log->LogInfo("Valor de la variable \$item[fechaTerminoPlantilla] : " . var_export (strtotime($item["fechaTerminoPlantilla"]), true));
            $fechaInicioSer=$item["fechaInicio"];
            $fechaFinSer=$item["fechaTerminoPlantilla"];
           

            if(strtotime($item["fechaInicio"])<strtotime($fecha1)){

               $item["fechaInicio"]=$fecha1;
            }else{

               $item["fechaInicio"]=$item["fechaInicio"];
            }

            if(strtotime($item["fechaTerminoPlantilla"])<strtotime($fecha2)){
                $item["fechaTerminoPlantilla"]=$item["fechaTerminoPlantilla"];
            }else{
                $item["fechaTerminoPlantilla"]=$fecha2;
            }

            $item["dias"]=0;
            //$item["TurnosPresupiestados"]=0;
           
           // $log->LogInfo("Valor de la variable \$item[fechaInicio] : " . var_export ($item["fechaInicio"], true));
        //$log->LogInfo("Valor de la variable \$item[fechaTerminoPlantilla] : " . var_export ($item["fechaTerminoPlantilla"], true));

        

            for ($j = $item["fechaInicio"]; $j <=  $item["fechaTerminoPlantilla"]; $j = date("Y-m-d", strtotime($j ."+ 1 days")))
            {
                $item["dias"]=$item["dias"]+1;
            }

            if($item["estatusPlantilla"]==0 and strtotime($item["fechaTerminoPlantilla"])>strtotime("now"))
            {
                $item["dias"]=0;
            }

            //echo "numero eLEMENTOS".$item["numEle"]."<br><br><br>";
            //echo "fecha empieza calculo periodo".strtotime($item["fechaInicio"])."<br><br><br>";
            //echo "fecha termino calculo periodo".strtotime($item["fechaTerminoPlantilla"])."<br><br><br>";
            //echo "dias".$item["dias"]."<br><br><br>";
            //echo "turnos a cubrir diario".$item["turnosTotalesDiarios"]."<br><br><br>";
            if($item["turnosFlat"]=='1' && $ban==1){
                 $fi= $item["fechaInicio"];
                $fechIni   = new DateTime($fi); 
                $fechFinInp   = new DateTime($fecha2); 
             
                $a= $item["fechaTerminoPlantilla"];
                $dt1   = new DateTime($a); 
                 if(strtotime($item["fechaInicio"])>strtotime($fecha1) && strtotime($item["fechaTerminoPlantilla"])<strtotime($fecha2)){
                        $diast1             = $fechIni->diff($dt1);
                        $dtstr1                       = $diast1->format('%R%a');
                        $dtstring1                    = substr($dtstr1, 1);
                        $diast1             = (int) $dtstring1;
                            //$diastp=($diast+1);
                        $item["dias"]=$diast1 ;

                    }else if(strtotime($item["fechaInicio"])>strtotime($fecha1) && strtotime($item["fechaInicio"])<strtotime($fecha2)){
                        $diast             = $fechIni->diff($fechFinInp);
                        $dtstr                       = $diast->format('%R%a');
                        $dtstring                    = substr($dtstr, 1);
                        $diast             = (int) $dtstring;
                        //$log->LogInfo("Valor de la variable \$diast : " . var_export ($diast, true));         
                        $item["dias"]=$diast ;
                    }else if(strtotime($item["fechaTerminoPlantilla"])>strtotime($fecha1) && strtotime($item["fechaTerminoPlantilla"])<strtotime($fecha2)){
               // $fechaterminoplantillasf=$item["fechaTerminoPlantilla"];
                        $diass  = $dt1->format('d'); 
                        $item["dias"]=$diass ;
                    //$log->LogInfo("Valor de la variable \$dt1 : " . var_export ($dt1, true));
                    //$log->LogInfo("Valor de la variable \$dt2 : " . var_export ($dt2, true));
                    //$log->LogInfo("Valor de la variable \$diass : " . var_export ($diass, true));
                }else{
                //$item["fechaTerminoPlantilla"]=$item["fechaTerminoPlantilla"];
                $item["dias"]='30';}
            }
            //echo "turnos presupuestados PERIODO".intval($item["turnosTotalesDiarios"])*intval($item["dias"])."<br><br><br>";
            //$log->LogInfo("Valor de la variable \$itemdias : " . var_export ($item["dias"], true));

            $item["turnosPresupuestadosPeriodo"]=intval($item["turnosTotalesDiarios"])*intval($item["dias"]);


            
            
            
     
            //$log->LogInfo("Valor de la variable \$turnosPresupuestadosPeriodo : " . var_export ($item["turnosPresupuestadosPeriodo"], true));
            $item["cobroPresupuestado"]=intval($item["turnosPresupuestadosPeriodo"])*$item["costoPorTurno"];
//$log->LogInfo("Valor de la variable \$cobroPresupuestado : " . var_export ($item["cobroPresupuestado"], true));
            //echo "turnos presupuestados PERIODO".$item["turnosPresupuestadosPeriodo"]."<br><br><br>";
            //$listaUnificada [$key][] = $item;
         
        
            if (!isset ($listaUnificada [$key]))
            {
                $listaUnificada [$key] = array ();
   // $log->LogInfo("Valor de la variable \$listaunificada : " . var_export ($listaUnificada , true));
                $listaUnificada [$key]["numEle"] = 0;
                $listaUnificada [$key]["RegistrosUnificados"] = 0;
                $listaUnificada [$key]["turnosPresupuestadosPeriodo"]=0;
                $listaUnificada [$key]["cobroPresupuestado"]=0;
                
            }
            $listaUnificada [$key]["numEle"] += intval ($item ["numEle"]);       
            $listaUnificada [$key]["Puesto"] = $item ["descripcionPuesto"];
            $listaUnificada [$key]["LineaNegocio"] = $item ["descripcionLineaNegocio"];



            $listaUnificada [$key]["idPuesto"] = $item ["puestoPlantillaId"];
            $listaUnificada [$key]["Rol"] = $item ["descripcionTurno"];
            $listaUnificada [$key]["PuntoServicio"] = $item ["puntoservicio"];
            $listaUnificada [$key]["centroCosto"] = $item ["numeroCentroCosto"];
            $listaUnificada [$key]["rolOperativo"] = $item ["rolOperativoPlantilla"];
            $listaUnificada [$key]["Entidad"] = $item ["nombreEntidadFederativa"];
            $listaUnificada [$key]["idEstado"] = $item ["idEntidadPunto"];
            $listaUnificada [$key]["idPunto"] = $item ["puntoServicioPlantillaId"];
            $listaUnificada [$key]["idPuntoServicio"] = $item ["idPuntoServicio"];
            $listaUnificada [$key]["CostoTurno"] = $item ["costoPorTurno"];
            $listaUnificada [$key]["TurnosPresupuestados"] = $item ["turnosPorDia"];
            $listaUnificada [$key]["TurnosCubiertos"] = $item ["turnosTotalesDiarios"];
            $listaUnificada [$key]["CobroCobertura"] = $item ["costoNetoFactura"];
            $listaUnificada [$key]["claveClienteNomina"] = $item ["claveClienteNomina"];
            $listaUnificada [$key]["turnosPresupuestadosPeriodo"] += intval($item["turnosPresupuestadosPeriodo"]);
            $listaUnificada [$key]["cobroPresupuestado"] += $item["cobroPresupuestado"];
            $listaUnificada [$key]["fechaInicio"] = $fechaInicioSer;
            $listaUnificada [$key]["fechaTermino"] = $fechaFinSer;
            $listaUnificada [$key]["cobraDescansos"] = $item ["cobraDescansos"];
            $listaUnificada [$key]["cobraDiaFestivo"] = $item ["cobraDiaFestivo"];
            $listaUnificada [$key]["cobra31"] = $item ["cobra31"];            
            $listaUnificada [$key]["supervisor"] = $supervisor;
             $listaUnificada [$key]["region"] = $item ["region"];  

  
 //$log->LogInfo("Valor de la variable \$listaUnificada : " . var_export ($listaUnificada [$key]["TurnosCubiertos"], true));
            


            $listaUnificada [$key]["asistencia"] = $negocio -> getTurnosCubiertosByPerfil($fecha1, $fecha2, $item ["puntoServicioPlantillaId"],$item ["puestoPlantillaId"], $item ["rolOperativoPlantilla"]);
            
            $listaUnificada [$key]["RegistrosUnificados"] = $listaUnificada [$key]["RegistrosUnificados"] + 1;
            //$listaUnificada [$key][""] = $item [""];
            //$log->LogInfo("Valor de la variable turnos : " . var_export ($listaUnificada [$key]["numEle"], true));
            //$empleadoEntidadId = $listaEmpleados [$i]["entidadFederativaId"];
            //$empleadoConsecutivoId = $listaEmpleados [$i]["empleadoConsecutivoId"];
            //$empleadoTipoId = $listaEmpleados [$i]["empleadoCategoriaId"];
                //$log->LogInfo("Valor de la variable turnos : " . var_export ($listaUnificada [$key]["turnosPresupuestadosPeriodo"], true));
           // $listaEmpleados [$i]["asistencia"] = $negocio -> getAsistenciaByEmpleadoPeriodo ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId);
            //$listaEmpleados [$i]["turnosExtras"] = $negocio -> getSumaTurnosExtras ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId);
            //$listaEmpleados [$i]["descuentos"] = $negocio -> getSumDescuentos ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId);
            //$listaEmpleados [$i]["incidenciasEspeciales"] = $negocio -> getSumaIncidenciasEspeciales ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId);
            //$listaEmpleados [$i]["diasFestivos"] = $negocio -> getSumaDiasFestivos ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId);
            //echo json_encode($listaUnificada)."<br><br><br>";

           //echo "lista unificada".$listaUnificada."<br><br><br>";

            //echo json_encode($listaUnificada) ."<br><br><br>";  

          
        }

        // echo json_encode($listaUnificada) ."<br><br><br>";  
        //$response["lista"]= $lista;
        $response["lista"]= $listaUnificada;


        $log->LogInfo("Valor de la variable response : " . var_export ($response, true));

        

        

	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se pudo obtener Empleados";
    $response ["message"] =  $e -> getMessage ();
	}
/*
}
*/

echo json_encode($response);

?>