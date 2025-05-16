<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
// $log = new KLogger ( "ajax_consultaCOnfirmacionVacaciones.log" , KLogger::DEBUG );
$usuario=$_SESSION["userLog"];
$fechaInicioDiasVacacionesLab=$_POST["fechaInicioDiasVacacionesLab"];
$fechaTerminoDisasVacacionesLab=$_POST["fechaTerminoDisasVacacionesLab"];
$caso=$_POST["caso"];
try {
	$listaConfirmacionDiasDeVacaciones   = $negocio->getListaConfirmacionVacacionesFini($fechaInicioDiasVacacionesLab,$fechaTerminoDisasVacacionesLab,$caso);
    //$log->LogInfo("Valor de la variable listaConfirmacionDiasDeVacaciones: " . var_export ($listaConfirmacionDiasDeVacaciones, true));
	for($i=0;$i<count($listaConfirmacionDiasDeVacaciones);$i++){
			
        $SumaDiasDisponibles="0";
        $UltimoAniversario="0";
        $empleadoEntidadId = $listaConfirmacionDiasDeVacaciones[$i]["entidadEmpFiniquito"];
        $empleadoConsecutivoId = $listaConfirmacionDiasDeVacaciones[$i]["consecutivoEmpFiniquito"];
        $empleadoTipoId = $listaConfirmacionDiasDeVacaciones[$i]["categoriaEmpFiniquito"];
        $folioBajaImss = $listaConfirmacionDiasDeVacaciones[$i]["folioBajaImss"];
        $FechaBaja=$listaConfirmacionDiasDeVacaciones[$i]["fechaBajaImss"];
        $ExplodeFechaBaja = explode("-", $FechaBaja);
        $anio2 = $ExplodeFechaBaja[0];
        $mes2 = $ExplodeFechaBaja[1];
        $dia2 = $ExplodeFechaBaja[2];
   // $log->LogInfo("Valor de la variable empleadoTipoId: " . var_export ($empleadoTipoId, true));
        $FechaAltaEmpleadoImss=$listaConfirmacionDiasDeVacaciones[$i]["FechaAltaImss"];
        $FechaimssExplode = explode("-", $FechaAltaEmpleadoImss);
        $AnioAltaImss = $FechaimssExplode[0];

        $SieteDIas="7";
        $FechaAltaEmpleadoEmp1=$listaConfirmacionDiasDeVacaciones[$i]["FechaAltaEmpleados"];
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
        $FechaExplode1 = explode("-", $FechaAltaEmpleado);
        $FechaAltaMasAniversario0 = strtotime ('-1 year' , strtotime($FechaAltaEmpleado)); //Se añade un año menos
        $FechaAltaMasAniversario0 = date ('Y-m-d',$FechaAltaMasAniversario0);// Se da formato a la fecha
        $FechaA = new DateTime($FechaAltaMasAniversario0);
        $FechaB = new DateTime($FechaBaja);
        $fechasdifer = $FechaA->diff($FechaB);
        $DiasDiferencia = $fechasdifer->format('%R%a');
        $DiasDiferenciaParaDivison = substr($DiasDiferencia, 1);
        $DiasDiferenciaParaDivison1 = (int) $DiasDiferenciaParaDivison;
        $DiasDiferenciaParaDivison2 = $DiasDiferenciaParaDivison1/365;
        $DiasDiferenciaParaDivison3 = explode(".", $DiasDiferenciaParaDivison2);
        $diferenciaDeAnios = $DiasDiferenciaParaDivison3[0];
        for($j=0; $j<$diferenciaDeAnios+1;$j++){
            $Aniversario = $j; 
            $AniversarioAnts= $Aniversario-1;
            $DiasVacacionesTomadas   = $negocio->ObtenerTotalDeDiasVacaciones($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$Aniversario);//Dias De Vacaciones Tomadas
            if($Aniversario=="0"){
                $DiasAniversario1   = $negocio->ObtenerDiasCorrespondientesAOtrasEmpresas($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId);// Dias Que Le Corresponden Por El Aniversario 0 ingresados vacaciones la tabla de  dias vacaciones vacaciones empresas  
                $DiasAniversario0 = $DiasAniversario1[0]["DiasTotalesVacaciones"];  
                if($DiasAniversario0 =="" || $DiasAniversario0==null || $DiasAniversario0=="null" || $DiasAniversario0==NULL || $DiasAniversario0=="NULL"){
                    $DiasAniversario = "0";
                }else{
                    $DiasAniversario = $DiasAniversario0;
                }
            }else{
                $DiasAniversario   = $negocio->ObtenerDiasCorrespondientesALAniversario($Aniversario);// Dias Que Le Corresponden Por El Aniversario
                $DiasAniversario = $DiasAniversario[0]["DiasAniversario"]; 
            }
            $FechaUno = strtotime ('+'.$AniversarioAnts.' year' , strtotime($FechaAltaEmpleado)); //Se añade un año mas
            $FechaUno = date ('Y-m-d',$FechaUno);// Se da formato a la fecha
            $FechaDos = strtotime ('+'.$Aniversario.' year' , strtotime($FechaAltaEmpleado)); //Se añade un año mas
            $FechaDos = date ('Y-m-d',$FechaDos);// Se da formato a la fecha

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

            $TotalDeDiasVacaciones = $DiasVacacionesTomadas[0]["TotalDeDiasVacaciones1"];
            $RestaDias = $DiasAniversario-$TotalDeDiasVacaciones;
            if($FechaDos>$FechaBaja){
                $datetime1 = new DateTime($FechaUno);
                $datetime2 = new DateTime($FechaBaja);
                $diastrabajados = $datetime1->diff($datetime2);
                $dtstr = $diastrabajados->format('%R%a');
                $dtstring = substr($dtstr, 1);
                $antiguedadUltimoAniversario = (int) $dtstring;
                $DiasDisponiblesTotal = (($antiguedadUltimoAniversario/365)*$DiasAniversario);
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
            if($j<$diferenciaDeAnios){
                $SumaDiasDisponibles=$DiasDisponibles+$SumaDiasDisponibles; 
            }else{
            	$UltimoAniversario = $DiasDisponibles;
            }
               // $response["DiasDisponibles"] = $DiasDisponibles;                
        }
        $listaConfirmacionDiasDeVacaciones[$i]["AniversariosPasados"] = $SumaDiasDisponibles;
        $listaConfirmacionDiasDeVacaciones[$i]["Ultimoaniversario"] = $UltimoAniversario;
        $listaConfirmacionDiasDeVacaciones[$i]["TotalAniversarios"] = $SumaDiasDisponibles + $UltimoAniversario;
        $listaConfirmacionDiasDeVacaciones[$i]["NumeroEmpleado"] = $empleadoEntidadId ."-". $empleadoConsecutivoId ."-". $empleadoTipoId;
        $SumaTotalDias= $SumaDiasDisponibles + $UltimoAniversario;
        $OpcionAceptar="1";
        $OpcionDeclinar="2";
        $OpcionEditar="3";
        $variable0="0";
        
        $listaConfirmacionDiasDeVacaciones[$i]["Confirmar"]="<img title='Confirmar(Se Confirmará El Total Dias Aniversario)' src='img/confirmarImss.png' class='cursorImg' id='btnConfirmar' onclick=ConfirmarRechazarEditarDiasVacacionesFiniquito('".$empleadoEntidadId."','".$empleadoConsecutivoId."','".$empleadoTipoId."','".$SumaTotalDias."','".$OpcionAceptar."','".$folioBajaImss."') >";

        $listaConfirmacionDiasDeVacaciones[$i]["Rechazar"]="<img title='Declinar (Se Confirmará Dias Ultimo Aniversario)' src='img/rechazarImss.png' class='cursorImg' id='btnRechazar' onclick=ConfirmarRechazarEditarDiasVacacionesFiniquito('".$empleadoEntidadId."','".$empleadoConsecutivoId."','".$empleadoTipoId."','".$UltimoAniversario."','".$OpcionDeclinar."','".$folioBajaImss."') >";

        $listaConfirmacionDiasDeVacaciones[$i]["Editar"]="<img title='Editar Dias a Confirmar' src='img/edit.png' class='cursorImg' id='btnEditar' onclick=EditarDiasVacacionesFiniquito('".$empleadoEntidadId."','".$empleadoConsecutivoId."','".$empleadoTipoId."','".$SumaTotalDias."','".$OpcionEditar."','".$folioBajaImss."','".$UltimoAniversario."') >";
    }  
$response["datos"]=$listaConfirmacionDiasDeVacaciones;
} catch (Exception $e) {
	$response["status"] = "error";
	$response["error"]  = "No Se Obtuvieron Datos";
}
// $log->LogInfo("Valor de la variable response: " . var_export ($response, true));
echo json_encode($response);
