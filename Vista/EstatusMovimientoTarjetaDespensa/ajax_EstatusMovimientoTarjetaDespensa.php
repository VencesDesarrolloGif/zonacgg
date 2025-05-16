<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
//$log = new KLogger ( "ajax_ConsultaPeticionesTurnosCapacitacion.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));
$FechaInicio1           = $_POST["FechaInicio"];
$FechaFin1           = $_POST["FechaFin"];
$FechaInicio = $FechaInicio1." 01:00:00";   
$FechaFin = $FechaFin1." 23:59:59";
try {
    $sql = "SELECT concat(tarjetadespensa.EntidadEmpleadoTarjeta,'-',tarjetadespensa.ConsecutivoEmpleadoTarjeta,'-',tarjetadespensa.TipoEmpleadoTarjeta) as NumeroEmpleadoInt,concat('0000',tarjetadespensa.idMatrizAsiganda) as LuegarEntrega,concat(tarjetadespensa.EntidadEmpleadoTarjeta,tarjetadespensa.ConsecutivoEmpleadoTarjeta,tarjetadespensa.TipoEmpleadoTarjeta) as NumeroEmpleado,empleados.nombreEmpleado as NombreEnTarjeta1,tarjetadespensa.idIutTarjeta as IutTarjeta,empleados.nombreEmpleado as NombreEmpleado, empleados.apellidoPaterno as ApellidoPaterno,empleados.apellidoMaterno as ApelliMaterno,datospersonales.rfcEmpleado as RfcEmpleado,datospersonales.curpEmpleado as CurpEmpleado,empleados.empleadoNumeroSeguroSocial as SeguroEmpleado,directorio.telefonoMovilEmpleado as TelefonoEmpleado,directorio.correoEmpleado as CorreoEmpleado
        from  TarjetaDespensa
        left join empleados ON (empleados.entidadFederativaId=tarjetadespensa.EntidadEmpleadoTarjeta and empleados.empleadoConsecutivoId=tarjetadespensa.ConsecutivoEmpleadoTarjeta and empleados.empleadoCategoriaId=tarjetadespensa.TipoEmpleadoTarjeta)
        left join datospersonales ON (empleados.entidadFederativaId=datospersonales.empleadoEntidadPersonal and empleados.empleadoConsecutivoId=datospersonales.empleadoConsecutivoPersonal and empleados.empleadoCategoriaId=datospersonales.empleadoCategoriaPersonal)
        left join directorio ON (empleados.entidadFederativaId=directorio.entidadEmpleadoDirectorio and empleados.empleadoConsecutivoId=directorio.consecutivoEmpleadoDirectorio and empleados.empleadoCategoriaId=directorio.categoriaEmpleadoDirectorio)
        where idEstatusTarjeta='1'
        and IdEstatusAsignacionEmpleado='1'
        and FechaASignacionEmpleado between '$FechaInicio' and '$FechaFin' ";      
    
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    for($i = 0; $i < count($datos); $i++){
        
        $NombreEnTarjeta1       = $datos[$i]["NombreEnTarjeta1"]; 
        $NombreEnTarjeta = strlen($NombreEnTarjeta1);
        if($NombreEnTarjeta > "20"){
            $datos[$i]["NombreEnTarjeta"]= substr($NombreEnTarjeta1, 0, 20);
        }else{
            $datos[$i]["NombreEnTarjeta"]= $NombreEnTarjeta1;
        } 

    }
    //$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
