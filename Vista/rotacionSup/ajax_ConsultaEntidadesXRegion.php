<?php
session_start();
require "../conexion.php"; 
require_once("../../libs/logger/KLogger.php");
if (!isset($_SESSION["userLog"])) {
    header ("Location: https://zonagifseguridad.com.mx//zonagif/Vista/LoginSuperUsuario/form_LoginSuperUsuario.php");
    exit;
}
// $log=new KLogger("ajax_ConsultaEntidadesXRegion.log", KLogger::DEBUG);
// $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));     
// $log->LogInfo("Valor de la variable sql0: " . var_export ($sql0, true));     
$response = array();
$entidades = array();
$response["status"] = "error";
$region=$_POST['region'];
$linea=$_POST['lineaNegoElegida'];

   $sql0 = "SELECT ef.idEntidadFederativa,UPPER(ef.nombreEntidadFederativa)  AS nombreEntidadFederativa 
            FROM index_regiones ir
            LEFT JOIN entidadesfederativas ef on ef.idEntidadFederativa=ir.idEntidadI
            WHERE ir.idLineaNegI=$linea
            AND ir.idRegionI=$region
            AND ef.idEntidadFederativa!='33' 
            AND ef.idEntidadFederativa!='50 '
            ORDER BY ef.nombreEntidadFederativa";

   $res0 = mysqli_query($conexion, $sql0);
          while ($reg0 = mysqli_fetch_array($res0, MYSQLI_ASSOC)) {
          $entidades[] = $reg0;
   }
   
$response["datos"] = $entidades;
$response["status"] = "success";
echo json_encode($response);
