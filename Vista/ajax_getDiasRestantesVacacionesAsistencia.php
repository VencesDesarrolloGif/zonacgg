<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_getDiasRestantesVacacionesAsistencia.log" , KLogger::DEBUG );
$empleadoEntidadId=$_POST["empleadoEntidadId"];
$empleadoConsecutivoId=$_POST["empleadoConsecutivoId"];
$empleadoTipoId=$_POST["empleadoTipoId"];
$Aniversario=$_POST["Aniversario"]; 
$AniversarioAnts= $Aniversario-1;

try {

    $DiasVacacionesTomadas   = $negocio->ObtenerTotalDeDiasVacaciones($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$Aniversario);//Dias De Vacaciones Tomadas
   // $log->LogInfo("Valor de DiasVacacionesTomadas" . var_export ($DiasVacacionesTomadas, true));
    $obtenerFechaIngreso1 = $negocio->obtenerFechaAltaEmpleado($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId);
    if($Aniversario=="0"){
        $DiasAniversario   = $negocio->ObtenerDiasCorrespondientesAOtrasEmpresas($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId);// Dias Que Le Corresponden Por El Aniversario 0 ingresados desde la tabla de  dias vacaciones otras empresas  
        $DiasAniversario0 = $DiasAniversario[0]["DiasTotalesVacaciones"];  
        if($DiasAniversario0 =="" || $DiasAniversario0==null || $DiasAniversario0=="null" || $DiasAniversario0==NULL || $DiasAniversario0=="NULL"){
            $DiasAniversario1 = "0";
        }else{
            $DiasAniversario1 = $DiasAniversario0;
        }
    }else{
        $DiasAniversario   = $negocio->ObtenerDiasCorrespondientesALAniversario($Aniversario);// Dias Que Le Corresponden Por El Aniversario de la tabla antiguedad   
        $DiasAniversario1 = $DiasAniversario[0]["DiasAniversario"];
    } 
//$log->LogInfo("Valor de DiasAniversario" . var_export ($DiasAniversario, true));
//$log->LogInfo("Valor de DiasAniversario1" . var_export ($DiasAniversario1, true));
    $FechaAltaEmpleadoImss = $obtenerFechaIngreso1[0]["FechaAltaEmpleado"];
    $FechaimssExplode = explode("-", $FechaAltaEmpleadoImss);
    $AnioAltaImss = $FechaimssExplode[0];

    $SieteDIas="7";
    $FechaAltaEmpleadoEmp1 = $obtenerFechaIngreso1[0]["FechaAltaEmpleadoEmpleados"];
    $FechaAltaEmpleadoEmp = strtotime ('+'.$SieteDIas.' days' , strtotime($FechaAltaEmpleadoEmp1)); //Se añaden 7 dias de diferencia
    $FechaAltaEmpleadoEmp = date ('Y-m-d',$FechaAltaEmpleadoEmp);// Se da formato a la fecha
    $FechaExplode = explode("-", $FechaAltaEmpleadoEmp);
    $AnioAlta = $FechaExplode[0];

    if($AnioAlta<$AnioAltaImss){
        $FechaAltaEmpleado = $FechaAltaEmpleadoEmp1;
    }else if($AnioAlta==$AnioAltaImss){
        if($FechaAltaEmpleadoEmp1<$FechaAltaEmpleadoImss){
            $FechaAltaEmpleado = $FechaAltaEmpleadoEmp1;
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
    // Se realiza el explode para saber en que año ermina si termina del 2022 hacia atras se tomaran las vaciones divididas en dos si es del 2023 hacia adelante se tomana del catalogo nuevo de antiguedad
    $FechaFinalExplode = explode('-', $FechaDos);
    $FechaAnioFinal = $FechaFinalExplode[0];
    if($FechaAnioFinal<='2022'){
        if($Aniversario!='0'){
            if($Aniversario>=6){
                $DiasAniversario1 = $DiasAniversario1-8;
            }else{
                $DiasAniversario1 = $DiasAniversario1-6;
            }
        }
    }
    $TotalDeDiasVacaciones = $DiasVacacionesTomadas[0]["TotalDeDiasVacaciones1"];
    $RestaDias = $DiasAniversario1-$TotalDeDiasVacaciones;
    if($Aniversario=="0"){
        $DiasDisponibles = $RestaDias;
        $FechaUno = "Dias Pendientes";
        $FechaDos = "De Otra Empresa";
    }else{
        if($FechaDos>$FechaActual){ 
            $datetime1 = new DateTime($FechaUno);
            $datetime2 = new DateTime($FechaActual);
            $diastrabajados = $datetime1->diff($datetime2);
            $dtstr = $diastrabajados->format('%R%a');
            $dtstring = substr($dtstr, 1);
            $antiguedadUltimoAniversario = (int) $dtstring;
            $DiasDisponiblesTotal = (($antiguedadUltimoAniversario/365)*$DiasAniversario1);
            $DiasDisponibles1 = explode(".", $DiasDisponiblesTotal);
            $DiasDisponibles0 = $DiasDisponibles1[0];
            $RestaDias1 = $DiasDisponibles0-$TotalDeDiasVacaciones;
            if($RestaDias1<"0"){
                $DiasDisponibles = 0;
            }else{
                $DiasDisponibles = $RestaDias1;
            }
        }else{
            if($RestaDias<"0"){
                $DiasDisponibles = 0;
            }else{
                $DiasDisponibles = $RestaDias;
            }
        }
    }    
    $response["DiasDisponibles"] = $DiasDisponibles;
    $response["FechaUno"] = $FechaUno;
    $response["FechaDos"] = $FechaDos;
} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No Se Obtuvieron Los Dias Disponibles";
}
//$log->LogInfo("Valor de response" . var_export ($response, true));
echo json_encode($response);
