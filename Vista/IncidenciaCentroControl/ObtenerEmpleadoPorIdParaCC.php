<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
//$log = new KLogger ( "ObtenerEmpleadoPorIdParaCC.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));

try {
    $NumeroEmpleado = $_POST ["NumeroEmpleado"];
    $sql = "SELECT concat_ws(' ',e.nombreEmpleado,e.apellidoPaterno,e.apellidoMaterno) as NombreEmp,c.descripcionPuesto as Puesto ,c.idPuesto as Idpuesto
            from empleados e
            left join catalogopuestos c ON (e.empleadoIdPuesto=c.idPuesto)
            where concat_ws('-',e.entidadFederativaId,e.empleadoConsecutivoId,e.empleadoCategoriaId) ='$NumeroEmpleado'";     
        //$log->LogInfo("Valor de la variable sql " . var_export ($sql, true));
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    //$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
