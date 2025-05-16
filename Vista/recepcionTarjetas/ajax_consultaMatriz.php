<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
//banderaMatriz$      = $_POST["banderaMatriz"];
$usuario            = $_SESSION ["userLog"]["usuario"];
$datos              = array();
$datos1             = array();
//$log = new KLogger ( "ajax_consultaMatriz.log" , KLogger::DEBUG );
try {

        $sql1 = "SELECT * from asignacionMatriz
                where usuarioAsignacion='$usuario  '";      
        $res1 = mysqli_query($conexion, $sql1);
        while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
            $datos1[] = $reg1;
        }
        $banderaMatriz = count($datos1); 
//$log->LogInfo("Valor de la variable banderaMatriz " . var_export ($banderaMatriz, true));

        if( $banderaMatriz != "0"){
            $IdMatriz = $datos1[0]["IdMatrizAsignacion"];
        }else{
            $IdMatriz = ""; 
        }

//$log->LogInfo("Valor de la variable datos1 " . var_export ($datos1, true));


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
