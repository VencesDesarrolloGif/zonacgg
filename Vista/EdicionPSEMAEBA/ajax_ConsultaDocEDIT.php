<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response = array();
$datos  = array();
$response["status"] = "error";
$anio= $_POST['anio'];
$mes = $_POST['mes'];
$registroPatronal = $_POST['regPat'];
$opcion = $_POST['opcion'];
// $log = new KLogger ( "ajax_ConsultaDocEDIT.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de variable _POST" . var_export ($_POST, true));

try {
   if ($opcion=='1'){
      $nombreCampoMes="mesPuntoSUA";
      $nombreCampoAnio="anioPuntoSUA";
      $nombreCampoRP="regPatronalPuntoSUA";

      $sql = "SELECT idPuntoSUA AS idDocumento,nombreDocPuntoSUA AS nombreDocumento
               FROM catalogoPuntoSUA
               WHERE estatusDocPuntoSUA='1'
               AND mesPuntoSUA ='$mes'
               AND anioPuntoSUA='$anio'
               AND regPatronalPuntoSUA='$registroPatronal'";
   }
   if ($opcion=='2'){
      $nombrearchivo='IDSE_EMA_'.$registroPatronal.'_'.$mes.$anio.'.pdf';

      $sql = "SELECT idArchivoIDSEEMA AS idDocumento ,NombreArchivoIDSEEMA as nombreDocumento 
                FROM IDSE_EMA
                WHERE NombreArchivoIDSEEMA LIKE '%$nombrearchivo%'
                ORDER BY idArchivoIDSEEMA DESC
                LIMIT 1";

   }
   if ($opcion=='3'){
      $nombrearchivo='IDSE_EBA_'.$registroPatronal.'_'.$mes.$anio.'.pdf';

      $sql = "SELECT idArchivoIDSEEBA AS idDocumento, NombreArchivoIDSEEBA  as nombreDocumento 
                FROM IDSE_EBA
                WHERE NombreArchivoIDSEEBA LIKE '%$nombrearchivo%'
                ORDER BY idArchivoIDSEEBA DESC
                LIMIT 1";
   }
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