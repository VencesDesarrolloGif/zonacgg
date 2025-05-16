<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
// $log = new KLogger ( "ajax_PorcentajeCoberturaSupervisor.log" , KLogger::DEBUG );
$response = array("status" => "success");

try{
    $fechaInicial = getValueFromPost ("coberturafechaInicial");
    $fechaFinal = getValueFromPost ("coberturafechaFinal");
    $tipoBusqueda = getValueFromPost ("tipoBusqueda");
    $lineaNegocioElegido = getValueFromPost ("lineaNegocioElegido");
    $valorgifTipo = getValueFromPost ("valorgifTipo");
    $entidadSupervisores = getValueFromPost ("entidadSupervisores");
    $turnosPorDia = 0;//ventas
    $turnoDeDia = 0;//ventas
    $turnosDeNoche = 0;//ventas
    $turnosCubiertosDia=0;//cubiertos
    $turnosCubiertosNoche=0;//cubiertos
    $turnosCubiertos=0;//cubiertos
    $turnosGenerales=0;
    $turnosCubiertosGenerales =0;
    $turnosdenocheGenerales=0;
    $turnosGeneralCubiertosNoche=0;
    $turnoDeDiaGeneral=0;
    $turnosCubiertosDiaGeneral=0;
    
    $tipoBusqueda = getValueFromPost ("tipoBusqueda");
        $listasupervisores= $negocio -> obtenerSupervisoresXLinea($lineaNegocioElegido,$valorgifTipo,$tipoBusqueda,$entidadSupervisores);//Aqui me quede en mandar el tipo gif

    $result = array ();
    $result [] = "";
    for ($h=0; $h < count($listasupervisores); $h++){
      $supervisorNumero =$listasupervisores[$h]['NumEmpSupervisor'];
      $supervisorNombre =$listasupervisores[$h]['Nombre'];
      $lista= $negocio -> obtenerTurnosdePlantillas($supervisorNumero,$tipoBusqueda,$lineaNegocioElegido);//No.elementosXPlantilla linea
      foreach ($lista as $item){$turnosPorDia += $item["turnosPorDia"];}  
      $turnosPorDiaTemp =0;//ventas
      $turnoDeDiaTemp =0;//ventas
      $turnosDeNocheTemp =0;//ventas
      $turnosCubiertosDiaTemp =0;//cobertura
      $turnosCubiertosNocheTemp =0;//cobertura
      $turnosCubiertosTemp =0;//cobertura

      $turnoDeDiaGeneral=0;
      $turnosdenocheGenerales=0;
      $turnosGenerales=0;
      $turnosCubiertosDiaGeneral=0;
      $turnosGeneralCubiertosNoche=0;
      $turnosCubiertosGenerales=0;


      for ($i =$fechaInicial; $i <=$fechaFinal; $i = date("Y-m-d", strtotime($i ."+ 1 days"))){

        $DatosPlantillasPorPunto = $negocio -> DatosPlantillas($supervisorNumero,$tipoBusqueda,$lineaNegocioElegido);
        $totalTurnoss = count($DatosPlantillasPorPunto);
        if ($totalTurnoss=='0'  || $totalTurnoss==0 || $totalTurnoss=='' || $totalTurnoss=='NULL' || $totalTurnoss==null || $totalTurnoss=='null') 
        {
         $turnosPorDiaTemp =0;//ventas
         $turnoDeDiaTemp =0;//ventas
         $turnosDeNocheTemp =0;//ventas
         $turnosCubiertosDiaTemp =0;//cobertura
         $turnosCubiertosNocheTemp =0;//cobertura
         $turnosCubiertosTemp =0;//cobertura
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
              $DiasSolicitud= $negocio -> DiasSolicitados($PlantillaId,$turnoDiaC,$turnoNocheC);//es la misma funcion que en ajax_ConteoTurnosXDía.php
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
            $turnosPorDiaTemp = $turnosPorDia;
            $turnoDeDiaTemp = $turnoDeDia;
            $turnosDeNocheTemp = $turnosDeNoche;
                         
            $listaTurnosCubiertosSeparados= $negocio -> TurnosCubiertosXPuntos($supervisorNumero,$i,$tipoBusqueda,$lineaNegocioElegido);      
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
          $turnosPorDiaTemp = $turnosPorDia;
          $turnoDeDiaTemp = $turnosPorDia;
          $turnosDeNocheTemp = $turnosPorDia;
          $turnosCubiertosDiaTemp = $turnosPorDia;
          $turnosCubiertosNocheTemp = $turnosPorDia;
          }       
          $fecha = $i;
          $listaTurnosIncidencias = $negocio -> TurnosCubiertosIncidencias($supervisorNumero,$i,$lineaNegocioElegido,$tipoBusqueda);//Turnos Extras
          for($k=0; $k<count($listaTurnosIncidencias);$k++){
             $incidenciaId = $listaTurnosIncidencias[$k]["incidenciaId"];
             if($incidenciaId=='1'){
                 $turnosCubiertosDia = $turnosCubiertosDia+1;
             }
             if($incidenciaId=='6'){
                 $turnosCubiertosNoche = $turnosCubiertosNoche+1;
             }
          }
          $turnosCubiertosDiaTemp = $turnosCubiertosDia;
          $turnosCubiertosNocheTemp = $turnosCubiertosNoche;
          $turnosCubiertos=($turnosCubiertosDia + $turnosCubiertosNoche);
          $turnosCubiertosTemp =$turnosCubiertos; 
  
          $turnosCubiertosDia=0;
          $turnosCubiertosNoche=0;
        }//else turnos 
        $turnoDeDiaGeneral= $turnoDeDiaTemp + $turnoDeDiaGeneral;
        $turnosdenocheGenerales= $turnosDeNocheTemp + $turnosdenocheGenerales;
        $turnosGenerales=  $turnosGenerales + $turnosPorDiaTemp;
        $turnosCubiertosDiaGeneral= $turnosCubiertosDiaTemp + $turnosCubiertosDiaGeneral;
        $turnosGeneralCubiertosNoche= $turnosCubiertosNocheTemp + $turnosGeneralCubiertosNoche;
        $turnosCubiertosGenerales =  $turnosCubiertosGenerales + $turnosCubiertosTemp;
      }//for Fechsa

      $result[$h]["turnoDeDiaGeneral"] = $turnoDeDiaGeneral;
      $result[$h]["turnosdenocheGenerales"] = $turnosdenocheGenerales;
      $result[$h]["turnosGenerales"] = $turnosGenerales;
      $result[$h]["turnosCubiertosDiaGeneral"] = $turnosCubiertosDiaGeneral;                   
      $result[$h]["turnosGeneralCubiertosNoche"] = $turnosGeneralCubiertosNoche;                   
      $result[$h]["turnosCubiertosGenerales"] = $turnosCubiertosGenerales; 
      $result[$h]["Supervisor"] = $supervisorNumero; 
      $result[$h]["NombreSupervisor"] = $supervisorNombre; 

      if ($turnosCubiertosGenerales==0 && $turnosGenerales==0) {
          $result[$h]["porcentajeTotalCubierto"] = 100;
        }
      else if ($turnosCubiertosGenerales!=0 && $turnosGenerales==0) {

          $result[$h]["porcentajeTotalCubierto"] = (($turnosCubiertosGenerales)*100);
      }
      else{
      $CalculoPorcentaje=($turnosCubiertosGenerales/$turnosGenerales)*100;
      $porcentajeTotalCubierto = round($CalculoPorcentaje);
      $result[$h]["porcentajeTotalCubierto"] = $porcentajeTotalCubierto; 
}
    }//termina for supervisores
    // $log->LogInfo("Valor de la variable result: " . var_export ($result, true));
             
    $response ["result"] = $result;
  }catch( Exception $e )
  {
   $response["status"]="error";
   $response["error"]="No se puedo obtener consulta";
  }
echo json_encode($response);

