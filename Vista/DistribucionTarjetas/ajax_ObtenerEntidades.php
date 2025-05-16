<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$IdMatriz           = $_POST["IdMatriz"];
$banderaMatriz      = $_POST["banderaMatriz"];
$usuario             = $_SESSION ["userLog"]["usuario"];
$datos              = array();
//$log = new KLogger ( "ajax_ObtenerEntidades.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _SESSION " . var_export ($_SESSION, true));
try {
    if($banderaMatriz != "0"){
        $sql = "SELECT * from matricesentidades
                where IdMatrizPrincipal='$IdMatriz'
                and EstatusEntidadesMatriz='1'";      
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    }else{

        $sql = "SELECT * from asignacionMatriz
                left join matricesentidades on (asignacionMatriz.IdMatrizAsignacion=matricesentidades.IdMatrizPrincipal)
                where asignacionMatriz.estatusAsigacionMatriz='1'
                and matricesentidades.EstatusEntidadesMatriz='1'
                and ";      
        
        for($i=0;$i<count($_SESSION ["userLog"]["entidadFederativaUsuario"]);$i++){
            if(!is_array($_SESSION ["userLog"]["entidadFederativaUsuario"])){
                $entidadparaconsulta=$_SESSION ["userLog"]["entidadFederativaUsuario"];
            }else{
                $entidadparaconsulta=$_SESSION ["userLog"]["entidadFederativaUsuario"][$i];
            }  
            if($i==0){
                $sql.=" ((matricesentidades.IdEntidadAsignada='$entidadparaconsulta')";    
            }else{
                $sql.=" or (matricesentidades.IdEntidadAsignada='$entidadparaconsulta')";       
            }
        }
        $sql.=") order by IdEntidadAsignada";
      //  $log->LogInfo("Ejecutando matricesEntidades  insert: " . $sql); 
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    }
    
//$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));

    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al Obtener Matrices";}
echo json_encode($response);
