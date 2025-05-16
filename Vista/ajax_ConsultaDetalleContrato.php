<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
// $log = new KLogger("consultaDetalleContrato.log", KLogger::DEBUG);
$negocio           = new Negocio ();
$response          = array();
$response["status"]= "error";
$datosContrato     = array();

$cuatrimestre=$_POST['cuatrimestre'];
$anio=$_POST['anio'];
// $log->LogInfo("Valor de la variable _SESSION: " . var_export ($_SESSION, true));

//$log->LogInfo("Valor de la variable cuatrimestre: " . var_export ($cuatrimestre, true));
//$log->LogInfo("Valor de la variable anio: " . var_export ($anio, true));

if($cuatrimestre==1) {
   $fechaInicio= $anio."-01-01";
   $fechaFin= $anio."-04-30";
  }
  else if($cuatrimestre==2) {
   $fechaInicio= $anio."-05-01";
   $fechaFin= $anio."-08-31";
  }
  else if($cuatrimestre==3) {
   $fechaInicio= $anio."-09-01";
   $fechaFin= $anio."-12-31";
  }
   $usuario = $_SESSION['userLog']['usuario'];

try {
    $datosContrato = $negocio -> DetalleContrato($fechaInicio,$fechaFin,$usuario);
    for($i=0; $i < count($datosContrato); $i++) { 

        $idCliente = $datosContrato[$i]["IdClienteC"];
        $empleados = $negocio -> empleadosContrato($idCliente,$fechaInicio,$fechaFin);
        
        $elementosXCuatrimestre= $empleados[0]["elementos"];
        $elementosXmes= $elementosXCuatrimestre/4;

       $datosContrato[$i]["noGuardias"]= round($elementosXmes);
       $datosContrato[$i]["usrActual"] = $_SESSION['userLog']['usuario'];

        $estatusValidacion = $datosContrato[$i]["estatusValidacion"];
        $estatusRevisionPdf = $datosContrato[$i]["estatusRevisionPdf"];
        $idContratoCliente = $datosContrato[$i]["idContratoCliente"];

       if($estatusValidacion==0) {
          $datosContrato[$i]["validacionDC"]  ="<input type='button' onclick=validarContrato(\"".$estatusRevisionPdf."\",\"".$idContratoCliente."\"); style='color: white; background-color: red;' value='VALIDAR';</input>";
       }else{
          $datosContrato[$i]["validacionDC"] ="<a style='color: green';>VALIDADO</a>";
       }


    }
    // $log->LogInfo("Valor de la variable datosContratoFINAL: " . var_export ($datosContrato, true));
    $response["status"] = "success";
    $response["datosContrato"]  = $datosContrato;
}catch (Exception $e) {
    $response["mensaje"]= "Error al iniciar sesion";}
echo json_encode($response);
