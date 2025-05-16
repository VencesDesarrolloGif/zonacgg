<?php
session_start();
require_once("../../libs/logger/KLogger.php");
require "../conexion.php"; 
require_once ("../../Negocio/Negocio.class.php");
require_once ("../Helpers.php");
$negocio = new Negocio ();
verificarInicioSesion ($negocio);
// $log=new KLogger("ajax_ConsultaRegionEntidadXusuario.log", KLogger::DEBUG);
// $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));     
$response = array();
$regiones = array();
$entidades= array();
$entidadSupervisor = array();
$response["status"] = "error";

$rol = $_SESSION["userLog"]["rol"];
$entidad = $_SESSION["userLog"]["entidadFederativaUsuario"][0];
$linea=$_POST['lineaNegoElegida'];
// $log->LogInfo("Valor de la variable linea: " . var_export ($linea, true));     

if($rol=="Direccion General" || $rol=="Contrataciones" || $rol=="Centro De Control" || $rol=="Direccion De Operaciones"){
   
   $sql0 = "SELECT DISTINCT idregioni,UPPER(DescripcionI) AS DescripcionI
            FROM index_regiones
            WHERE idLineaNegI='$linea'
            ORDER BY DescripcionI";

   $res0 = mysqli_query($conexion, $sql0);
          while ($reg0 = mysqli_fetch_array($res0, MYSQLI_ASSOC)) {
          $regiones[] = $reg0;
   }
// $log->LogInfo("Valor de la variable sql0: " . var_export ($sql0, true));     
   
   $response["datos"] = $regiones;
   $response["tipo"]  = '1';

}else if($rol=="Supervisor"){
         $response["tipo"]  = '2';
}

else if($rol=="Gerente Regional"){

         $sql0 = "SELECT DISTINCT idregioni,UPPER(DescripcionI) AS DescripcionI
                  FROM index_regiones
                  WHERE idLineaNegI='$linea'
                  and idEntidadI='$entidad'
                  ORDER BY DescripcionI";

         $res0 = mysqli_query($conexion, $sql0);
                while ($reg0 = mysqli_fetch_array($res0, MYSQLI_ASSOC)) {
                $regiones[] = $reg0;
         }
         
         $response["datos"]  = $regiones;
         $response["tipo"]  = '3';

         $region= $regiones[0]["idregioni"];

         $sql1 = "SELECT ef.idEntidadFederativa,UPPER(ef.nombreEntidadFederativa)  AS nombreEntidadFederativa 
            FROM index_regiones ir
            LEFT JOIN entidadesfederativas ef on ef.idEntidadFederativa=ir.idEntidadI
            WHERE ir.idLineaNegI=$linea
            AND ir.idRegionI=$region
            AND ef.idEntidadFederativa!='33' 
            AND ef.idEntidadFederativa!='50 '
            ORDER BY ef.nombreEntidadFederativa";

         $res1 = mysqli_query($conexion, $sql1);
                while ($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC)) {
                $entidades[] = $reg1;
         }

         $response["entidades"]  = $entidades;

}
$response["status"] = "success";
echo json_encode($response);
