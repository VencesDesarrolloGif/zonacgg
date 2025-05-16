<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
$response = array ();
verificarInicioSesion ($negocio);
if (!empty ($_POST))
{
    //$log = new KLogger ( "ajax_GetDatosEmpleadoFiniquito.log" , KLogger::DEBUG );  
    $folioBaja=getValueFromPost("folioBaja");
    //$log->LogInfo("Valor de la variable GetDatosEmpleadoFiniquito: " . var_export (count($GetDatosEmpleadoFiniquito), true));
    try
    {
        $GetDatosEmpleadoFiniquito = $negocio -> GetDatosEmpleadoFiniquito($folioBaja);
     //$log->LogInfo("Valor de la variable GetDatosEmpleadoFiniquito: " . var_export ($GetDatosEmpleadoFiniquito, true));

        $FechaActual = date("Y-m-d");
        $ExplodeFechaAtual = explode("-", $FechaActual); 
        $anio2 = $ExplodeFechaAtual[0];
        $mes2 = $ExplodeFechaAtual[1];
        $dia2 = $ExplodeFechaAtual[2];

        for($i=0; $i<count($GetDatosEmpleadoFiniquito); $i++){
            $SumaDiasDisponibles="0";
            $empleadoEntidadId = $GetDatosEmpleadoFiniquito[$i]["empladoEntidadImss"];
            $empleadoConsecutivoId = $GetDatosEmpleadoFiniquito[$i]["empleadoConsecutivoImss"];
            $empleadoTipoId = $GetDatosEmpleadoFiniquito[$i]["empleadoCategoriaImss"];
            $registroPatronal = $GetDatosEmpleadoFiniquito[$i]["registroPatronal"];
            $response[$i]["registroPatronal"] = $registroPatronal;
            if($registroPatronal != "V8485152525"){
            
                $obtenerFechaIngreso = $negocio->obtenerFechaAltaEmpleado($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId);
    
                $FechaAltaEmpleado = $obtenerFechaIngreso[0]["FechaAltaEmpleado"];
                $FechaAltaEmpleadoLaborales = $obtenerFechaIngreso[0]["FechaAltaEmpleado"];
                $FechaExplode = explode("-", $FechaAltaEmpleado);
                $AnioAlta = $FechaExplode[0];
                $MesAlta = $FechaExplode[1];
                $DiaAlta = $FechaExplode[2];
        
                $diferenciaDeAnios= ($anio2-$AnioAlta)+1;
                $diferenciaDeAniosmsnos= $diferenciaDeAnios-1;
    
                for($j=0; $j<$diferenciaDeAnios;$j++){
                    $Aniversario = $j+1;
                    $AniversarioAnts= $Aniversario-1;
    
                    $DiasVacacionesTomadas   = $negocio->ObtenerTotalDeDiasVacaciones($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$Aniversario);//Dias De Vacaciones Tomadas
                    $DiasAniversario   = $negocio->ObtenerDiasCorrespondientesALAniversario($Aniversario);// Dias Que Le Corresponden Por El Aniversario
                    $obtenerFechaIngreso1 = $negocio->obtenerFechaAltaEmpleado($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId);
                    //$log->LogInfo("Valor de la variable DiasVacacionesTomadas: " . var_export (count($DiasVacacionesTomadas), true));
                    //$log->LogInfo("Valor de la variable DiasAniversario: " . var_export (count($DiasAniversario), true));
                    //$log->LogInfo("Valor de la variable obtenerFechaIngreso1: " . var_export (count($obtenerFechaIngreso1), true));
    
    
                    $FechaAltaEmpleado = $obtenerFechaIngreso1[0]["FechaAltaEmpleado"];
                    $FechaUno = strtotime ('+'.$AniversarioAnts.' year' , strtotime($FechaAltaEmpleado)); //Se añade un año mas
                    $FechaUno = date ('Y-m-d',$FechaUno);// Se da formato a la fecha
                    $FechaDos = strtotime ('+'.$Aniversario.' year' , strtotime($FechaAltaEmpleado)); //Se añade un año mas
                    $FechaDos = date ('Y-m-d',$FechaDos);// Se da formato a la fecha
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
                    if($j<$diferenciaDeAniosmsnos){
                        $SumaDiasDisponibles=$DiasDisponibles+$SumaDiasDisponibles;
                    }
                   // $response["DiasDisponibles"] = $DiasDisponibles;                
                }//Cierra El For J
    
    
                if($diferenciaDeAnios>"1"){
                    if($SumaDiasDisponibles>"0"){
                    //update a la tabla datos imss en 2 para dani
                        $EstatusFiniquito="2";
                        $negocio -> UpdateDatosImssCampoFiniquito($EstatusFiniquito,$empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId);
                        $response[$i]["datos"] = $EstatusFiniquito;
                        $response[$i]["empleadoEntidadId"] = $empleadoEntidadId;
                        $response[$i]["empleadoConsecutivoId"] = $empleadoConsecutivoId;
                        $response[$i]["empleadoTipoId"] = $empleadoTipoId;
                        $response[$i]["FechaAltaEmpleadoLaborales"] = $FechaAltaEmpleadoLaborales;
                        $response[$i]["status"] = "success";
                        $response[$i]["message"] = "Confirmación finalizada";
                    }else{
                    //update a la tabla datos imss en 1 para Finiquito
                        $EstatusFiniquito="1";
                        $negocio -> UpdateDatosImssCampoFiniquito($EstatusFiniquito,$empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId);
                        $response[$i]["datos"] = $EstatusFiniquito;
                        $response[$i]["empleadoEntidadId"] = $empleadoEntidadId;
                        $response[$i]["empleadoConsecutivoId"] = $empleadoConsecutivoId;
                        $response[$i]["empleadoTipoId"] = $empleadoTipoId;
                        $response[$i]["FechaAltaEmpleadoLaborales"] = $FechaAltaEmpleadoLaborales;
                        $response[$i]["status"] = "success";
                        $response[$i]["message"] = "Confirmación finalizada";
    
                    }
                    
                }else{
                    //update a la tabla datos imss en 1 para Finiquito
                    $EstatusFiniquito="1";
                    $negocio -> UpdateDatosImssCampoFiniquito($EstatusFiniquito,$empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId);
                    $response[$i]["datos"] = $EstatusFiniquito;
                    $response[$i]["empleadoEntidadId"] = $empleadoEntidadId;
                    $response[$i]["empleadoConsecutivoId"] = $empleadoConsecutivoId;
                    $response[$i]["empleadoTipoId"] = $empleadoTipoId;
                    $response[$i]["FechaAltaEmpleadoLaborales"] = $FechaAltaEmpleadoLaborales;
                    $response[$i]["status"] = "success";
                    $response[$i]["message"] = "Confirmación finalizada";
               }
            }//Cierra el if registro patronal
        }//cierra el for  
    }                  
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }
}
else
{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}

echo json_encode ($response);
?>