<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response = array();
$datos  = array();
$response["status"] = "error";
$anio= $_POST['anio'];
$mes = $_POST['mes'];
$opcion = $_POST['opcion'];
// $log = new KLogger ( "ajax_ConsultaDocSAT.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de variable _POST" . var_export ($_POST, true));

try {
   if ($opcion=='1'){
      $nombretabla="catalogoDeclaracionISR";
      $idDocConsulta="idDecISR";
      $nombreDocConsulta="nombreDocDecISR";
      $nombreCampoMes="mesDecISR";
      $nombreCampoAnio="anioDecISR";
      $estatus="estatusDecISR";
   }
   if ($opcion=='2'){
      $nombretabla="catalogoDeclaracionIVA";
      $idDocConsulta="idDecIVA";
      $nombreDocConsulta="nombreDocDecIVA";
      $nombreCampoMes="mesDecIVA";
      $nombreCampoAnio="anioDecIVA";
      $estatus="estatusDecIVA";
   }
   if ($opcion=='3'){
      $nombretabla="catalogoPagosISR";
      $idDocConsulta="idPagoISR";
      $nombreDocConsulta="nombreDocPagoISR";
      $nombreCampoMes="mesPagoISR";
      $nombreCampoAnio="anioPagoISR";
      $estatus="estatusDocPagoISR";
   }
   if ($opcion=='4'){
      $nombretabla="catalogoPagosIVA";
      $idDocConsulta="idPagoIVA";
      $nombreDocConsulta="nombreDocPagoIVA";
      $nombreCampoMes="mesPagoIVA";
      $nombreCampoAnio="anioPagoIVA";
      $estatus="estatusDocPagoIVA";
   }
   if ($opcion=='5'){
      $nombretabla="catalogoOpinionSAT";
      $idDocConsulta="idOpinionSAT";
      $nombreDocConsulta="nombreDocOpinionSAT";
      $nombreCampoMes="mesOpinionSAT";
      $nombreCampoAnio="anioOpinionSAT";
      $estatus="estatusDocOpinionSAT";
   }
   if ($opcion=='6'){
      $nombretabla="catalogoConstanciaSituacionFiscal";
      $idDocConsulta="idConstanciaSitFis";
      $nombreDocConsulta="nombreDocConstanciaSitFis";
      $nombreCampoMes="mesConstanciaSitFis";
      $nombreCampoAnio="anioConstanciaSitFis";
      $estatus="estatusDocConstanciaSitFis";
   }
   if ($opcion=='7'){
      $nombretabla="catalogoAFFIDAVIT";
      $idDocConsulta="idAFFIDAVIT";
      $nombreDocConsulta="nombreDocAFFIDAVIT";
      $nombreCampoMes="mesAFFIDAVIT";
      $nombreCampoAnio="anioAFFIDAVIT";
      $estatus="estatusDocAFFIDAVIT";
   }
      $sql = "SELECT $idDocConsulta AS idDocumento,$nombreDocConsulta AS nombreDocumento
               FROM $nombretabla
               WHERE $estatus='1'
               AND $nombreCampoMes ='$mes'
               AND $nombreCampoAnio='$anio'";
// $log->LogInfo("Valor de variable sql" . var_export ($sql, true));
      $res = mysqli_query($conexion, $sql);
         while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
                $datos[] = $reg;
         }
      
      $response["status"] = "success";
      $response["datos"]  = $datos;

 }catch (Exception $e) {
    $response["mensaje"] = "Error al consultar documento SAT";
	}
echo json_encode($response);