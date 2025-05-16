<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
// $log = new KLogger ( "ajax_ConteoTurnosXDia.log" , KLogger::DEBUG );
$response = array("status" => "success");
try{
    $puntoServicioId=getValueFromPost ("coberturapuntoServicioId");
    $fechaInicial = getValueFromPost ("coberturafechaInicial");
    $fechaFinal = getValueFromPost ("coberturafechaFinal");
    $tipoBusqueda = getValueFromPost ("tipoBusqueda");
    $lineaNegocioElegido = getValueFromPost ("lineaNegocioElegido");
    $clienteElegido = getValueFromPost ("clienteElegido");
    $entidadElegida = getValueFromPost ("entidadElegida");
    $supervisorElegido = getValueFromPost ("supervisorElegido");
    $clienteElegidoSuperv = getValueFromPost ("clienteElegidoSuperv");
    $clienteElegidoGral = getValueFromPost ("clienteElegidoGral");
    $turnosPorDia = 0;
    $turnoDeDia = 0;
    $turnosDeNoche = 0;
    $turnosCubiertosDia=0;
    $turnosCubiertosNoche=0;
    $turnosGenerales=0;
    $turnosCubiertosGenerales=0;
    $turnosdenocheGenerales=0;
    $turnosGeneralCubiertosNoche=0;
    $turnoDeDiaGeneral=0;
    $turnosCubiertosDiaGeneral=0;

    if ($_SESSION["userLog"]["rol"]=='Gerente Regional') {
        $entidadGerente = $_SESSION["userLog"]['entidadFederativaUsuario'][0];//para obtener su region
        $casoXgerente='1';
        $region = $negocio->obtenerRegionGerente($lineaNegocioElegido,$entidadGerente);
        $regionGerente= $region[0]["idRegionI"];
    }else{
          $casoXgerente='0';
          $regionGerente='0';
         }


    $lista= $negocio -> obtenerDetalleRequisicionesByPuntoServicioId($puntoServicioId,$tipoBusqueda,$lineaNegocioElegido,$clienteElegido,$entidadElegida,$supervisorElegido,$clienteElegidoSuperv,$clienteElegidoGral,$casoXgerente,$regionGerente);//No.elementosXPlantilla linea
    // Calcula la cantidad de turnos por día
    foreach ($lista as $item)
    {
     $turnosPorDia += $item["turnosPorDia"];
    }

    $result = array ();
    //$result [] = "";
    //$listaTurnosCubiertos= $negocio -> obtenerTurnosCubiertosByPeriodoFechasAndPuntoServicio ($fechaInicial, $fechaFinal, $puntoServicioId,$tipoBusqueda,$clienteElegido,$entidadElegida,$supervisorElegido,$clienteElegidoSuperv,$lineaNegocioElegido,$clienteElegidoGral);
   
    for ($i =$fechaInicial; $i <=$fechaFinal; $i = date("Y-m-d", strtotime($i ."+ 1 days"))){
        $DatosPlantillasPorPunto = $negocio -> datosPlantillasPorPunto($puntoServicioId,$tipoBusqueda,$lineaNegocioElegido,$clienteElegido,$entidadElegida,$supervisorElegido,$clienteElegidoSuperv,$clienteElegidoGral,$casoXgerente,$regionGerente);

        $totalTurnoss = count($DatosPlantillasPorPunto);

        if ($totalTurnoss=='0'  || $totalTurnoss==0 || $totalTurnoss=='' || $totalTurnoss=='NULL' || $totalTurnoss==null || $totalTurnoss=='null') 
         {
          $result [$i]["turnosPorDia"] = 0;
          $result [$i]["turnoDeDia"] = 0;
          $result [$i]["turnosDeNoche"] = 0;
          $result [$i]["turnosCubiertosDia"] = 0;
          $result [$i]["turnosCubiertosNoche"] = 0;
          $result [$i]["turnosCubiertos"] = 0;
          $result [$i]["PrcentajeTotalTunos"] = 0;
          $result [$i]["idLineaNegocioPunto"] = 0;
         }else{
               $LineaNegocioPunto = $DatosPlantillasPorPunto[0]["lineaNegocioRequisicion"];

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
                       $TurnoDiaSolicitado = 0;
                       $TurnoNocheSolicitado = 0;
                       $DiasSolicitud= $negocio -> DiasSolicitados($PlantillaId,$turnoDiaC,$turnoNocheC);//aqui me quede
                       $contadorArray = count($DiasSolicitud);
                       if($contadorArray==0)
                       {
                          $TurnoDiaSolicitado = $TurnoDiaSolicitado + 0;
                          $TurnoNocheSolicitado = $TurnoNocheSolicitado + 0;
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
                       

                       $listaTurnosCubiertosSeparados= $negocio -> TurnosCubiertoSeparadosXPuntos($i,$puntoServicioId,$tipoBusqueda,$clienteElegido,$entidadElegida,$supervisorElegido,$clienteElegidoSuperv,$lineaNegocioElegido,$clienteElegidoGral,$casoXgerente,$regionGerente);
                      
                       for($k=0; $k<count($listaTurnosCubiertosSeparados);$k++){
                           $tipoTurno = $listaTurnosCubiertosSeparados[$k]["tipoTurno"];

                           if($tipoTurno=='1' || $tipoTurno=='3' || $tipoTurno=='5' || $tipoTurno=='7' || $tipoTurno=='18'){
                               $turnosCubiertosDia = $turnosCubiertosDia+1;//AA
                           }
                           if($tipoTurno=='2' || $tipoTurno=='4' || $tipoTurno=='6' || $tipoTurno=='7' || $tipoTurno=='18'){
                               $turnosCubiertosNoche = $turnosCubiertosNoche+1;
                           }
                       }
                      
                }else{
                      $result [$i]["turnosPorDia"] = $turnosPorDia;
                      $result [$i]["turnoDeDia"] = $turnosPorDia;
                      $result [$i]["turnosDeNoche"] = $turnosPorDia;
                      $result [$i]["turnosCubiertosDia"] = $turnosPorDia;
                      $result [$i]["turnosCubiertosNoche"] = $turnosPorDia;
                     }       
                      $fecha = $i;
                   //   $turnosCubiertos = (isset ($listaTurnosCubiertos [$fecha]) ? $listaTurnosCubiertos [$fecha]["cantidadTurnos"] : 0);
                      
                      $listaTurnosIncidencias = $negocio -> TurnosCubiertoIncidenciasSeparadosXPuntos($i,$puntoServicioId,$lineaNegocioElegido,$tipoBusqueda,$clienteElegido,$entidadElegida,$supervisorElegido,$clienteElegidoSuperv,$clienteElegidoGral,$casoXgerente,$regionGerente);//Turnos Extras AUIIIIIIIIIIIIIIIIII
                      
                       for($k=0; $k<count($listaTurnosIncidencias);$k++){

                           $incidenciaId = $listaTurnosIncidencias[$k]["incidenciaId"];


                           if($incidenciaId=='1'){
                               $turnosCubiertosDia = $turnosCubiertosDia+1;
                           }
                           if($incidenciaId=='6'){
                               $turnosCubiertosNoche = $turnosCubiertosNoche+1;
                           }
                        }
            
                        $result [$i]["turnosCubiertosDia"] = $turnosCubiertosDia;
                        $result [$i]["turnosCubiertosNoche"] = $turnosCubiertosNoche;
                        $turnosCubiertos=($turnosCubiertosDia + $turnosCubiertosNoche);
                        $result [$i]["turnosCubiertos"] =$turnosCubiertos; 

                        if( $turnosPorDia==0 || $turnosPorDia=="" || $turnosPorDia==null)
                      {
                       $aaa = 0;
                      }else{
                           $aaa = bcdiv(((100 / $turnosPorDia) * $turnosCubiertos), '1', 0);
                      }
                      $porcent = $aaa * 1;
                      $result [$i]["PrcentajeTotalTunos"] = $porcent;
                      $result [$i]["idLineaNegocioPunto"] = $LineaNegocioPunto;

                         $turnosCubiertosDia=0;
                         $turnosCubiertosNoche=0;
        }
              $turnosGenerales=  $turnosGenerales + $result [$i]["turnosPorDia"];
              $turnosCubiertosGenerales =  $turnosCubiertosGenerales + $result [$i]["turnosCubiertos"];

              $turnosdenocheGenerales= $result [$i]["turnosDeNoche"] + $turnosdenocheGenerales;
              $turnosGeneralCubiertosNoche= $result [$i]["turnosCubiertosNoche"] + $turnosGeneralCubiertosNoche;
              $turnoDeDiaGeneral= $result [$i]["turnoDeDia"] + $turnoDeDiaGeneral;
              $turnosCubiertosDiaGeneral= $result [$i]["turnosCubiertosDia"] + $turnosCubiertosDiaGeneral;
              

    }  
             $result["turnosPorDia1"] = $turnosGenerales;
             $result["turnosdenocheGenerales"] = $turnosdenocheGenerales;
             $result["turnosGeneralCubiertosNoche"] = $turnosGeneralCubiertosNoche;

             $result["turnoDeDiaGeneral"] = $turnoDeDiaGeneral;                   
             $result["turnosCubiertosDiaGeneral"] = $turnosCubiertosDiaGeneral;                   

             $result["turnosCubiertos1"] = $turnosCubiertosGenerales;                   

       $response ["result"] = $result;
    }catch( Exception $e )
            {
             $response["status"]="error";
             $response["error"]="No se puedo obtener consulta";
            }
      // $log->LogInfo("Valor de la variable response: " . var_export ($response, true));
echo json_encode($response);

