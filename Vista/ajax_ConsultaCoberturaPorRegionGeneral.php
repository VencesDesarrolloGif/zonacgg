<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajax_ConsultaCoberturaPorRegionGeneral.log" , KLogger::DEBUG );
$response = array("status" => "success");

try{
    $region = getValueFromPost("region");
    $entidadregion = getValueFromPost("entidadregion");
    $casoConsulta = getValueFromPost("casoConsulta");
    $casoFechas = getValueFromPost("casoFechas");
    $LineaNegocioRegiones=getValueFromPost ("lineaNegocioregion");
    $periodoRegiones = getValueFromPost("periodoRegiones");
    $anio = getValueFromPost("ejercicioRegiones");
    //$fechaFinal = getValueFromPost("fechaFinalRegiones");



    if($casoFechas=="1"){
        if($periodoRegiones=="1"){
            $fechaInicial = date($anio."-01-01");
            $fechaFinal = date($anio."-01-t");
        }else if($periodoRegiones=="2"){
            $fechaInicial = date($anio."-02-01");
            $fechaFinal = date($anio."-02-t");
        }else if($periodoRegiones=="3"){
            $fechaInicial = date($anio."-03-01");
            $fechaFinal = date($anio."-03-t");
        }else if($periodoRegiones=="4"){
            $fechaInicial = date($anio."-04-01");
            $fechaFinal = date($anio."-04-t");
        }else if($periodoRegiones=="5"){
            $fechaInicial = date($anio."-05-01");
            $fechaFinal = date($anio."-05-t");
        }else if($periodoRegiones=="6"){
            $fechaInicial = date($anio."-06-01");
            $fechaFinal = date($anio."-06-t");
        }else if($periodoRegiones=="7"){
            $fechaInicial = date($anio."-07-01");
            $fechaFinal = date($anio."-07-t");
        }else if($periodoRegiones=="8"){
            $fechaInicial = date($anio."-08-01");
            $fechaFinal = date($anio."-08-t");
        }else if($periodoRegiones=="9"){
            $fechaInicial = date($anio."-09-01");
            $fechaFinal = date($anio."-09-t");
        }else if($periodoRegiones=="10"){
            $fechaInicial = date($anio."-10-01");
            $fechaFinal = date($anio."-10-t");
        }else if($periodoRegiones=="11"){
            $fechaInicial = date($anio."-11-01");
            $fechaFinal = date($anio."-11-t");
        }else if($periodoRegiones=="12"){
            $fechaInicial = date($anio."-12-01");
            $fechaFinal = date($anio."-12-t");
        }
    }else{
        $fechaInicial = "";
        $fechaFinal = "";
    }

    //$log->LogInfo("Valor de la variable fechaInicial: " . var_export ($fechaInicial, true));
    //$log->LogInfo("Valor de la variable fechaFinal: " . var_export ($fechaFinal, true));


    $turnosPorDia = 0;
    $turnoDeDia = 0;
    $turnosDeNoche = 0;
    $datos = array ();
    $rolOperativo12x7 = "12x12x7";
    $rolOperativo12x6 = "12x12x6";
    $rolOperativo12x5 = "12x12x5";
    $rolOperativo12x3 = "12x12x3";
    $rolOperativo24x7 = "12x24x7";
    $rolOperativo24x24 = "24x24x7";
    $rolOperativoNA = "NO DEFINIDO";
    $rolOperativoOF = "HORARIO OFICINA";
    $TotalPuntosT = 0;
    $TotalElementosVentas = 0;
    $TotalElementosT = 0;
    $TotalElementosTGif = 0;
    $TotalElementosTA = 0;
    $ElementosPorRolOp12x7T = 0;
    $ElementosPorRolOp12x6T = 0;
    $ElementosPorRolOp12x5T = 0;
    $ElementosPorRolOp12x3T = 0;
    $ElementosPorRolOp24x7T = 0;
    $ElementosPorRolOp24x24T = 0;
    $ElementosPorRolOpNAT = 0;
    $ElementosPorRolOpOFT = 0;
    $RolSupT = 0;
    $RolRecT = 0;
    $RolLidT = 0;
    $turnosPorDiaT = 0;
    $turnoDeDiaT = 0;
    $turnosDeNocheT=0;
    $estimadoCubreT=0;
    $TotalVehiculosT=0;
    $tipoOperativo = "03";
    $tipoAdmin = "02";
/////////////////////////////////////////////////////// Caso De Busqueda Unicamente Por Linea de Negocio  Retorna El Calculo General /////////////////////////////////////////////////////////////////////// 
    if($casoConsulta=="1"){
        $listaRegionesTotales = $negocio -> consultaRegiones();
        // $largoFor=7;
        $largoFor=count($listaRegionesTotales);
        $inicioI=0;
    }else if($casoConsulta=="2"){
         $listaRegiones = $negocio -> ObtenerRegionesTotales($LineaNegocioRegiones,$region,$casoConsulta,$entidadregion);
         $largoFor = count($listaRegiones);
         $inicioI=0;
    }else if($casoConsulta=="3"){
         $listaRegiones = $negocio -> ObtenerRegionesTotales($LineaNegocioRegiones,$region,$casoConsulta,$entidadregion);
         $largoFor = 1;
         $inicioI=0;
    }
    for ($i=$inicioI; $i <$largoFor ; $i++) { 
        if($casoConsulta=="1"){
            $regionAConsultar=$listaRegionesTotales[$i]["idRegionI"];
            $listaRegiones = $negocio -> ObtenerRegionesTotales($LineaNegocioRegiones,$regionAConsultar,$casoConsulta,$entidadregion);
            $temp =$i-1; 
            $datos[$temp]["EntidadesRegion"] = "TODAS";//entodades  
        }else if($casoConsulta=="2"){
            $entidadregion = $listaRegiones[$i]["idEntidadI"];
            $temp =$i;
            $datos[$temp]["EntidadesRegion"] = $listaRegiones[$i]["nombreEntidadFederativa"];//entodades  
        }else if($casoConsulta=="3"){
            $temp =$i;
            $datos[$temp]["EntidadesRegion"] = $listaRegiones[$i]["nombreEntidadFederativa"];//entodades  
        }
        $totalEntidadesPorRegion = count($listaRegiones);
        $datos[$temp]["region"] = $listaRegiones[0]["DescripcionI"];//lista de las regiones totales

        $casoGifOp = "0";
        $casoGif = "1";




        $TotalElementosVentas1 = $negocio -> ObtenerNumeroElementosVentas($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$entidadregion,$casoConsulta,$casoFechas);
        $datos[$temp]["RequisicionVentas"] = $TotalElementosVentas1[0]["elementosVentas"];//TotlaDe Los Elementos Por region operativa sin gif cliente 13
        $TotalElementosVentas = $TotalElementosVentas + $TotalElementosVentas1[0]["elementosVentas"];


        $TotalElementos = $negocio -> ObtenerElementosPorRegion($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$entidadregion,$casoConsulta,$casoFechas,$tipoOperativo,$casoGifOp);
        $datos[$temp]["TotalElementosOp"] = $TotalElementos[0]["TotalElementos"];//TotlaDe Los Elementos Por region operativa sin gif cliente 13
        $TotalElementosT = $TotalElementosT + $TotalElementos[0]["TotalElementos"];

        $TotalElementosGif = $negocio -> ObtenerElementosPorRegion($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$entidadregion,$casoConsulta,$casoFechas,$tipoOperativo,$casoGif);
        $datos[$temp]["TotalElementosOpGif"] = $TotalElementosGif[0]["TotalElementos"];//TotlaDe Los Elementos Por region operativa sin gif cliente 13
        $TotalElementosTGif = $TotalElementosTGif + $TotalElementosGif[0]["TotalElementos"];

        $TotalElementosA = $negocio -> ObtenerElementosPorRegion($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$entidadregion,$casoConsulta,$casoFechas,$tipoAdmin,$casoGifOp);
        $datos[$temp]["TotalElementosTA"] = $TotalElementosA[0]["TotalElementos"];//TotlaDe Los Elementos Por region administrativa
        $TotalElementosTA = $TotalElementosTA + $TotalElementosA[0]["TotalElementos"];


        $TotalPuntos = $negocio -> ObtenerPuntosPorRegion($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$entidadregion,$casoConsulta,$casoFechas);
        //$log->LogInfo("Valor de la variable ElementosYPuntos: " . var_export ($ElementosYPuntos, true));
        $datos[$temp]["TotalPuntos"] = $TotalPuntos[0]["TotalPuntos"];//Total De los Puntos de servicio Cubiertos por region
        $TotalPuntosT = $TotalPuntosT+ $TotalPuntos[0]["TotalPuntos"];//Total De los Puntos de servicio Cubiertos por region

        $ElementosPorRolOp12x7 = $negocio -> ObtenerElementosPorRolOperativo($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$rolOperativo12x7,$entidadregion,$casoConsulta,$casoFechas);
        $datos[$temp]["Rol12x7"] = $ElementosPorRolOp12x7[0]["RolOperativo"];//Total De Elementos Por Rol Operativo 12x12x7
        $ElementosPorRolOp12x7T = $ElementosPorRolOp12x7T + $ElementosPorRolOp12x7[0]["RolOperativo"];
        $datos[$temp]["estimadoCubre"] = round(($ElementosPorRolOp12x7[0]["RolOperativo"])/7);//TotlaDe Los Elementos emntre 7 que es referencia al rol operativo 12x12x7
        $estimadoCubreT = round(($estimadoCubreT + (($ElementosPorRolOp12x7[0]["RolOperativo"])/7)));
        
        $ElementosPorRolOp12x6 = $negocio -> ObtenerElementosPorRolOperativo($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$rolOperativo12x6,$entidadregion,$casoConsulta,$casoFechas);
        $datos[$temp]["Rol12x6"] = $ElementosPorRolOp12x6[0]["RolOperativo"];//Total De Elementos Por Rol Operativo 12x12x6
        $ElementosPorRolOp12x6T = $ElementosPorRolOp12x6T + $ElementosPorRolOp12x6[0]["RolOperativo"];
        $ElementosPorRolOp12x5 = $negocio -> ObtenerElementosPorRolOperativo($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$rolOperativo12x5,$entidadregion,$casoConsulta,$casoFechas);
        $datos[$temp]["Rol12x5"] = $ElementosPorRolOp12x5[0]["RolOperativo"];//Total De Elementos Por Rol Operativo 12x12x5
        $ElementosPorRolOp12x5T = $ElementosPorRolOp12x5T + $ElementosPorRolOp12x5[0]["RolOperativo"];
        $ElementosPorRolOp12x3 = $negocio -> ObtenerElementosPorRolOperativo($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$rolOperativo12x3,$entidadregion,$casoConsulta,$casoFechas);
        $datos[$temp]["Rol12x3"] = $ElementosPorRolOp12x3[0]["RolOperativo"];//Total De Elementos Por Rol Operativo 12x12x3
        $ElementosPorRolOp12x3T = $ElementosPorRolOp12x3T + $ElementosPorRolOp12x3[0]["RolOperativo"];
        $ElementosPorRolOp24x7 = $negocio -> ObtenerElementosPorRolOperativo($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$rolOperativo24x7,$entidadregion,$casoConsulta,$casoFechas);
        $datos[$temp]["Rol24x7"] = $ElementosPorRolOp24x7[0]["RolOperativo"];//Total De Elementos Por Rol Operativo 12x24x7
        $ElementosPorRolOp24x7T = $ElementosPorRolOp24x7T + $ElementosPorRolOp24x7[0]["RolOperativo"];
        $ElementosPorRolOp24x24 = $negocio -> ObtenerElementosPorRolOperativo($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$rolOperativo24x24,$entidadregion,$casoConsulta,$casoFechas);
        $datos[$temp]["Rol24x24"] = $ElementosPorRolOp24x24[0]["RolOperativo"];//Total De Elementos Por Rol Operativo 24x24x7
        $ElementosPorRolOp24x24T = $ElementosPorRolOp24x24T + $ElementosPorRolOp24x24[0]["RolOperativo"];
        $ElementosPorRolOpNA = $negocio -> ObtenerElementosPorRolOperativo($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$rolOperativoNA,$entidadregion,$casoConsulta,$casoFechas);
        $datos[$temp]["RolNA"] = $ElementosPorRolOpNA[0]["RolOperativo"];//Total De Elementos Por Rol Operativo No Definido
        $ElementosPorRolOpNAT = $ElementosPorRolOpNAT +  $ElementosPorRolOpNA[0]["RolOperativo"];
        $ElementosPorRolOpOF = $negocio -> ObtenerElementosPorRolOperativo($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$rolOperativoOF,$entidadregion,$casoConsulta,$casoFechas);
        $datos[$temp]["RolOF"] = $ElementosPorRolOpOF[0]["RolOperativo"];//Total De Elementos Por Rol Operativo Horario Oficina
        $ElementosPorRolOpOFT = $ElementosPorRolOpOFT + $ElementosPorRolOpOF[0]["RolOperativo"];

        if($LineaNegocioRegiones=="1"){
            $Supervisor="6";$Reclutador="46";$Lider="65";
            $ElementosPorRolOp12x7 = $negocio -> ObtenerElementosPorRolOperativo($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$Supervisor,$entidadregion,$casoConsulta,$casoFechas);
            $aa = $ElementosPorRolOp12x7[0]["RolOperativo"];//Total De Elementos Por Rol Operativo Supervsor
            $datos[$temp]["RolSup"] = $aa; 
            $ElementosPorRolOp12x7 = $negocio -> ObtenerElementosPorRolOperativo($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$Reclutador,$entidadregion,$casoConsulta,$casoFechas);
            $bb =  $ElementosPorRolOp12x7[0]["RolOperativo"];//Total De Elementos Por Rol Operativo Reclutador;
            $datos[$temp]["RolRec"] = $bb;
            $ElementosPorRolOp12x7 = $negocio -> ObtenerElementosPorRolOperativo($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$Lider,$entidadregion,$casoConsulta,$casoFechas);
            $cc = $ElementosPorRolOp12x7[0]["RolOperativo"];//Total De Elementos Por Rol Operativo Lider Unidad;
            $datos[$temp]["RolLid"] = $cc;
        }else if($LineaNegocioRegiones=="2"){
            $Supervisor="61";
            $ElementosPorRolOp12x7 = $negocio -> ObtenerElementosPorRolOperativo($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$Supervisor,$entidadregion,$casoConsulta,$casoFechas);
            $aa =$ElementosPorRolOp12x7[0]["RolOperativo"];//Total De Elementos Por Rol Operativo Supervisor
            $bb ="0";//Total De Elementos Por Rol Operativo Reclutador
            $cc ="0";//Total De Elementos Por Rol Operativo Lider de unidad
            $datos[$temp]["RolSup"] = $aa;
            $datos[$temp]["RolRec"] = $bb;
            $datos[$temp]["RolLid"] = $cc;
        }
        else if($LineaNegocioRegiones=="3"){
            $Supervisor="88";
            $ElementosPorRolOp12x7 = $negocio -> ObtenerElementosPorRolOperativo($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$Supervisor,$entidadregion,$casoConsulta,$casoFechas);
            $aa = $ElementosPorRolOp12x7[0]["RolOperativo"];//Total De Elementos Por Rol Operativo Supervidor
            $bb = "0";//Total De Elementos Por Rol Operativo Reclutador
            $cc = "0";//Total De Elementos Por Rol Operativo Lider unidad
            $datos[$temp]["RolSup"] = $aa;
            $datos[$temp]["RolRec"] = $bb;
            $datos[$temp]["RolLid"] = $cc;
        }else{
            $aa = "0";//Total De Elementos Por Rol Operativo Supervisor
            $bb = "0";//Total De Elementos Por Rol Operativo Reclutador
            $cc = "0";//Total De Elementos Por Rol Operativo Lider unidad
            $datos[$temp]["RolSup"] = $aa; 
            $datos[$temp]["RolRec"] = $bb; 
            $datos[$temp]["RolLid"] = $cc; 
        }
        $RolSupT = $RolSupT + $aa;
        $RolRecT = $RolRecT + $bb;
        $RolLidT =   $RolLidT + $cc;


        $PuntosServicio = $negocio -> ObtenerIdPuntosPorRegion($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$entidadregion,$casoConsulta,$casoFechas);
        //$log->LogInfo("Valor de la variable PuntosServicio: " . var_export ($PuntosServicio, true));
        $largoPuntosServicio = count($PuntosServicio);
        $turnosPorDia=0;
        $turnoDeDia=0;
        $turnosDeNoche=0;
        for ($j=0; $j < $largoPuntosServicio; $j++) {
            $puntoServicioId = $PuntosServicio[$j]["idPuntoServicio"];
            $DatosPlantillasPorPunto = $negocio -> GetDatosPlantillasPorPunto($puntoServicioId);
            
            $LargoDatosplantilla = count($DatosPlantillasPorPunto);
            $dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
            $dia = $dias[(date('N', strtotime($i))) - 1];
            $turnoDiaC = $dia."TurnoDia";
            $turnoNocheC = $dia."TurnoNoche";
            for($k=0; $k<$LargoDatosplantilla;$k++){
                $PlantillaId = $DatosPlantillasPorPunto[$k]["servicioPlantillaId"];
                $DiasSolicitud= $negocio -> getDiasSolicitados($PlantillaId,$turnoDiaC,$turnoNocheC);
                $contadorArray = count($DiasSolicitud);
                if($contadorArray==0){
                    $TurnoDiaSolicitado = 0;
                    $TurnoNocheSolicitado = 0;
                }else{
                    $TurnoDiaSolicitado = $DiasSolicitud[0][$turnoDiaC];
                    $TurnoNocheSolicitado = $DiasSolicitud[0][$turnoNocheC];
                }
                $turnosPorDia = $turnosPorDia + $TurnoDiaSolicitado + $TurnoNocheSolicitado; //general
                $turnoDeDia = $turnoDeDia + $TurnoDiaSolicitado; //dia
                $turnosDeNoche = $turnosDeNoche +  $TurnoNocheSolicitado;//noche
            }    
        }
        if($LineaNegocioRegiones=="1"){
            $datos [$temp]["turnosPorDia"] = $turnosPorDia;
            $datos [$temp]["turnoDeDia"] = $turnoDeDia;
            $datos [$temp]["turnosDeNoche"] = $turnosDeNoche;
        }else{
            $turnosPorDia = 0;
            $turnoDeDia = 0;
            $turnosDeNoche = 0;
            $datos [$temp]["turnosPorDia"] = $turnosPorDia;
            $datos [$temp]["turnoDeDia"] = $turnoDeDia;
            $datos [$temp]["turnosDeNoche"] = $turnosDeNoche; 
        }
        $turnosPorDiaT = $turnosPorDiaT + $turnosPorDia; 
        $turnoDeDiaT = $turnoDeDiaT + $turnoDeDia; 
        $turnosDeNocheT = $turnosDeNocheT + $turnosDeNoche; 
        $TotalDeVehiculos = $negocio -> ObtenervehiculosRegiones($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$entidadregion,$casoConsulta,$casoFechas);
        //$log->LogInfo("Valor de la variable ElementosYPuntos: " . var_export ($ElementosYPuntos, true));
        $datos[$temp]["TotalVehiculos"] = $TotalDeVehiculos[0]["TotalVehiculos"];//Total De los Puntos de servicio Cubiertos por region
        $TotalVehiculosT = $TotalVehiculosT+ $TotalDeVehiculos[0]["TotalVehiculos"];//Total De los Puntos de servicio Cubiertos por region
    }// cierra el for
    $largoForT = $largoFor-$inicioI;
    $datos[$largoForT]["EntidadesRegion"] = "TOTALES";//entodades  
    $datos[$largoForT]["region"] = "SUMATORIAS";//lista de las regiones totales
    $datos[$largoForT]["TotalPuntos"] = $TotalPuntosT;//Total De los Puntos de servicio Cubiertos por region
    $datos[$largoForT]["TotalElementosOp"] = $TotalElementosT;//TotlaDe Los Elementos Por region
    $datos[$largoForT]["Rol12x7"] =$ElementosPorRolOp12x7T;
    $datos[$largoForT]["Rol12x6"] =$ElementosPorRolOp12x6T;
    $datos[$largoForT]["Rol12x5"] =$ElementosPorRolOp12x5T;
    $datos[$largoForT]["Rol12x3"] =$ElementosPorRolOp12x3T;
    $datos[$largoForT]["Rol24x7"] =$ElementosPorRolOp24x7T;
    $datos[$largoForT]["Rol24x24"] =$ElementosPorRolOp24x24T;
    $datos[$largoForT]["RolNA"] =$ElementosPorRolOpNAT;
    $datos[$largoForT]["RolOF"] =$ElementosPorRolOpOFT;
    $datos[$largoForT]["RolSup"] =$RolSupT;
    $datos[$largoForT]["RolRec"] =$RolRecT;
    $datos[$largoForT]["RolLid"] =$RolLidT;
    $datos[$largoForT]["turnosPorDia"] = $turnosPorDiaT;//COBERTURA CONTEO GENERAL
    $datos[$largoForT]["turnoDeDia"] = $turnoDeDiaT;
    $datos[$largoForT]["turnosDeNoche"] = $turnosDeNocheT;
    $datos[$largoForT]["estimadoCubre"] = $estimadoCubreT;
    $datos[$largoForT]["TotalVehiculos"] = $TotalVehiculosT;
    $datos[$largoForT]["TotalElementosTA"] = $TotalElementosTA;
    $datos[$largoForT]["TotalElementosOpGif"] = $TotalElementosTGif;
    $datos[$largoForT]["RequisicionVentas"] = $TotalElementosVentas;

//$log->LogInfo("Valor de la variable datos222222: " . var_export ($datos, true));
    $response ["datos"] = $datos;
} 
catch( Exception $e )
{
    $response["status"]="error";
    $response["error"]="No se puedo obtener consulta";
}
echo json_encode($response);

