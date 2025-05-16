<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio           = new Negocio ();
$response          = array();
$response["status"]= "error";
$datos             = array();
$usuario           = $_SESSION ["userLog"]["usuario"];
$FechaDiaActual = date("Y-m-d");
//$log = new KLogger("ajax_ConsultaFiniquitosNegativos.log", KLogger::DEBUG);
try {
    $datos = $negocio -> obtenerListaFiniquitosNeg();
    for ($i = 0; $i < count($datos); $i++) {
    
    $fechaBajaImss          = $datos[$i]["fechaBajaImss"];
    $fechingresoImss        = $datos[$i]["fechaImss"];
    $netoAlPago             = $datos[$i]["netoAlPago"];      
    $numempleado            = $datos[$i]["numempleado"]; 
    $descripcionPuesto      = $datos[$i]["descripcionPuesto"]; 
    $estatusFiniquito       = $datos[$i]["estatusFiniquito"];       
    $folioBajaImss          = $datos[$i]["folioBajaImss"];
    $entidadFederativaId    = $datos[$i]["entidadFederativaId"];
    $empleadoConsecutivoId  = $datos[$i]["empleadoConsecutivoId"];
    $empleadoCategoriaId    = $datos[$i]["empleadoCategoriaId"];
    $prestamoFiniquito      = $datos[$i]["prestamoFiniquito"]; 
    $uniformesFiniquito     = $datos[$i]["uniformesFiniquito"];

    $netoalpagopositivo = abs($netoAlPago);     
    $netoAlPagocalculado= $netoalpagopositivo +1;
    $Cobertura1 = $negocio -> obtenerCoberturaXEmpLaborales($fechingresoImss,$fechaBajaImss,$entidadFederativaId,$empleadoConsecutivoId,$empleadoCategoriaId);
    $DeudaContabilidad = $prestamoFiniquito - $uniformesFiniquito;

    $datos[$i]["Cobertura"] = $Cobertura1[0]["TOTAL"];
    $datos[$i]["uniformesFiniquito"] = $uniformesFiniquito;
    $datos[$i]["DeudaContabilidad"] = $DeudaContabilidad;
                                                                                  
    $datos[$i]["piramidar1"]="
    <img style='width: 24%' title='Piramidar en 1 peso' src='img/Ok.png' class='cursorImg' id='btnpiramidar1' onclick=btnpiramidarA1('$folioBajaImss','$numempleado','$netoAlPago',$netoAlPagocalculado,'" . $fechaBajaImss . "','" . $fechingresoImss . "')>      
    <img style='width: 24%' title='Insertar monto negociado' src='img/rechazarImss.png' class='cursorImg'  id='btnRechazar' onclick=btninsertarmonto('$numempleado','$netoAlPago')>"; 
    
        if($estatusFiniquito== '0' ){
           $datos[$i]["estatusFiniquito"] = "<label> En espera del monto acordado </label>";

        }if($estatusFiniquito== "4" ){
            $datos[$i]["estatusFiniquito"]= "<label style='color:red'> RECHAZADO POR DIRECCION GENERAL </label>";
        }   
        $diff = abs(strtotime($FechaDiaActual) - strtotime($fechaBajaImss));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        $anios = 365 * $years;
        $meses = 30 * $months;
        $DiasTotales1 = $anios + $meses + $days;
        $DiasTotales = 29-$DiasTotales1;            
        $datos[$i]["DiasTotales"] = $DiasTotales;    
        $datos[$i]["netoAlPagocalculado"] = $netoAlPagocalculado;


        if($DiasTotales <= "0"){
            $DiasTotales2 = abs($DiasTotales);
            $datos[$i]["TiempoPirAuto"] = "<label style='color:red'>Tiempo Excedido Por ".$DiasTotales2." Dias Rializar La Liberación Del Finiquito !!!</label>";
        }else if($DiasTotales <= "5" && $DiasTotales >= "1"){
            $datos[$i]["TiempoPirAuto"] = "<label style='color:red'>Quedan ".$DiasTotales." Dias</label>";
        }else if($DiasTotales > "5" && $DiasTotales <= "10"){
            $datos[$i]["TiempoPirAuto"] = "<label style='color:orange'>Quedan ".$DiasTotales." Dias</label>";
        }else{
            $datos[$i]["TiempoPirAuto"] = "<label style='color:blue'>Quedan ".$DiasTotales." Dias</label>";
        }

    }
//$log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));
    $response["status"] = "success";
    $response["datos"]  = $datos;
} catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);

