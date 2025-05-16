<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("../libs/phpmailer/class.phpmailer.php");
require_once ("Helpers.php");
require_once "../libs/logger/KLogger.php";
//$log = new KLogger("ajax_EnviarCorreo.log", KLogger::DEBUG);
$negocio            = new Negocio ();
$response           = array();
$response["status"] = "error";
$datos   = array();
$fechainicio = $_POST["fechainicio"];
$fechafin = $_POST["fechafin"];
try {

$datos = $negocio -> ConsultaHistoricoEstatusFiniquito($fechainicio,$fechafin);

 for ($i = 0; $i < count($datos); $i++) {
        $numempleado  = $datos[$i]["numempleado"];        

      $EstatusPrestamo       = $datos[$i]["EstatusPrestamo"];
      $EstatusAmortizacion   = $datos[$i]["EstatusAmortizacion"];
      $EstatusFonacot        = $datos[$i]["EstatusFonacot"];
      $EstatusPension        = $datos[$i]["EstatusPension"];
      $EstatusDiasTrabajados = $datos[$i]["EstatusDiasTrabajados"];
      $EstatusDiasVacaciones = $datos[$i]["EstatusDiasVacaciones"];
      $EstatusNegociacion    = $datos[$i]["EstatusNegociacion"];

      if($EstatusPrestamo>= "1" ){
        $datos[$i]["EstatusPrestamo"] =  "<img title='Cargado' src='img/ok.png' class='cursorImg' width='38'>";
      }else{
         $datos[$i]["EstatusPrestamo"] =  "<img title='No Cargado' src='img/rechazarImss.png' class='cursorImg' width='38'>";
         $datos[$i]["FechaCargaPrest"] =  "<label style='color:red'>     -   </label>";
      }

      if($EstatusAmortizacion>= "1" ){
        $datos[$i]["EstatusAmortizacion"]  =  "<img title='Cargado' src='img/ok.png' class='cursorImg'  width='38'>";
      }else{
         $datos[$i]["EstatusAmortizacion"] =  "<img title='No Cargado' src='img/rechazarImss.png' class='cursorImg' width='38'>";
         $datos[$i]["FechaCargaAmort"]     =  "<label style='color:red'>     -   </label>";
      }

       if($EstatusFonacot>= "1" ){
        $datos[$i]["EstatusFonacot"] =  "<img title='Cargado' src='img/ok.png' class='cursorImg' width='38'>";
      }else{
         $datos[$i]["EstatusFonacot"]=  "<img title='No Cargado' src='img/rechazarImss.png' class='cursorImg' width='38'>";
         $datos[$i]["FechaCargaFona"]=  "<label style='color:red'>     -   </label>";
      }

      if($EstatusPension>= "1" ){
        $datos[$i]["EstatusPension"]  =  "<img title='Cargado' src='img/ok.png' class='cursorImg' width='38'>";
      }else{
         $datos[$i]["EstatusPension"] =  "<img title='No Cargado' src='img/rechazarImss.png' class='cursorImg' width='38'>";
         $datos[$i]["FechaCargaPensi"]=  "<label style='color:red'>     -   </label>";
      }

      if($EstatusDiasTrabajados>= "1" ){
         $datos[$i]["EstatusDiasTrabajados"] =  "<img title='Cargado' src='img/ok.png' class='cursorImg' width='38'>";
      }else{
         $datos[$i]["EstatusDiasTrabajados"]=  "<img title='No Cargado' src='img/rechazarImss.png' class='cursorImg' width='38'>";
         $datos[$i]["FechaCargaDiaTrab"]    =  "<label style='color:red'>     -   </label>";
      }
      
      if(($EstatusDiasVacaciones=="" || $EstatusDiasVacaciones=="NULL" || $EstatusDiasVacaciones=="null" || $EstatusDiasVacaciones==null || $EstatusDiasVacaciones==NULL)){
        $datos[$i]["EstatusDiasVacaciones"] = "<img title='No Cargado' src='img/rechazarImss.png' class='cursorImg' width='38'>";
      }

      if($EstatusNegociacion=="1"){
        $datos[$i]["EstatusNegociacion"] = "<label style='color:red'> En espera de carga de archivos </label>";
      }else{
        $datos[$i]["EstatusNegociacion"] = "<label style='color:green'> En negociación </label>";

      }

    }
      $response["status"] = "success";
      $response["datos"]  = $datos;
      //$log->LogInfo("Valor de la variable numempleado: " . var_export ($numempleado, true));     
      
      } catch (Exception $e) {
          $response["mensaje"] = "Error al iniciar sesion";}

echo json_encode($response);
