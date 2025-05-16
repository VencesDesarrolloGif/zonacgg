<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
require_once ("../../Negocio/Negocio.class.php");
require_once ("../Helpers.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
 // $log = new KLogger ( "ajax_VerifiacerIngresoSuperUsuario.log" , KLogger::DEBUG );
 // $log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));
if (!empty ($_POST))
{
    $idARevisar = $_POST ["idARevisar"];

    $sql1 = "SELECT count(ipIngresadaTempS) as TotalIp
            from ingresosuperusuariotemp
            where ipIngresadaTempS='$idARevisar'"; 
    $res1 = mysqli_query($conexion, $sql1);
    while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
        $datos1[] = $reg1;
    }
    $TotalIp1 = $datos1[0]["TotalIp"];
    if($TotalIp1 ==='1'){

        $sql = "SELECT * from IngresoSuperUsuarioTemp
            where ipIngresadaTempS='$idARevisar'";     
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
        $response["status"]= "success";
        $response["datos"] = $datos;
        echo json_encode($response);
    }else{
        $sql2 = "truncate ingresosuperusuariotemp";     
            $res2 = mysqli_query($conexion, $sql2);  
        $response["datos"] = $datos;
        $response["status"]= "error";
        $response["mensaje"] = "Error duplicidad de ip";
        echo json_encode($response);
    }
}else{
    $response["datos"] = $datos;
    $response["mensaje"] = "Error al iniciar sesion";
    include ("LoginSuperUsuario/form_LoginSuperUsuario.php");
    echo json_encode($response);
}
