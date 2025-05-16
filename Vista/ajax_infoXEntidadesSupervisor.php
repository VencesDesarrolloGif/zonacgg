<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
$log = new KLogger ( "ajax_infoXEntidadesSupervisoraaa.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable listaPSxSupCompleta: " . var_export ($listaPSxSupCompleta, true));

try{
    $rolesOp      = $negocio->obtenerRolesOperativosExistentes();
    $datos        = array ();
    $datosPS      = array ();
    $noSupervisor = $_POST['noSupervisor'];
    $lineaNegocio = $_POST['LineaNegocioElegida'];
    $mes          = $_POST['mes'];
    $anio         = $_POST['anio'];
    $turnosMerma0 = 0;
    $turnoDeDia   =0;
    $turnosDeNoche=0;
    $diasSemana   =7;

    if($mes=="1"){
        $fechaInicio = date($anio."-01-01");
        $fechaFin    = date($anio."-01-31");
    }else if($mes=="2"){
        $fechaInicio = date($anio."-02-01");
        $fechaFin    = date($anio."-02-28");
    }else if($mes=="3"){
        $fechaInicio = date($anio."-03-01");
        $fechaFin    = date($anio."-03-31");
    }else if($mes=="4"){
        $fechaInicio = date($anio."-04-01");
        $fechaFin    = date($anio."-04-30");
    }else if($mes=="5"){
        $fechaInicio = date($anio."-05-01");
        $fechaFin    = date($anio."-05-31");
    }else if($mes=="6"){
        $fechaInicio = date($anio."-06-01");
        $fechaFin    = date($anio."-06-30");
    }else if($mes=="7"){
        $fechaInicio = date($anio."-07-01");
        $fechaFin    = date($anio."-07-31");
    }else if($mes=="8"){
        $fechaInicio = date($anio."-08-01");
        $fechaFin    = date($anio."-08-31");
    }else if($mes=="9"){
        $fechaInicio = date($anio."-09-01");
        $fechaFin    = date($anio."-09-30");
    }else if($mes=="10"){
        $fechaInicio = date($anio."-10-01");
        $fechaFin    = date($anio."-10-31");
    }else if($mes=="11"){
        $fechaInicio = date($anio."-11-01");
        $fechaFin    = date($anio."-11-30");
    }else if($mes=="12"){
        $fechaInicio = date($anio."-12-01");
        $fechaFin    = date($anio."-12-31");
    }
    /////////////////////////////////////////////////////// OBTENER ENTIDADES////////////////////////////////////////////////////////////////////// 
    $listaEntidades     = $negocio -> ObtenerINFOEntidadesSup($noSupervisor,$fechaInicio,$fechaFin);//obtiene entidades y elementos ventas *
    $listaPSxSupCompleta= $negocio -> ObtenerPSxSupCompleta($lineaNegocio,$fechaInicio,$fechaFin,$listaEntidades,$noSupervisor);//Puntos de servicio para obtener los empleados sin cl 13
    //FOR PARA LA TABLA DE LOS PUNTOS DE SERVICIO 
    for ($i=0; $i < count($listaPSxSupCompleta); $i++) { 
        $datosPS[$i]["idPS"] = $listaPSxSupCompleta[$i]["idPuntoServicio"];
        $datosPS[$i]["nombrePS"]= $listaPSxSupCompleta[$i]["puntoServicio"];

        $puntoS= $listaPSxSupCompleta[$i]["idPuntoServicio"];
        $infoPSxSupCompleta= $negocio -> infoPSxSup($puntoS);
        $datosPS[$i]["longitud"]= $infoPSxSupCompleta[0]["longitudPunto"];
        $datosPS[$i]["latitud"] = $infoPSxSupCompleta[0]["latitudPunto"];

        for($r=0; $r < count($rolesOp); $r++) { 
            $idrolOp=$rolesOp[$r]["idRolOperativo"];
            $DescripcionRolOp=$rolesOp[$r]["DescripcioRolOP"];

            $ElementosPorRolOpXPS = $negocio -> ElementosPorRolOperativoPs($puntoS,$lineaNegocio,$DescripcionRolOp,$fechaInicio,$fechaFin);

            if(count($ElementosPorRolOpXPS)=='' || count($ElementosPorRolOpXPS)=='NULL' || count($ElementosPorRolOpXPS)=='null'){
               $datosPS[$i][$DescripcionRolOp]='0';
            }else{
                  $datosPS[$i][$DescripcionRolOp]= $ElementosPorRolOpXPS[0]["RolOperativo"];
                 }
                // $rolesOperativos[$r]=$rolesOp[$r]["DescripcioRolOP"];
        }//FOR "R"

        $ElementosVentasXPs = $negocio -> ObtenerElementosVentasXPS($puntoS,$fechaInicio,$fechaFin);//elementos ventas

        if($ElementosVentasXPs[0]["elementosVentasXpS"]=='' || $ElementosVentasXPs[0]["elementosVentasXpS"]=='NULL' || $ElementosVentasXPs[0]["elementosVentasXpS"]==null || $ElementosVentasXPs[0]["elementosVentasXpS"]=='null' || $ElementosVentasXPs[0]["elementosVentasXpS"]==NULL){
            $datosPS[$i]["elementosVentasXpS"]= '0';
        }else{
            $datosPS[$i]["elementosVentasXpS"]= $ElementosVentasXPs[0]["elementosVentasXpS"];
        }

        $NoElementosFOxPS = $negocio -> ObtenerFuerzaOperativaPS($puntoS,$lineaNegocio,$fechaInicio,$fechaFin);//FUERZA OPERATIVA
        $datosPS[$i]["TotalElementosFuerzaOperativaXPS"]= $NoElementosFOxPS[0]["TotalElementosFuerzaOperativaXPS"];

        $cobertura = $negocio -> coberturaXPS($puntoS,$fechaInicio,$fechaFin);//FUERZA OPERATIVA
        $datosPS[$i]["turnosCubiertosXPS"]= $cobertura["totalTurnosCubiertos"];
        //$log->LogInfo("Valor de la variable cobertura: " . var_export ($cobertura, true));

        $PlantillasPorPunto= $negocio -> plantillasXPunto($puntoS,$fechaInicio,$fechaFin);
        $turnosPorDia=0;
        $turnosPorDiaTMP=0;
          for($k=0; $k<count($PlantillasPorPunto);$k++){
            for ($d =$fechaInicio; $d <=$fechaFin; $d = date("Y-m-d", strtotime($d ."+ 1 days"))){
                $dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
                $dia = $dias[(date('N', strtotime($d))) - 1];
                $turnoDiaC  = $dia."TurnoDia";
                $turnoNocheC= $dia."TurnoNoche";
                $PlantillaId  = $PlantillasPorPunto[$k]["servicioPlantillaId"];
                $DiasSolicitud= $negocio -> diasSolicitadosXSup($PlantillaId,$turnoDiaC,$turnoNocheC);//revisar si por fechas
                if(count($DiasSolicitud)==0){
                   $TurnoDiaSolicitado = 0;
                   $TurnoNocheSolicitado = 0;
                  }else{
                        $TurnoDiaSolicitado = $DiasSolicitud[0][$turnoDiaC];
                        $TurnoNocheSolicitado=$DiasSolicitud[0][$turnoNocheC];
                       }
                $turnosPorDia = $turnosPorDia + $TurnoDiaSolicitado + $TurnoNocheSolicitado;
            }//SEMANA   
            $turnosPorDiaTMP = $turnosPorDia+ $turnosPorDiaTMP;
            $turnosPorDia = 0;
          }//PLANTILL
            $datosPS[$i]["turnosPorDia"]= $turnosPorDiaTMP;//hacer sumatoria de turnos totales

    }//ps
    for ($i=0; $i < count($listaEntidades); $i++) { //for tabla principal
        $entidad=$listaEntidades[$i]["idEntidadFederativa"];
        $NoElementosFO    = $negocio -> ObtenerFuerzaOperativa($entidad,$noSupervisor,$lineaNegocio,$fechaInicio,$fechaFin);//FUERZA OPERATIVA
        $NoElementosCubre = $negocio -> ObtenerFuerzaCubre($entidad,$noSupervisor,$lineaNegocio,$fechaInicio,$fechaFin);//FUERZA CUBRE
        $NoElementosMerma = $negocio -> ObtenerTurnosMerma($entidad,$lineaNegocio,$fechaInicio,$fechaFin,$noSupervisor);//TURNOS MERMA

        $datos[$i]["turnosMerma"]    = $NoElementosMerma[0]["turnosMerma"];
        $datos[$i]["entidad"]        = $listaEntidades[$i]["nombreEntidadFederativa"];
        $datos[$i]["elementosVentas"]= $listaEntidades[$i]["elementosVentas"];
        $datos[$i]["fuerzaOperativa"]= $NoElementosFO[0]["TotalElementosFuerzaOperativa"];
        $datos[$i]["fuerzaCubre"]    = $NoElementosCubre[0]["TotalElementosFuerzaCubre"];//****

        for($p=0; $p < count($rolesOp); $p++) { 
            $idrolOp=$rolesOp[$p]["idRolOperativo"];
            $DescripcionRolOp=$rolesOp[$p]["DescripcioRolOP"];
        
            $ElementosPorRolOp = $negocio -> ElementosPorRolOperativo($entidad,$lineaNegocio,$DescripcionRolOp,$fechaInicio,$fechaFin,$noSupervisor);

            if(count($ElementosPorRolOp)=='' || count($ElementosPorRolOp)=='NULL' || count($ElementosPorRolOp)=='null'){
               $datos[$i][$DescripcionRolOp]='0';
            }else{
                  $datos[$i][$DescripcionRolOp]= $ElementosPorRolOp[0]["RolOperativo"];
                 }

            if ($DescripcionRolOp=='12X12X7') {
                $datos[$i]["estimacionCubreTurnos"] = round(($ElementosPorRolOp[0]["RolOperativo"])/7);//TotlaDe Los Elementos emntre 7 que es referencia al rol operativo 12x12x7
            }

        }//FOR "p"

        $listaPSxSup = $negocio -> ObtenerPSxSup($lineaNegocio,$fechaInicio,$fechaFin,$entidad,$noSupervisor);//Puntos de servicio para obtener los empleados
               
        for($j=0; $j < count($listaPSxSup); $j++) {

          $puntoServicioId   = $listaPSxSup[$j]["idPuntoServicio"];
          $PlantillasPorPunto= $negocio -> plantillasXPunto($puntoServicioId,$fechaInicio,$fechaFin);

            for($k=0; $k<count($PlantillasPorPunto);$k++){
                for ($d=0; $d < $diasSemana; $d++) { 
                    $dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
                    $dia = $dias[$d];
                    $turnoDiaC  = $dia."TurnoDia";
                    $turnoNocheC= $dia."TurnoNoche";
                    $PlantillaId  = $PlantillasPorPunto[$k]["servicioPlantillaId"];
                    $DiasSolicitud= $negocio -> diasSolicitadosXSup($PlantillaId,$turnoDiaC,$turnoNocheC);//revisar si por fechas
                    if(count($DiasSolicitud)==0){
                       $TurnoDiaSolicitado = 0;
                       $TurnoNocheSolicitado = 0;
                      }else{
                            $TurnoDiaSolicitado = $DiasSolicitud[0][$turnoDiaC];
                            $TurnoNocheSolicitado=$DiasSolicitud[0][$turnoNocheC];
                           }
                    $turnosPorDia = $turnosPorDia + $TurnoDiaSolicitado + $TurnoNocheSolicitado; 
                    $turnoDeDia   = $turnoDeDia + $TurnoDiaSolicitado; 
                    $turnosDeNoche= $turnosDeNoche + $TurnoNocheSolicitado;  
                }    
            }
        }
        $datos[$i]["coberturaGeneralVentas"]= $turnosPorDia;
        $datos[$i]["coberturaDiaVentas"]    = $turnoDeDia;
        $datos[$i]["coberturaNocheVentas"]  = $turnosDeNoche;

        $TotalDeVehiculos = $negocio -> vehiculosAsignadosXSup($entidad,$fechaInicio,$fechaFin,$noSupervisor);
        $datos[$i]["vehiculos"] = count($TotalDeVehiculos);
        $placa1='';

        for($k=0; $k <count($TotalDeVehiculos) ; $k++) { 
         
            $placa2= $TotalDeVehiculos[$k]["placa"];
            if($k=="0"){
                $placa1= $placa2;
            }else{
                $placa1= $placa1.",".$placa2;
            }
        }
        $datos[$i]["placasVehiculos"] = $placa1;
    }//for LISTA ENTIDADES
    // $log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));
    // $log->LogInfo("Valor de la variable datosPS: " . var_export ($datosPS, true));
    // $log->LogInfo("Valor de la variable rolesOp: " . var_export ($rolesOp, true));
    $response["datos"]  = $datos;
    $response["datosPS"]= $datosPS;
    $response["rolesOp"]= $rolesOp;
    $response["status"] ="success";
} 
catch( Exception $e ){
    $response["status"]="error";
    $response["error"]="No se puedo obtener consulta";
}
echo json_encode($response);

