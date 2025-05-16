<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
//$log = new KLogger ( "ajax_ConsultaEmpleadoParaCrearSuperUsuario.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));

try {
    $NumeroEmpleado = $_POST ["NumeroEmpleado"];
    $sql = "SELECT concat_ws('-',e.entidadFederativaId,e.empleadoConsecutivoId,e.empleadoCategoriaId) as NumeroEmpleado,concat_ws(' ',e.apellidoPaterno,e.apellidoMaterno,e.nombreEmpleado) as NombreEmpleado,e.fechaIngresoEmpleado as FechaIngreso,cp.descripcionPuesto as Puesto,ifnull(su.idSuperUsuario,0) as idSuperUsuario,su.UsuarioS as Usuario,su.contraseniaS as Contrasenia,su.EstatusSuperU
        from empleados e
        left join catalogopuestos cp ON(e.empleadoIdPuesto=cp.idPuesto)
        LEFT JOIN SuperUsuarios su  ON(e.entidadFederativaId=su.empleadoEntidadSuperU AND e.empleadoConsecutivoId=su.empleadoConsecutivoSuperU AND e.empleadoCategoriaId = su.empleadoCategoriaSuperU)
        where concat_ws('-',e.entidadFederativaId,e.empleadoConsecutivoId,e.empleadoCategoriaId)='$NumeroEmpleado'";     
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
