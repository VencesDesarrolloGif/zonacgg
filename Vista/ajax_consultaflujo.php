<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
//$log = new KLogger("ajax_ConsultaFlujo.log", KLogger::DEBUG);
//$log->LogInfo("Valor de la variable NombreUsuario: " . var_export ($NombreUsuario, true));
$negocio            = new Negocio ();
$response           = array();
$response["status"] = "error";
$datos              = array();
$usuario               = $_SESSION ["userLog"];
$NombreUsuario         = $_SESSION ["userLog"]["nombre"]; 
$apellidoPaternoUsuario= $_SESSION ["userLog"]["apellidoPaterno"];
$apellidoMaternoUsuario= $_SESSION ["userLog"]["apellidoMaterno"];
try {
    $datos = $negocio -> obtenerflujo($usuario); 
   for ($i = 0; $i < count($datos); $i++) {
        $numempleado             = $datos[$i]["numempleado"];       
        $entidadEmpFiniquito     = $datos[$i]["entidadEmpFiniquito"];
        $consecutivoEmpFiniquito = $datos[$i]["consecutivoEmpFiniquito"];
        $categoriaEmpFiniquito   = $datos[$i]["categoriaEmpFiniquito"];
        $fechaBaja               = $datos[$i]["fechaBaja"];
        $descripcionLineaNegocio = $datos[$i]["descripcionLineaNegocio"];
        $netoAlPago              = $datos[$i]["netoAlPago"];
        $diasDeVacaciones        = $datos[$i]["diasDeVacaciones"]; 
        $prestamo1               = $negocio -> Amortizaciones($entidadEmpFiniquito,$consecutivoEmpFiniquito,$categoriaEmpFiniquito,$fechaBaja,"1");
        $infonavit1              = $negocio -> Amortizaciones($entidadEmpFiniquito,$consecutivoEmpFiniquito,$categoriaEmpFiniquito,$fechaBaja,"2");
        $pension1                = $negocio -> Amortizaciones($entidadEmpFiniquito,$consecutivoEmpFiniquito,$categoriaEmpFiniquito,$fechaBaja,"3");
        $fonacot1                = $negocio -> Amortizaciones($entidadEmpFiniquito,$consecutivoEmpFiniquito,$categoriaEmpFiniquito,$fechaBaja,"4");
        $Diastrabajados1         = $negocio -> Amortizaciones($entidadEmpFiniquito,$consecutivoEmpFiniquito,$categoriaEmpFiniquito,$fechaBaja,"5");    
        $Uniformesentregados1    = $negocio -> Amortizaciones($entidadEmpFiniquito,$consecutivoEmpFiniquito,$categoriaEmpFiniquito,$fechaBaja,"6");    
        $prestamo                = $prestamo1["0"]["Prestamo"];
        $infonavit               = $infonavit1["0"]["Infonavit"];
        $pension                 = $pension1["0"]["Pension"];
        $fonacot                 = $fonacot1["0"]["Fonacot"];
        $diastrabajados          = $Diastrabajados1["0"]["DíasTrabajados"];
        $Uniformesentregados     = $Uniformesentregados1["0"]["Uniformesentregados"];

      
    if($diasDeVacaciones == NULL || $diasDeVacaciones == "NULL"|| $diasDeVacaciones == null || $diasDeVacaciones == "null" || $diasDeVacaciones == ""){
        $datos[$i]["diasDeVacaciones"]   = "<img style='width: 30%'title='Vacacones no cargadas' src='img/rechazarImss.png' class='cursorImg' id='imgPrestamoCargado' >";
        $datos[$i]["prestamoFiniquito"]  = "<label> En espera de vacaciones </label>";
        $datos[$i]["infonavitFiniquito"] = "<label> En espera de vacaciones </label>";
        $datos[$i]["fonacotFiniquito"]   = "<label> En espera de vacaciones </label>";
        $datos[$i]["pensionFiniquito"]   = "<label> En espera de vacaciones </label>";
        $datos[$i]["diastrabFiniquito"]  = "<label> En espera de vacaciones </label>";        
        $datos[$i]["prestamoFecha"]      = "<label> En espera de vacaciones </label>";
        $datos[$i]["infonavitFecha"]     = "<label> En espera de vacaciones </label>";
        $datos[$i]["fonacotFecha"]       = "<label> En espera de vacaciones </label>";
        $datos[$i]["pensioFecha"]        = "<label> En espera de vacaciones </label>";
        $datos[$i]["diastrabFecha"]      = "<label> En espera de vacaciones </label>";
        $datos[$i]["netoalpagoflujo"]    = "<label> En espera de vacaciones </label>";
        $datos[$i]["EstatusNegociacion"] = "<label> En espera de vacaciones </label>";
        $datos[$i]["UniformesFiniquito"] = "<label> En espera de vacaciones </label>";
        $datos[$i]["UniformesFecha"]     = "<label> En espera de vacaciones </label>";
        $datos[$i]["prestamo"]           = $prestamo;
        $datos[$i]["infonavit"]          = $infonavit;
        $datos[$i]["fonacot"]            = $fonacot;
        $datos[$i]["pension"]            = $pension;
        $datos[$i]["diastrabajados"]     = $diastrabajados;
        $datos[$i]["Uniformesentregados"]= $Uniformesentregados;
      }else
        {
            $datos[$i]["diasDeVacaciones"]   = "<img style='width: 30%'title='Dias de vacaciones cargados' src='img/Ok-icon1.png' class='cursorImg'   id='imgPrestamoCargado' >";   
           
             if($prestamo == '0' ){
               $datos[$i]["prestamoFiniquito"]   = "<img style='width: 30%'title='Prestamo No Cargado' src='img/rechazarImss.png' class='cursorImg'   id='imgPrestamoNoCargado' >";
               $datos[$i]["prestamoFecha"]       = "No Cargado";
               $datos[$i]["prestamo"]            = $prestamo;
             }else{
               $datos[$i]["prestamoFiniquito"]   = "<img style='width: 30%'title='Prestamo Cargado' src='img/Ok-icon1.png' class='cursorImg'   id='imgPrestamoCargado' >";
               $datos[$i]["prestamoFecha"]       = $prestamo1["0"]["FechaHoraCarga"];
               $datos[$i]["prestamo"]            = $prestamo;
             }
            
             if($infonavit == '0' ){
               $datos[$i]["infonavitFiniquito"]   = "<img style='width: 20%'title='Amortizaciones No Cargadas' src='img/rechazarImss.png' class='cursorImg'   id='imginfonavitNoCargado' >";
               $datos[$i]["infonavitFecha"]       = "No Cargado";
               $datos[$i]["infonavit"]            = $infonavit;
             }else{
               $datos[$i]["infonavitFiniquito"]   = "<img style='width:20%'title='Amortizaciones Cargadas' src='img/Ok-icon1.png' class='cursorImg'   id='imginfonavitCargado' >";
               $datos[$i]["infonavitFecha"]       = $infonavit1["0"]["FechaHoraCarga"];
               $datos[$i]["infonavit"]            = $infonavit;
             }
            
             if($fonacot == '0' ){
               $datos[$i]["fonacotFiniquito"]   = "<img style='width: 35%'title='Fonacot No Cargado' src='img/rechazarImss.png' class='cursorImg'   id='imgfonacotNoCargado' >";
               $datos[$i]["fonacotFecha"]       = "No Cargado";
               $datos[$i]["fonacot"]            = $fonacot;
             }else{
               $datos[$i]["fonacotFiniquito"]   = "<img style='width: 35%'title='Fonacot Cargado' src='img/Ok-icon1.png' class='cursorImg'   id='imgimgfonacotCargado' >";
               $datos[$i]["fonacotFecha"]       = $fonacot1["0"]["FechaHoraCarga"];
               $datos[$i]["fonacot"]            = $fonacot;
             }
            
             if($pension == '0' ){
               $datos[$i]["pensionFiniquito"]   = "<img style='width: 25%'title='Pension No Cargada' src='img/rechazarImss.png' class='cursorImg'   id='imgpensionNoCargado' >";
               $datos[$i]["pensioFecha"]        = "No Cargado";
               $datos[$i]["pension"]            = $pension;
             }else{
               $datos[$i]["pensionFiniquito"]   = "<img style='width: 25%'title='Pension Cargada' src='img/Ok-icon1.png' class='cursorImg'   id='imgpensionCargado' >";
               $datos[$i]["pensioFecha"]        = $pension1["0"]["FechaHoraCarga"];
               $datos[$i]["pension"]            = $pension;            
             }
            
             if($diastrabajados == '0' ){
               $datos[$i]["diastrabFiniquito"]   = "<img style='width: 30%'title='Dias Trabajados No Cargados' src='img/rechazarImss.png' class='cursorImg'   id='imgDiasTrabNoCargado' >";
               $datos[$i]["diastrabFecha"]       = "No Cargado";
               $datos[$i]["diastrabajados"]      = $diastrabajados;
             }else{
               $datos[$i]["diastrabFiniquito"]   = "<img style='width: 30%'title='Dias Trabajados Cargados' src='img/Ok-icon1.png' class='cursorImg'   id='imgDiasTrabCargado' >";
               $datos[$i]["diastrabFecha"]       = $Diastrabajados1["0"]["FechaHoraCarga"];
               $datos[$i]["diastrabajados"]      = $diastrabajados;
             }

             if($Uniformesentregados == '0' ){
               $datos[$i]["UniformesFiniquito"]   = "<img style='width: 30%'title='Uniformes No Cargados' src='img/rechazarImss.png' class='cursorImg'   id='imgDiasTrabNoCargado' >";
               $datos[$i]["UniformesFecha"]       = "No Cargado";
               $datos[$i]["Uniformesentregados"]      = $Uniformesentregados;
             }else{
               $datos[$i]["UniformesFiniquito"]   = "<img style='width: 30%'title='Uniformes Cargados' src='img/Ok-icon1.png' class='cursorImg'   id='imgDiasTrabCargado' >";
               $datos[$i]["UniformesFecha"]       = $Uniformesentregados1["0"]["FechaHoraCarga"];
               $datos[$i]["Uniformesentregados"]      = $Uniformesentregados;
             }
            
             if ($prestamo == '0' || $infonavit == '0' || $fonacot == '0' || $pension == '0' || $diastrabajados == '0' || $Uniformesentregados == "0") { 
            
                 $datos[$i]["netoalpagoflujo"]    = "<img style='width: 30%'title='Esperando carga de archivos' src='img/Ok-icon1.png' class='cursorImg'   id='imgDiasTrabCargado'>";
                 $datos[$i]["EstatusNegociacion"] = "<label style='color:orange'> Esperando carga de archivos</label>";
             }else{
              if('0'<$netoAlPago){
                $datos[$i]["netoalpagoflujo"]    = "<img style='width: 30%'title='No aplica negociacion' src='img/Ok-icon1.png' class='cursorImg'   id='imgDiasTrabCargado'>";
                $datos[$i]["EstatusNegociacion"] = "<label style='color:green'> NO APLICA </label>";   
              }else{
                $datos[$i]["netoalpagoflujo"]    = "<img style='width: 30%'title='En proceso de negociación' src='img/rechazarImss.png' class='cursorImg'   id='imgDiasTrabNoCargado' >";
                $datos[$i]["EstatusNegociacion"] = "<label style='color:red'> EN PROCESO DE NEGOCIACIÓN</label>"; 
              }
            }   
        }
    }  
    $response["status"] = "success";
    $response["datos"]  = $datos;
} catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
