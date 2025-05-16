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
    $response["datos"] = $datos;
    $response["mensaje"] = "Error al iniciar sesion";
    include ("LoginSuperUsuario/form_LoginSuperUsuario.php");
    echo json_encode($response);
}
