<?php
session_start();
require "conexion.php";
require_once("../libs/logger/KLogger.php");
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
$log = new KLogger ( "ajax_consultaRp.log" , KLogger::DEBUG );
$response["status"] = "error";
$response     = array();
$presupuestos = array();
// $datos = array();
// $registrosPat = array();
$cuotaPatronalIMSS = array();
$cuotaPatronalINFONAVIT = array();


$listaPlantillas = array();
$listaParaCobertura = array ();

$porcentajeTotalADM=0;
$porcentajeTotalOP=0;
$anio=$_POST['anio'];
// $mesF=$_POST['mes'];
$mes=$_POST['mes'];
// $lineaNeg=$_POST['lineaNeg'];
$lineasNegocio = array();

// FECHAS
$fecha1=$anio.'-'.$mes.'-01';

$month = $anio."-".$mes;
$ban  = 0;
$aux = date('Y-m-d', strtotime("{$month} + 1 month"));
$last_day = date('Y-m-d', strtotime("{$aux} - 1 day"));
$ultimoDía= substr($last_day,8,2);
$fecha2=$anio.'-'.$mes.'-'.$ultimoDía;
$ultimoDiaFlat = $ultimoDía; 
$fechaFlat=$anio.'-'.$mes.'-30';
// FECHAS


// $fecha1='2024-07-01';
// $fecha2='2024-07-31';
$response["fecha1"] = $fecha1;
$response["fecha2"] = $fecha2;

$dt1  = date($fecha1); 
$dt1  = new DateTime($dt1);   
$anio1= $dt1->format('Y');
$mes1 = $dt1->format('m');
$dia1 = $dt1->format('d');

$dt2  = date($fecha2);    
$dt2  = new DateTime($dt2); 
$anio2= $dt2->format('Y');
$mes2 = $dt2->format('m');

if($anio1== $anio2 && $mes1==$mes2 && $last_day == $fecha2 && $dia1=='01'){
   $ban=1;
}
$tipoConsulta  = 3;//mes

