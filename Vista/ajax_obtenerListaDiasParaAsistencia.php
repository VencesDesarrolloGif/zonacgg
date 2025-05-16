<?php
session_start();
require "conexion.php";
require_once("../libs/logger/KLogger.php");
$response = array("status" => "success");
$configPeriodo1              = array();
$configHoraCierrePeriodo1              = array();
// date_default_timezone_set('America/Mexico_City');
if(!empty ($_POST))
{ 
    $log = new KLogger ( "ajax_obtenerListaDiasParaAsistencia.log" , KLogger::DEBUG );
    $log->LogInfo("Valor de variable empleadoEntidad _POST" . var_export ($_POST, true));
    try{

        $tipoPeriodo=$_POST["tipoPeriodo"];
        $debug            = 0;
        $segundos_por_dia = 86400;
        $currentTimestamp = null;
        $dias_semana = array("Dom", "Lun", "Mar", "Miér", "Jue", "Vier", "Sáb");
        $result      = array();
        $tipoPeriodo = strtoupper($tipoPeriodo);
        $id= "PERIODO_" . $tipoPeriodo;
        $sql = "SELECT valor from configuracion where id='$id'";      
        $res = mysqli_query($conexion, $sql);
        $configPeriodo1 = null;
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $configPeriodo1[] = $reg;
        }
        $configPeriodo = $configPeriodo1[0]["valor"];

        $id1= "PERIODO_HORA_CIERRE";
        $sql1 = "SELECT valor from configuracion where id='$id1'";      
    
        $res1 = mysqli_query($conexion, $sql1);
        while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
            $configHoraCierrePeriodo1[] = $reg1;
        }
        if(count($configHoraCierrePeriodo1) == "0"){
            $configHoraCierrePeriodo = null;
        }else{
            $configHoraCierrePeriodo = $configHoraCierrePeriodo1[0]["valor"];
        }
        if ($configPeriodo == null) {
            $response["status"]= "error";
            return $result;
        }
        $periodoHoraCierre = "13:00";
        if ($configHoraCierrePeriodo != null) {
            $periodoHoraCierre = $configHoraCierrePeriodo;
        }
        if ($currentTimestamp == null) {
            $currentTimestamp = time();
        }
        $log->LogInfo("Valor de variable empleadoEntidad currentTimestamp" . var_export ($currentTimestamp, true));
        $log->LogInfo("Valor de la  currentTimestampy : " . var_export (date("Y-m-d H:i:s",$currentTimestamp), true));
        $items  = explode(":", $periodoHoraCierre);
        $hora   = $items[0];
        $minuto = $items[1];
        $secondsExtra = $hora * 3600 + $minuto * 60;
        if ($tipoPeriodo == "SEMANAL") {
            $currentDiaSemana = date("w", $currentTimestamp);
            $diff             = $currentDiaSemana - $configPeriodo;
            $day              = $currentTimestamp - ($segundos_por_dia * $diff);
            $limit = mktime(0, 0, 0, date("n", $day), date("d", $day), date("Y", $day));
            $limit += $secondsExtra;

            if ($debug) {
                echo "CurrentDiaSemana:" . $dias_semana[$currentDiaSemana] . "<br/>";
                echo "ConfigPeriodo:" . $dias_semana[$configPeriodo] . "<br/>";
                echo "<p> currentTimestamp | " . date("Y-m-d H:i:s", $currentTimestamp) . " | " . $currentTimestamp . "</p>";
                echo "<p> day | " . date("Y-m-d H:i:s", $day) . " | " . $day . "</p>";
                echo "<p> limit | " . date("Y-m-d H:i:s", $limit) . " | " . $limit . "</p>";
            }
            if ($currentTimestamp < $limit) {
                $day -= 7 * $segundos_por_dia;
            }
            for ($i = $configPeriodo; $i < $configPeriodo + 7; $i++) {
                $result[] = array("fecha" => date("Y-m-d", $day),
                    "leyenda"                 => $dias_semana[$i % 7] . "-" . date("Y-m-d", $day), "dia" => $dias_semana[$i % 7] . " " . date("d-m", $day));
                $day += $segundos_por_dia;
            }
        }/* elseif ($tipoPeriodo == "CATORCENAL") {
            $startDay       = $configPeriodo;
            $startTimestamp = strtotime($startDay);
            $endTimestamp   = $startTimestamp + ($segundos_por_dia * 14);
            $limit          = $endTimestamp + $secondsExtra;

            if ($debug) {
                //$this -> print_timestamp ("startDay", $startDay);
                $this->print_timestamp("currentTimestamp", $currentTimestamp);
                $this->print_timestamp("startTimestamp", $startTimestamp);
                $this->print_timestamp("endTimestamp", $endTimestamp);
                $this->print_timestamp("limit", $limit);
            }

            if ($currentTimestamp > $limit) {
                $startDay = date("Y-m-d", $endTimestamp);
                $this->persistencia->saveParametroConfiguracion("PERIODO_" . $tipoPeriodo, $startDay, "Periodo catorcenal. Modificado por sistema");

                $startTimestamp = strtotime($startDay);
                $endtimestamp   = $startTimestamp + ($segundos_por_dia * 14);
            }

            $day = $startTimestamp;
            for ($i = 0; $i < 14; $i++) {
                $result[] = array("fecha" => date("Y-m-d", $day),
                    "leyenda"                 => $dias_semana[$i % 7] . "-" . date("Y-m-d", $day), "dia" => $dias_semana[$i % 7] . " " . date("d-m", $day));
                $day += $segundos_por_dia;
            }
        }*/ else // Periodo QUINCENAL
        {

            $log->LogInfo("Valor de variable empleadoEntidad currentTimestamp" . var_export ($currentTimestamp, true));
            $log->LogInfo("Valor de la  currentTimestampyaaaaaa : " . var_export (date("Y-m-d H:i:s",$currentTimestamp), true));
            $log->LogInfo("Valor de variable empleadoEntidad secondsExtra" . var_export ($secondsExtra, true));
            $currentTimestamp -= $secondsExtra;
            $log->LogInfo("Valor de variable empleadoEntidad currentTimestampaaaaaa" . var_export ($currentTimestamp, true));
            $log->LogInfo("Valor de la  currentTimestampyaaaaaa : " . var_export (date("Y-m-d H:i:s",$currentTimestamp), true));
            $currentDay   = date("j", $currentTimestamp);
            $currentMonth = date("n", $currentTimestamp);
            $currentYear  = date("Y", $currentTimestamp);
            if ($debug) {
                echo "<p>periodoHoraCierre:" . $hora . "--" . $minuto . "</p>";
            }
            $today     = $currentTimestamp; // mktime (0,0,0,$currentMonth, $currentDay, $currentYear);
            $startDay  = mktime(0, 0, 0, $currentMonth, 1, $currentYear);
            $endDay    = mktime(23, 59, 59, $currentMonth, 15, $currentYear);
            $changeDay = $endDay; // + ($segundos_por_dia / 2);
            if ($currentDay > 15) {
                $startDay = mktime(0, 0, 0, $currentMonth, 16, $currentYear);
                $lastDayOfMonth = date("t", $currentTimestamp);
                $endDay = mktime(23, 59, 59, $currentMonth, $lastDayOfMonth, $currentYear);
            }

            $startDay += ($segundos_por_dia * ($configPeriodo));
            $endDay += ($segundos_por_dia * ($configPeriodo));
            $changeDay = $endDay; // + ($segundos_por_dia / 2);
            if ($debug) {
                $log->LogInfo("Valor de la quincenal debug : " . var_export ($debug, true));
                echo "<p>Valores iniciales del timestamp y dia inicial y dia final del periodo<br/>";
                echo "currentTimestamp:" . $currentTimestamp . " " . date("Y-m-d H:i:s", $currentTimestamp) . "<br/>";
                echo "startDay:" . $startDay . " " . date("Y-m-d H:i:s", $startDay) . "<br/>";
                echo "endDay:" . $endDay . " " . date("Y-m-d H:i:s", $endDay) . "<br/>";
                echo "changeDay:" . $changeDay . " " . date("Y-m-d H:i:s", $changeDay) . "<br/>";
                echo "</p>";
            }
            // Ajuste para mostrar el nuevo periodo cuando
            // la fecha actual es mayor que el dia final del periodo
            if ($changeDay < $today) {
                $startDay = $endDay + 1;
                $endDay   = $startDay + ($segundos_por_dia * 10);
                $month = date("n", $endDay);
                $year  = date("Y", $endDay);
                $endDay1 = mktime(23, 59, 59, $month, 1, $year);
                $endDay2 = mktime(23, 59, 59, $month, 15, $year);
                if ($endDay < $endDay1) {
                    $endDay = $endDay1;
                } elseif ($endDay < $endDay2) {
                    $endDay = $endDay2;
                } else {
                    $lastDayOfMonth = date("t", $currentTimestamp);
                    $endDay         = mktime(23, 59, 59, $currentMonth, $lastDayOfMonth, $currentYear);
                }
                $endDay += ($segundos_por_dia * ($configPeriodo));
                $changeDay = $endDay + ($segundos_por_dia / 2);
                if ($debug) {
                    echo "<p>Cambio de periodo<br/>";
                    echo "currentTimestamp:" . $currentTimestamp . " " . date("Y-m-d H:i:s", $currentTimestamp) . "<br/>";
                    echo "startDay:" . $startDay . " " . date("Y-m-d H:i:s", $startDay) . "<br/>";
                    echo "endDay:" . $endDay . " " . date("Y-m-d H:i:s", $endDay) . "<br/>";
                    echo "changeDay:" . $changeDay . " " . date("Y-m-d H:i:s", $changeDay) . "<br/>";
                    echo "</p>";
                }
            }
            $day = $startDay;
            for ($i = date("Y-m-d", $startDay); $i <= date("Y-m-d", $endDay); $i = date("Y-m-d", strtotime($i . "+ 1 days"))) {
                $diaSemana = $dias_semana[date('w', strtotime($i))];
                $result[] = array("fecha" => $i,
                    "leyenda"                 => $diaSemana . "-" . $i, "dia" => $diaSemana . " " . date('d-m', strtotime($i)));
            }

        }
        $log->LogInfo("Valor de la semanal result : " . var_export ($result, true));
        $response["result"]= $result;

        // $asistencia= $negocio -> getAsistenciaByEmpleadoFecha($fechaAsistencia, $empleadoEntidad, $empleadoConsecutivo,$empleadoCategoria);
        // $response["asistencia"]= $asistencia;

        /*$log->LogInfo("Valor de variable de empleadoId que viene de form" . var_export ($empleadoId, true));
        $log->LogInfo("Valor de variable empleadoEntidad substr" . var_export ($empleadoEntidad, true));
        $log->LogInfo("Valor de variable empleadoConsecutivo substr" . var_export ($empleadoConsecutivo, true));
        $log->LogInfo("Valor de variable empleadoCategoria substr" . var_export ($empleadoCategoria, true));
        $log->LogInfo("Valor de variable fechaAsistencia " . var_export ($fechaAsistencia, true));
        
        $log->LogInfo("Valor de la variable \$response asistencia: " . var_export ($response, true));*/

    } 
    catch( Exception $e )
    {
    $response["status"]="error";
    $response["error"]="No se puedo obtener Asistencia";
    }
}
$log->LogInfo("Valor de la variable response asistencia: " . var_export ($response, true));
echo json_encode($response);

?>