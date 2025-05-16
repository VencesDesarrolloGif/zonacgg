<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajax_generarResumenAsistencia.log" , KLogger::DEBUG );
$response = array("status" => "success");

try{
    //$log->LogInfo("Valor de _POST" . var_export ($_POST, true));
    $puntoServicioId=getValueFromPost ("puntoServicioId");
    $fechaInicial = getValueFromPost ("fechaInicial");
    $fechaFinal = getValueFromPost ("fechaFinal");
    $IdPlantillaServ = getValueFromPost ("IdPlantillaServ");
    $turnosPorDia = 0;
    $turnoDeDia = 0;
    $turnosDeNoche = 0;
    $caso="1";
    $lista= $negocio -> getDetalleRequisicionesByPuntoServicioId($puntoServicioId,$IdPlantillaServ,$caso);
    // Calcula la cantidad de turnos por día
    foreach ($lista as $item)
    {
      $turnosPorDia += $item["turnosPorDia"];
    }
    $result = array ();
    $result [] = "";
    $listaTurnosCubiertos = $negocio -> getTurnosCubiertosByPeriodoFechasAndPuntoServicio ($fechaInicial, $fechaFinal, $puntoServicioId); 
    $listaTurnosCubiertosIE = $negocio -> obtenerTurnoCubiertosIncidenciasEspecialesXDia ($fechaInicial, $fechaFinal, $puntoServicioId); 
    for ($i =$fechaInicial; $i <=$fechaFinal; $i = date("Y-m-d", strtotime($i ."+ 1 days")))
    {      
        $DatosPlantillasPorPunto = $negocio -> GetDatosPlantillasPorPunto($puntoServicioId);
        if(count($DatosPlantillasPorPunto)!="0"){
            $LineaNegocioPunto = $DatosPlantillasPorPunto[0]["lineaNegocioRequisicion"];
        }else{
           $LineaNegocioPunto = ""; 
        }
        
        if($LineaNegocioPunto=="1"){
            $turnosPorDia=0;
            $turnoDeDia=0;
            $turnosDeNoche=0;
            $turnosCubiertosDia=0;
            $turnosCubiertosNoche=0;

            $LargoDatosplantilla = count($DatosPlantillasPorPunto);
            $dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
            $dia = $dias[(date('N', strtotime($i))) - 1];
            $turnoDiaC = $dia."TurnoDia";
            $turnoNocheC = $dia."TurnoNoche";
            for($j=0; $j<$LargoDatosplantilla;$j++){
                $PlantillaId = $DatosPlantillasPorPunto[$j]["servicioPlantillaId"];
                $DiasSolicitud= $negocio -> getDiasSolicitados($PlantillaId,$turnoDiaC,$turnoNocheC);
                $contadorArray = count($DiasSolicitud);
                if($contadorArray==0){
                    $TurnoDiaSolicitado = 0;
                    $TurnoNocheSolicitado = 0;
                }else{
                    $TurnoDiaSolicitado = $DiasSolicitud[0][$turnoDiaC];
                    $TurnoNocheSolicitado = $DiasSolicitud[0][$turnoNocheC];
                }
                $turnosPorDia = $turnosPorDia + $TurnoDiaSolicitado + $TurnoNocheSolicitado; 
                $turnoDeDia = $turnoDeDia + $TurnoDiaSolicitado; 
                $turnosDeNoche = $turnosDeNoche +  $TurnoNocheSolicitado; 
                
            }
            $result [$i]["turnosPorDia"] = $turnosPorDia;
            $result [$i]["turnoDeDia"] = $turnoDeDia;
            $result [$i]["turnosDeNoche"] = $turnosDeNoche;

            $listaTurnosCubiertosSeparados = $negocio -> getTurnosCubiertoSeparadosXPuntos($i, $puntoServicioId);
            for($k=0; $k<count($listaTurnosCubiertosSeparados);$k++){
                $tipoTurno = $listaTurnosCubiertosSeparados[$k]["tipoTurno"];

                if($tipoTurno=='1' || $tipoTurno=='3' || $tipoTurno=='5' || $tipoTurno=='7' || $tipoTurno=='18'){
                    $turnosCubiertosDia = $turnosCubiertosDia+1;
                }
                if($tipoTurno=='2' || $tipoTurno=='4' || $tipoTurno=='6' || $tipoTurno=='7' || $tipoTurno=='18'){
                    $turnosCubiertosNoche = $turnosCubiertosNoche+1;
                }
            }

            $result [$i]["turnosCubiertosDia"] = $turnosCubiertosDia;
            $result [$i]["turnosCubiertosNoche"] = $turnosCubiertosNoche; 

        }else{
            $result [$i]["turnosPorDia"] = $turnosPorDia;
            $result [$i]["turnoDeDia"] = $turnosPorDia;
            $result [$i]["turnosDeNoche"] = $turnosPorDia;
            $result [$i]["turnosCubiertosDia"] = $turnosPorDia;
            $result [$i]["turnosCubiertosNoche"] = $turnosPorDia;
        }
        $fecha = $i;
        $turnosCubiertos = (isset ($listaTurnosCubiertos [$fecha]) ? $listaTurnosCubiertos [$fecha]["cantidadTurnos"] : 0);
        $turnosCubiertos1 = $turnosCubiertos * 1;
        $turnosCubiertosIE = (isset ($listaTurnosCubiertosIE [$fecha]) ? $listaTurnosCubiertosIE [$fecha]["cantidadTurnos"] : 0);
        $turnosCubiertosIE1 = $turnosCubiertosIE * 1;
        $result [$i]["turnosCubiertos"] = $turnosCubiertos1 + $turnosCubiertosIE1;
        if($turnosPorDia==0 || $turnosPorDia=="" || $turnosPorDia==null){
            $RevisionTipoTurno = $negocio -> getTTipoTurnoCurbierto($i, $puntoServicioId);
            $ConteoRevisionTipoTurno = count($RevisionTipoTurno);
            if($ConteoRevisionTipoTurno!=0){
                for ($k=0; $k < $ConteoRevisionTipoTurno; $k++) { 
                    $incidenciaAsistenciaId = $RevisionTipoTurno[$k]["incidenciaAsistenciaId"];
                    if($incidenciaAsistenciaId=="1"){
                        $k=$ConteoRevisionTipoTurno;
                        $aaa = 100;
                    }else{
                        $aaa = 0;
                    }
                }
            }else{
                $aaa = 0;
            }            
        }else{
            $aaa = bcdiv(((100 / $turnosPorDia) * ($turnosCubiertos1 + $turnosCubiertosIE1)), '1', 0);
        }
        $porcent = $aaa * 1;
        $result [$i]["PrcentajeTotalTunos"] = $porcent;
        $result [$i]["idLineaNegocioPunto"] = $LineaNegocioPunto;
        //$log->LogInfo("Valor de la variable \$fecha: " . var_export ($fecha, true));
    }
      
    $response ["result"] = $result;
} 
catch( Exception $e )
{
    $response["status"]="error";
    $response["error"]="No se puedo obtener consulta";
}
echo json_encode($response);

