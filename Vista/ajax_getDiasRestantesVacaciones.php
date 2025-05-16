<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_DiasRestantesVacaciones.log" , KLogger::DEBUG );
$empleadoEntidadId=$_POST["empleadoEntidadId"];
$empleadoConsecutivoId=$_POST["empleadoConsecutivoId"];
$empleadoTipoId=$_POST["empleadoTipoId"];
$Aniversario=$_POST["Aniversario"];
$AniversarioAnts= $Aniversario-1;
//$log->LogInfo("Valor de _POST  " . var_export ($_POST, true));

try {

    $DiasVacacionesTomadas   = $negocio->ObtenerTotalDeDiasVacaciones($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$Aniversario);//Dias De Vacaciones Tomadas
    $DiasAniversario   = $negocio->ObtenerDiasCorrespondientesALAniversario($Aniversario);// Dias Que Le Corresponden Por El Aniversario
    $obtenerFechaIngreso1 = $negocio->obtenerFechaAltaEmpleado($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId);

    $FechaAltaEmpleadoImss = $obtenerFechaIngreso1[0]["FechaAltaEmpleado"];
    $FechaimssExplode = explode("-", $FechaAltaEmpleadoImss);
    $AnioAltaImss = $FechaimssExplode[0];

    $SieteDIas="7";
    $FechaAltaEmpleado = $obtenerFechaIngreso1[0]["FechaAltaEmpleadoEmpleados"];
    $FechaAltaEmpleadoEmp = strtotime ('+'.$SieteDIas.' days' , strtotime($FechaAltaEmpleado)); //Se añaden 7 dias de diferencia
    $FechaAltaEmpleadoEmp = date ('Y-m-d',$FechaAltaEmpleadoEmp);// Se da formato a la fecha
    $FechaExplode = explode("-", $FechaAltaEmpleado);
    $AnioAlta = $FechaExplode[0];

    if($AnioAlta<$AnioAltaImss){
        $FechaAltaEmpleado = $FechaAltaEmpleado;
    }else if($AnioAlta==$AnioAltaImss){
        if($FechaAltaEmpleadoEmp<$FechaAltaEmpleadoImss){
            $FechaAltaEmpleado = $FechaAltaEmpleado;
        }else{
            $FechaAltaEmpleado = $FechaAltaEmpleadoImss;
        }
    }else{
        $FechaAltaEmpleado = $FechaAltaEmpleadoImss; 
    }

 //   $log->LogInfo("Valor de FechaAltaEmpleado" . var_export ($FechaAltaEmpleado, true));

    
    $FechaUno = strtotime ('+'.$AniversarioAnts.' year' , strtotime($FechaAltaEmpleado)); //Se añade un año mas
    $FechaUno = date ('Y-m-d',$FechaUno);// Se da formato a la fecha
    $FechaDos = strtotime ('+'.$Aniversario.' year' , strtotime($FechaAltaEmpleado)); //Se añade un año mas
    $FechaDos = date ('Y-m-d',$FechaDos);// Se da formato a la fecha
    $FechaActual = date("Y-m-d");
    $DiasAniversario = $DiasAniversario[0]["DiasAniversario"]; 

    // Se realiza el explode para saber en que año ermina si termina del 2022 hacia atras se tomaran las vaciones divididas en dos si es del 2023 hacia adelante se tomana del catalogo nuevo de antiguedad
    $FechaFinalExplode = explode('-', $FechaDos);
    $FechaAnioFinal = $FechaFinalExplode[0];
    if($FechaAnioFinal<='2022'){
        if($Aniversario!='0'){
            if($Aniversario>=6){
                $DiasAniversario = $DiasAniversario-8;
            }else{
                $DiasAniversario = $DiasAniversario-6; 
            }
        }
    }
    
    $TotalDeDiasVacaciones = $DiasVacacionesTomadas[0]["TotalDeDiasVacaciones"];
    $RestaDias = $DiasAniversario-$TotalDeDiasVacaciones;

  //  $log->LogInfo("Valor de TotalDeDiasVacaciones" . var_export ($TotalDeDiasVacaciones, true));

    
    if($FechaDos>$FechaActual){
        $datetime1 = new DateTime($FechaUno);
        $datetime2 = new DateTime($FechaActual);
        $diastrabajados = $datetime1->diff($datetime2);
        $dtstr = $diastrabajados->format('%R%a');
        $dtstring = substr($dtstr, 1);
        $antiguedadUltimoAniversario = (int) $dtstring;
        $DiasDisponiblesTotal = (($antiguedadUltimoAniversario/365)*$DiasAniversario);
        $DiasDisponibles1 = explode(".", $DiasDisponiblesTotal);
        $DiasDisponibles = $DiasDisponibles1[0];
    }else{
        if($RestaDias<"0"){
            $DiasDisponibles = 0;
        }else{
            $DiasDisponibles = $RestaDias;
        }
    }    
 //   $log->LogInfo("Valor de DiasDisponibles" . var_export ($DiasDisponibles, true));

    $response["DiasDisponibles"] = $DiasDisponibles;
    $response["FechaUno"] = $FechaUno;
    $response["FechaDos"] = $FechaDos;
} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No Se Obtuvieron Los Dias Disponibles";
}

echo json_encode($response);