try {
    // $presupuestos[33]["entidad"] = "TOTAL";
    // $presupuestos[33]["montoAdmin"] =0;
    // $presupuestos[33]["montoOperativo"] =0;
    // $presupuestos[33]["totalNomina"] =0;
    // $presupuestos[33]["cuotaADMimss"] = 0;
    // $presupuestos[33]["cuotaOPimss"]  = 0;
    // $presupuestos[33]["cuotaADMinfonavit"]=0;
    // $presupuestos[33]["cuotaOPinfonavit"] =0;
    // $presupuestos[33]["sumaCuotaPatADM"]=0;
    // $presupuestos[33]["sumaCuotaPatOP"] =0;
    // $presupuestos[33]["presupuestoADM"]=0;
    // $presupuestos[33]["presupuestoOP"] =0;
    // $presupuestos[33]["porcentajeADM"]=0;
    // $presupuestos[33]["porcentajeOP"]=0;
    // $presupuestos[33]["rentabilidad"]=0;
    // $presupuestos[33]["porcentCobertura"]=0;
    // $presupuestos[33]["cobroPresupuesto"]=0;
    // $presupuestos[33]["porcentajeTotal"]=0;
    // $presupuestos[33]["CobroPresupuestado"]=0;
    // $presupuestos[33]["CostoCobertura"]=0;


    $PorcentajePorTotal = 0;
    $CostoPresupuestadosPorTotal = 0;
    $CostoCubiertosPorTotal = 0;
    $CantidadDePorcentajeTotal = 0;

    $lineasNegocio=[];
    $sql1 = "SELECT idLineaNegocio, descripcionLineaNegocio
             FROM catalogolineanegocio";     
    
    $res1 = mysqli_query($conexion, $sql1);
    while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
        $lineasNegocio[] = $reg1;
    }
    for($a=1; $a < 33; $a++){ 
        // $presupuestos[$a]["montoAdmin"]=0;
        // $presupuestos[$a]["montoOperativo"]=0;
        // $presupuestos[$a]["totalNomina"]=0;
        // $presupuestos[$a]["cuotaADMimss"]=0;
        // $presupuestos[$a]["cuotaOPimss"]=0;
        // $presupuestos[$a]["cuotaADMinfonavit"]=0;
        // $presupuestos[$a]["cuotaOPinfonavit"]=0;
        // $presupuestos[$a]["sumaCuotaPatADM"]=0;
        // $presupuestos[$a]["sumaCuotaPatOP"]=0;
        // $presupuestos[$a]["presupuestoADM"]=0;
        // $presupuestos[$a]["presupuestoOP"]=0;
        // $presupuestos[$a]["porcentajeADM"]='%0';
        // $presupuestos[$a]["porcentajeOP"]='%0';
        // $presupuestos[$a]["rentabilidad"]=0;
        // $presupuestos[$a]["porcentCobertura"]=0;
        // $presupuestos[$a]["cobroPresupuesto"]=0;
        $presupuestos[$a]["porcentajeTotal"]=0;
        $presupuestos[$a]["CobroPresupuestado"]=0;
        $presupuestos[$a]["CostoCobertura"]=0;
        
        $presupuestos[$a]["lista"]=array();
        
        if ($a==1 || $a==2 || $a==3 || $a==4 || $a==5 || $a==6 || $a==7 || $a==8 || $a==9 ) {
            $entidad='0'.$a;
        }else{
            $entidad=$a;
        }

        /*$datos=[];
        $sql = "SELECT nombreEntidadFederativa,montoOperativo,montoAdmin,SUM(montoOperativo+montoAdmin) AS totalNomina
                FROM presupuesto_nomina pr
                LEFT JOIN entidadesfederativas EF on ef.idEntidadFederativa=pr.idEntidad
                WHERE fechaPeriodoInicio LIKE '2024-07%'
                AND idEntidad='$entidad'";     
        // Cambiar la fecha por la variable dinamica
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }

        $nominaAdm=round($datos[0]["montoAdmin"]);
        $nominaOP =$datos[0]["montoOperativo"];

        $presupuestos[$a]["entidad"] = $datos[0]["nombreEntidadFederativa"];
        $presupuestos[$a]["montoAdmin"] = $nominaAdm;
        $presupuestos[$a]["montoOperativo"] = $nominaOP;
        $presupuestos[$a]["totalNomina"] = $datos[0]["totalNomina"];

        $presupuestos[33]["montoAdmin"] +=$nominaAdm;
        $presupuestos[33]["montoOperativo"] +=$nominaOP;
        $presupuestos[33]["totalNomina"] +=$datos[0]["totalNomina"];
        $cuotaADMema=0;
        $cuotaADMeba=0;
        $cuotaOPema=0;
        $cuotaOPeba=0;

        $registrosPat=[];
        $sql1 = "SELECT idcatalogoRegistrosPatronales 
                 FROM catalogoregistrospatronales
                 where entidadRegistro='$entidad'";     
        
        $res1 = mysqli_query($conexion, $sql1);
        while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
            $registrosPat[] = $reg1;
        }

        
            // $log->LogInfo("Valor de  a: " . var_export ($a, true));
        for($b=0; $b < count($registrosPat); $b++) { 
            $registro=$registrosPat[$b]["idcatalogoRegistrosPatronales"];
            $cuotaPatronalIMSS=[];

            $sql2 = "SELECT subtotalEMAHPEMA
                     FROM historico_ProvisionEMA
                     WHERE registroPatronalHPEMA='$registro'
                     AND anioProvisionHPEMA='$anio'
                     AND mesProvisionHPEMA='$mes'
                     AND lineaNegocioHPEMA='$lineaNeg'";     
        
            $res2 = mysqli_query($conexion, $sql2);
            while (($reg2 = mysqli_fetch_array($res2, MYSQLI_ASSOC))){
                $cuotaPatronalIMSS[] = $reg2;
            }
            // $log->LogInfo("Valor de  sql2: " . var_export ($sql2, true));

            if (count($cuotaPatronalIMSS)==0) {
                  $cuotaADMema=0;
                  $cuotaOPema =0;
            }else{
                  $cuotaADMema=$cuotaPatronalIMSS[0]["subtotalEMAHPEMA"];
                  $cuotaOPema =$cuotaPatronalIMSS[1]["subtotalEMAHPEMA"];
            }

            $presupuestos[$a]["cuotaADMimss"] = $cuotaADMema;
            $presupuestos[$a]["cuotaOPimss"]  = $cuotaOPema;
            $presupuestos[33]["cuotaADMimss"] += $cuotaADMema;;
            $presupuestos[33]["cuotaOPimss"]  += $cuotaOPema;
            $cuotaPatronalINFONAVIT=[];

            $sql3 = "SELECT netoHPEBA
                     FROM historico_ProvisionEBA
                     WHERE registroPatronalHPEBA='$registro'
                     AND anioProvisionHPEBA='$anio'
                     AND mesProvisionHPEBA='$mes'
                     AND lineaNegocioHPEBA='$lineaNeg'";     
        
            $res3 = mysqli_query($conexion, $sql3);
            while (($reg3 = mysqli_fetch_array($res3, MYSQLI_ASSOC))){
                $cuotaPatronalINFONAVIT[] = $reg3;
            }

            if (count($cuotaPatronalINFONAVIT)==0) {
                  $cuotaADMeba=0;
                  $cuotaOPeba =0;
            }else{
                $cuotaADMeba=$cuotaPatronalINFONAVIT[0]["netoHPEBA"];
                $cuotaOPeba =$cuotaPatronalINFONAVIT[1]["netoHPEBA"];
            }
             $presupuestos[$a]["cuotaADMinfonavit"] = $cuotaADMeba;
             $presupuestos[$a]["cuotaOPinfonavit"]  = $cuotaOPeba;

             $presupuestos[33]["cuotaADMinfonavit"]+= $cuotaADMeba;
             $presupuestos[33]["cuotaOPinfonavit"] += $cuotaOPeba;
             //suma de imss e infonavit 
             $presupuestos[$a]["sumaCuotaPatADM"]   = $cuotaADMema + $cuotaADMeba;
             $presupuestos[$a]["sumaCuotaPatOP"]    = $cuotaOPema + $cuotaOPeba;

             $presupuestos[33]["sumaCuotaPatADM"]   = $cuotaADMema + $cuotaADMeba;
             $presupuestos[33]["sumaCuotaPatOP"]    = $cuotaOPema + $cuotaOPeba;
        }//for b registros patronales
             //sumas de todo montoAdmin
             $presupuestoADM=$nominaAdm + $cuotaADMema + $cuotaADMeba;
             $presupuestoOP =$nominaOP+ $cuotaOPema + $cuotaOPeba;
             $presupuestos[$a]["presupuestoADM"]= $presupuestoADM;
             $presupuestos[$a]["presupuestoOP"] = $presupuestoOP;

             $presupuestos[33]["presupuestoADM"]+= $presupuestoADM;
             $presupuestos[33]["presupuestoOP"] += $presupuestoOP;
             */

             $PorcentajePorEntidad = 0;
             $CostoPresupuestadosPorEntidad = 0;
             $CostoCubiertosPorEntidad = 0;
             $CantidadDePorcentaje = 0;

             ////////////////////////////////////////////////////////////////////////////////////////////////////
                             // empieza lo de porcentaje
        for($b=0; $b < count($lineasNegocio); $b++) { 
            $lineaNeg=$lineasNegocio[$b]["idLineaNegocio"];

        $listaPlantillas=[];
        $sql4 = "SELECT sp.fechaInicio as fechaInicioPlantilla,
                        sp.fechaTerminoPlantilla as fechaFinPlantilla, 
                        cps.fechaInicioServicio as fechaInicio,
                        cps.fechaTerminoServicio as fechaTerminoPlantilla,
                        sp.puntoServicioPlantillaId,
                        sp.puestoPlantillaId,
                        sp.rolOperativoPlantilla,
                        ifnull(sp.replicada,0) as replicada,
                        sp.servicioPlantillaId,
                        cps.idClientePunto,
                        cps.puntoServicio,
                        sp.estatusPlantilla,
                        sp.numeroElementos as numEle,
                        ifnull(cps.cobraDescansos,0) as cobraDescansos,
                        ifnull(cps.cobraDiaFestivo,0) as cobraDiaFestivo,
                        ifnull(cps.cobra31,0) as cobra31,
                        cps.turnosFlat,
                        sp.costoPorTurno,
                        sp.IdRolOperativoPlantilla
                 FROM servicios_plantillas sp
                 LEFT JOIN catalogopuntosservicios cps on (sp.puntoServicioPlantillaId=cps.idPuntoServicio)
                 WHERE cps.idClientePunto !='13'
                 AND CPS.idEntidadPunto='$entidad'
                 AND sp.numeroElementos>0
                 AND sp.lineaNegocioRequisicion='$lineaNeg'
                 AND ((sp.estatusPlantilla=1 AND sp.fechaInicio<=cast('$fecha2' AS date))
                 OR (sp.estatusPlantilla=0 AND sp.fechaInicio<=cast('$fecha2' AS date ) AND sp.fechaTerminoPlantilla>=cast('$fecha1' AS date)))
                 order by sp.puntoServicioPlantillaId";  
        $res4 = mysqli_query($conexion, $sql4);
        while (($reg4 = mysqli_fetch_array($res4, MYSQLI_ASSOC))){
            $listaPlantillas[] = $reg4;
        }

        for($i=0; $i < count($listaPlantillas) ;$i++) { 
            // $log->LogInfo("Valor de  i: " . var_export ($i, true));
            $item= $listaPlantillas[$i];

            $fechaFinPL    = $item["fechaFinPlantilla"];//fechas plantilla
            $idPlantilla   = $item["servicioPlantillaId"];
            $replicada     = $item["replicada"];
            $servicio      = $item ["puntoServicioPlantillaId"];
            $idClientePunto= $item ["idClientePunto"];
            $CostoPorTurno = $item ["costoPorTurno"];
            $TurnosFlat    = $item ["turnosFlat"];
            $puntoServicio = $item ["puntoServicio"];
            $IdRolP = $item ["IdRolOperativoPlantilla"];
            $numEle = $item ["numEle"];

            $PorcentajePorPl = 0;
            $CostoPresupuestadosPorPl = 0;
            $CostoCubiertosPorPl = 0;

            // $log->LogInfo("Valor de  CostoPorTurno: " . var_export ($CostoPorTurno, true));
            // $log->LogInfo("Valor de  TurnosFlat: " . var_export ($TurnosFlat, true));
            // $log->LogInfo("Valor de  IdRolP: " . var_export ($IdRolP, true));

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
            }//replicada

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
            if($IdRolP=='2' || $IdRolP==2 || $IdRolP=='3' || $IdRolP==3){// no se mete el id3= 12x12x3 ni al id9=12x12x1 ya que en este momento no hay plantillas de ese rol y no se solicito 
                $TotalTurnosCubiertosPorPlantilla = 0;
                $TotalTurnosPresupuestadosPorPlantilla = 0;
                $totalTurnosCubiertosXPlantillaReal = 0;
                for($j = $item["fechaInicioPlantilla"]; $j <=  $item["fechaFinPlantilla"]; $j = date("Y-m-d", strtotime($j ."+ 1 days"))){
                    $listaTurnosCubiertosSeparados= $negocio -> TurnosCubiertoXPlantilla($j,$idPlantilla);
                    for($k=0; $k<count($listaTurnosCubiertosSeparados);$k++){
                        $tipoTurno = $listaTurnosCubiertosSeparados[$k]["tipoTurno"];
                        $TotalTurnosCubiertosPorPlantilla = $TotalTurnosCubiertosPorPlantilla + 1;
                        if($tipoTurno=='7' || $tipoTurno=='18'){
                            $TotalTurnosCubiertosPorPlantilla = $TotalTurnosCubiertosPorPlantilla + 1;
                        }   
                    }//for k
                    $listaTurnosIncidencias = $negocio -> TurnosCubiertoIncidenciasSeparadosXPlantillas($j,$idPlantilla);//Turnos Extras AUIIIIIIIIIIIIIIIIII    
                    // $log->LogInfo("Valor de  listaTurnosIncidencias: " . var_export ($listaTurnosIncidencias, true));                      
                    for($m=0; $m<count($listaTurnosIncidencias);$m++){
                        $TotalTurnosCubiertosPorPlantilla = $TotalTurnosCubiertosPorPlantilla + 1;
                    }//for m  
                }//for j
                // $log->LogInfo("Valor de  TotalTurnosCubiertosPorPlantilla: " . var_export ($TotalTurnosCubiertosPorPlantilla, true));
                // $log->LogInfo("Valor de  ultimoDía: " . var_export ($ultimoDía, true));
                // $log->LogInfo("Valor de  numEle: " . var_export ($numEle, true));
                if($TurnosFlat == "0"){
                    $TotalTurnosPresupuestadosPorPlantilla = ($ultimoDía * $numEle);
                    if($IdRolP=='2' || $IdRolP==2){
                        if($ultimoDía =='31'){
                            $aa1 = 25;
                        }else if($ultimoDía =='30'){
                            $aa1 = 24;
                        }else if($ultimoDía =='29'){
                            $aa1 = 23;
                        }else if($ultimoDía =='28'){
                            $aa1 = 22;
                        }
                    }else{
                        if($ultimoDía =='31'){
                            $aa1 = 25;
                        }else if($ultimoDía =='30'){
                            $aa1 = 24;
                        }else if($ultimoDía =='29'){
                            $aa1 = 23;
                        }else if($ultimoDía =='28'){
                            $aa1 = 22;
                        }
                    }
                    $aa2 =round($aa1 * $numEle);
                }else{
                    $TotalTurnosPresupuestadosPorPlantilla = (30 * $numEle);
                    if($IdRolP=='2' || $IdRolP==2){
                        $aa1 = 24;
                    }else{
                        $aa1 = 20; 
                    }
                }
                if($TotalTurnosCubiertosPorPlantilla > $aa1){
                    $aa1 = $TotalTurnosCubiertosPorPlantilla; 
                }
                $aa2 = round($aa1 * $numEle);
                // $log->LogInfo("Valor de  TotalTurnosCubiertosPorPlantilla: " . var_export ($TotalTurnosCubiertosPorPlantilla, true));
                // $log->LogInfo("Valor de  aa2: " . var_export ($aa2, true));
                $totalTurnosCubiertosXPlantillaReal = ($TotalTurnosCubiertosPorPlantilla/$aa2) * $TotalTurnosPresupuestadosPorPlantilla;
                // $log->LogInfo("Valor de  TotalTurnosPresupuestadosPorPlantilla: " . var_export ($TotalTurnosPresupuestadosPorPlantilla, true));
                
            }else{
                $TotalTurnosPresupuestadosPorPlantilla = 0;
                $totalTurnosCubiertosXPlantillaReal = 0;
                for($j = $item["fechaInicioPlantilla"]; $j <=  $item["fechaFinPlantilla"]; $j = date("Y-m-d", strtotime($j ."+ 1 days"))){
                    // se obtiene los turnos presupuestados que vienen de ventas
                    if($TurnosFlat == "0" || ($TurnosFlat == "1" && $j <= $fechaFlat)){
                        $item["dias"]=$item["dias"]+1;
                        $dias= array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
                        $dia = $dias[(date('N', strtotime($j))) - 1];
                        $turnoDiaC   = $dia."TurnoDia";
                        $turnoNocheC = $dia."TurnoNoche";
                        $TurnoDiaSolicitado  = 0;
                        $TurnoNocheSolicitado= 0;

                        $DiasSolicitud= $negocio -> DiasSolicitados($idPlantilla,$turnoDiaC,$turnoNocheC);//se utiliza la funcion  del ajax_ConteoTurnosXDia
                        $contadorArray = count($DiasSolicitud);

                        if($contadorArray!= 0){
                            $TurnoDiaSolicitado  = $DiasSolicitud[0][$turnoDiaC];
                            $TurnoNocheSolicitado= $DiasSolicitud[0][$turnoNocheC];
                        }
                        $TotalTurnosPresupuestadosPorPlantilla = $TotalTurnosPresupuestadosPorPlantilla + $TurnoDiaSolicitado + $TurnoNocheSolicitado;

                        //////////////////////// terminan los pturnos presupuestados que vienen de ventas//////////////////////////////////////////////
                        /////////////////////// Comienzan los turnos Cubiertos De asistencia //////////////////////////////////
                        $listaTurnosCubiertosSeparados= $negocio -> TurnosCubiertoXPlantilla($j,$idPlantilla);
                        for($k=0; $k<count($listaTurnosCubiertosSeparados);$k++){
                            $tipoTurno = $listaTurnosCubiertosSeparados[$k]["tipoTurno"];
                            $totalTurnosCubiertosXPlantillaReal = $totalTurnosCubiertosXPlantillaReal + 1;
                            if($tipoTurno=='7' || $tipoTurno=='18'){
                                $totalTurnosCubiertosXPlantillaReal = $totalTurnosCubiertosXPlantillaReal + 1;
                            }   
                        }//for k
                        $listaTurnosIncidencias = $negocio -> TurnosCubiertoIncidenciasSeparadosXPlantillas($j,$idPlantilla);//Turnos Extras AUIIIIIIIIIIIIIIIIII    
                        for($m=0; $m<count($listaTurnosIncidencias);$m++){
                            $totalTurnosCubiertosXPlantillaReal = $totalTurnosCubiertosXPlantillaReal + 1 ;
                        }//for m  
                    }
                }// for j dias
            }//else id rol operativo

            if($totalTurnosCubiertosXPlantillaReal==0 && $TotalTurnosPresupuestadosPorPlantilla ==0){
                $PorcentajePorPl = 0;
            }else{
                $PorcentajePorPl = ($totalTurnosCubiertosXPlantillaReal / $TotalTurnosPresupuestadosPorPlantilla)*100;
                $CantidadDePorcentaje = $CantidadDePorcentaje + 1;
            }
                $CostoPresupuestadosPorPl = $TotalTurnosPresupuestadosPorPlantilla * $CostoPorTurno;
                $CostoCubiertosPorPl = ($PorcentajePorPl * $CostoPresupuestadosPorPl)/100;

            $PorcentajePorEntidad = $PorcentajePorEntidad + $PorcentajePorPl;
            $CostoPresupuestadosPorEntidad = $CostoPresupuestadosPorEntidad + $CostoPresupuestadosPorPl;
            $CostoCubiertosPorEntidad = $CostoCubiertosPorEntidad + $CostoCubiertosPorPl;

        }// forc i plantillas
        if($PorcentajePorEntidad ==0 || $PorcentajePorEntidad == "0"){
            $PorcentajePorEntidad = 0;
        }else{
            $PorcentajePorEntidad = $PorcentajePorEntidad / $CantidadDePorcentaje;  
        }
        $CostoCubiertosPorEntidadModificado = ($PorcentajePorEntidad * $CostoPresupuestadosPorEntidad)/100; 
        

        $porcentajeTotal=round($PorcentajePorEntidad, 2);
        $cobroPresupuestado=round($CostoPresupuestadosPorEntidad, 2);


        $CostoCubiertosPorEntidadModificadorDecimales=round($CostoCubiertosPorEntidadModificado, 2);
        $presupuestos[$a]["porcentajeTotal"] = round($PorcentajePorEntidad, 2)."%";
        $presupuestos[$a]["CobroPresupuestado"] = round($CostoPresupuestadosPorEntidad, 2);
        $presupuestos[$a]["CostoCobertura"] = $CostoCubiertosPorEntidadModificadorDecimales;

        // rentabilidad
        // $sumaPresupuestosXent=$presupuestos[$a]["totalNomina"];
        // $presupuestos[$a]["rentabilidad"] = round(($CostoCubiertosPorEntidadModificadorDecimales-$sumaPresupuestosXent),2);

        // if($PorcentajePorEntidad != 0 && $PorcentajePorEntidad != "0"){
            // $CantidadDePorcentajeTotal = $CantidadDePorcentajeTotal + 1; 
        // }
        // $PorcentajePorTotal = $PorcentajePorTotal + $PorcentajePorEntidad;
        // $CostoPresupuestadosPorTotal = $CostoPresupuestadosPorTotal + $CostoPresupuestadosPorEntidad;
        // $CostoCubiertosPorTotal = $CostoCubiertosPorTotal + $CostoCubiertosPorEntidadModificado;

        $CostoPresupuestadosPorEntidad = 0 ;
        $CostoCubiertosPorEntidad = 0 ;
        $PorcentajePorEntidad = 0 ;
        $CantidadDePorcentaje = 0 ;

        $sql = "INSERT INTO historico_presupuestoDGCobertura(entidad_PresupuestoDGCob,anioPeriodo_PresupuestoDGCob,mesPeriodo_PresupuestoDGCob,lineaNegocioPresupuestoDGCob,porcentaje_PresupuestoDGCob,cobroPresupuesto_PresupuestoDGCob,costoCobertura_PresupuestoDGCob,fechaGuardadoPresupuestoDGCob) VALUES('$entidad','$anio','$mes','$lineaNeg','$porcentajeTotal','$cobroPresupuestado','$CostoCubiertosPorEntidadModificadorDecimales',now())"; 
    
        $res = mysqli_query($conexion, $sql);
        
        }//for b linea de negocio
    }//for a entidades

    /*
    if($PorcentajePorTotal == 0 || $PorcentajePorTotal == "0"){
        $PorcentajePorTotal = 0;
    }else{
        $PorcentajePorTotal = $PorcentajePorTotal / $CantidadDePorcentajeTotal;  

    }
    $CostoCubiertosPorEntidadModificadoTotAL = ($PorcentajePorTotal * $CostoPresupuestadosPorTotal)/100; 
    $CostoCubiertosPorTotal= round($CostoCubiertosPorTotal, 2);
    $presupuestos[33]["porcentajeTotal"]= round($PorcentajePorTotal, 2)."%";
    $presupuestos[33]["CobroPresupuestado"] = round($CostoPresupuestadosPorTotal, 2);
    $presupuestos[33]["CostoCobertura"] = $CostoCubiertosPorTotal;

    //rentabilidad total
    $sumaPresupuestosFinal=$presupuestos[33]["totalNomina"];
    $presupuestos[33]["rentabilidad"] +=round(($CostoCubiertosPorTotal-$sumaPresupuestosFinal),2);
    
    for($c=1; $c <33 ; $c++) {//otro for ya que tenemos el total 

        if ($c==1 || $c==2 || $c==3 || $c==4 || $c==5 || $c==6 || $c==7 || $c==8 || $c==9 ) {
            $entidadTotales='0'.$c;
        }else{
            $entidadTotales=$c;
        }

        // PORCENTAJESS ADM
        $presupuestoADMxEnt =$presupuestos[$c]["presupuestoADM"];
        $presupuestoTotalAdm=$presupuestos[33]["presupuestoADM"];
        $calculoPorcentajeAdminXent =($presupuestoADMxEnt/$presupuestoTotalAdm)*100;
        $porcentajeAdmXent=round($calculoPorcentajeAdminXent);
        $presupuestos[$c]["porcentajeADM"]= $porcentajeAdmXent.'%';

        // ADM
        // PORCENTAJESS OP
        $presupuestoOpxEnt=$presupuestos[$c]["presupuestoOP"];
        $presupuestoTotalOp=$presupuestos[33]["presupuestoOP"];
        $calculoPorcentajeOpXent =($presupuestoOpxEnt/$presupuestoTotalOp)*100;
        $porcentajeOpXent=round($calculoPorcentajeOpXent);
        $presupuestos[$c]["porcentajeOP"]=$porcentajeOpXent.'%';
        // OP

        //pendiente del total de porcentaje
        $porcentajeTotalOP+=$porcentajeOpXent;
        $porcentajeTotalADM+=$porcentajeAdmXent;

        $entidadMasUno=$c+1;
        if($entidadMasUno==33) {
            $presupuestos[33]["porcentajeADM"]=$porcentajeTotalADM.'%';
            $presupuestos[33]["porcentajeOP"]=$porcentajeTotalOP.'%';
        }
        //pendiente del total de porcentaje
    }//for c entidades   */
// termina lo de porcentaje

    $response["status"]= "success";
    // $response["datos"] = $presupuestos;
    // $response["listaCobertura"] = $listaParaCobertura;
    // $response["largo"] = count($presupuestos);
    // $log->LogInfo("Valor de  listaCobertura: " . var_export ($listaCobertura, true));
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);