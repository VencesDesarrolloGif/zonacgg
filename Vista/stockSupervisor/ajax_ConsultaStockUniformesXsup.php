<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$log = new KLogger ( "ajax_ConsultaStockUniformesXsup.log" , KLogger::DEBUG );
$log->LogInfo("Valor de la variable _SESSION " . var_export ($_SESSION, true));
$response           = array();
$response["status"] = "error";
$datos              = array();
$vehiculosXplaca    = array();
$asignacionesVehiculares= array();
$Nosupervisor= $_SESSION["userLog"]["empleadoId"];

    $empleadoidd = explode("-", $Nosupervisor);
    $empleadoEntidad    =$empleadoidd[0];
    $empleadoConsecutivo=$empleadoidd[1];
    $empleadoCategoria  =$empleadoidd[2];
try {
    $sql = "SELECT ctu.codigoUniforme,
                   ctu.descripcionTipo as descUniforme,
                   cantidadUniformeSup
            FROM asignacion_uniforme_Supervisores aus
            LEFT JOIN catalogotiposuniforme ctu ON (aus.claveUniAsignacionSup=ctu.idTipoUniforme)
            WHERE entidadSupAsignacion='$empleadoEntidad'
            AND consecutivoSupAsignacion='$empleadoConsecutivo'
            AND categoriaSupAsignacion='$empleadoCategoria'
            AND EstatusAsignacionASup= '0'"; 
$log->LogInfo("Valor de la variable sql " . var_export ($sql, true));

    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
    }

    
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
