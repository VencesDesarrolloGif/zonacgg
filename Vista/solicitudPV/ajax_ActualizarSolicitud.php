<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response    = array();
$idAsignacion= array();
$datosActualesVehiculo= array();
$response["status"] = "error";
$idSolicitudVehiculo=$_POST['idSolicitudVehiculo'];
$tipoAsignacion=$_POST['tipoAsignacion'];
$idvehiculo=$_POST['idvehiculo'];
$placaSolicitudSup=$_POST['placaSolicitudSup'];
$entidadEmpleadoUsuario=$_POST['entidadEmpleadoUsuario'];
$consecutivoEmpleadoUsuario=$_POST['consecutivoEmpleadoUsuario'];
$categoriaEmpleadoUsuario=$_POST['categoriaEmpleadoUsuario'];
$idEntidadTrabajo=$_POST['idEntidadTrabajo'];
$empleadoEstatusId=$_POST['empleadoEstatusId'];
$descripcionPuesto=$_POST['descripcionPuesto'];
$numlicencia=$_POST['numlicencia'];
$kilometraje=$_POST['kmSolicitudSup'];
$usuario = $_SESSION ["userLog"]["usuario"];
// $log = new KLogger ( "ajax_ActualizarSolicitud.log" , KLogger::DEBUG );

try {
    $sql = "UPDATE solicitudesvehiculosupervisor
            SET estatusSolicitud='2',
                fechaAceptacionSolicitud=now(),
                usuarioAceptaSolicitud='$usuario'
            WHERE idSolicitudVehiculo='$idSolicitudVehiculo'";   
    $res = mysqli_query($conexion, $sql);
    // $log->LogInfo("Valor de la variable sql " . var_export ($sql, true));
////////////////////////////////////////////////////////////////////////
    $sql1 = "SELECT MAX(idAsignacionC)+1 AS siguienteId
             FROM asignacionesparquevehicular";

    $res1 = mysqli_query($conexion, $sql1);
    // $log->LogInfo("Valor de la variable sql1 " . var_export ($sql1, true));
    while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
            $idAsignacion[] = $reg1;
    }
    $idSiguiente=$idAsignacion[0]["siguienteId"];
////////////////////////////////////////////////////////////////////////

    if ($tipoAsignacion==1){//el vehiculo existe pero no estaba asignado

        $sql2 = "INSERT INTO asignacionesparquevehicular(idAsignacionC,
                                                         idvehiculoC,
                                                         NumeroPlacaC,
                                                         entidadFederativaIdC,
                                                         empleadoConsecutivoIdC,
                                                         empleadoCategoriaIdC,
                                                         idEntidadTrabajoC,
                                                         empleadoEstatusIdC,
                                                         PuestoEmpleadoC,
                                                         NumeroLicenciaC,
                                                         KilometrajeC,
                                                         MotivodeCambioC,
                                                         FechaAsignacionC,
                                                         UsuarioCapturaC,
                                                         EstatusRegistroC)
                VALUES('$idSiguiente',
                       '$idvehiculo',
                       '$placaSolicitudSup',
                       '$entidadEmpleadoUsuario',
                       '$consecutivoEmpleadoUsuario',
                       '$categoriaEmpleadoUsuario',
                       '$idEntidadTrabajo',
                       '$empleadoEstatusId',
                       '$descripcionPuesto',
                       '$numlicencia',
                       '$kilometraje',
                       'SOLICITUD REALIZADA POR SUPERVISOR',
                       now(),
                       '$usuario',
                       'ACTIVO'
                )";  
        // $log->LogInfo("Valor de la variable sql2 1" . var_export ($sql2, true));
        $res2 = mysqli_query($conexion, $sql2);
    }//tipo 1
    if ($tipoAsignacion==2){//TIPO 2 YA TIENE UNA ASIGNACION

        $sql0 = "SELECT *
                 FROM asignacionesparquevehicular
                 WHERE idvehiculoC='$idvehiculo'";

        $res0 = mysqli_query($conexion, $sql0);

        while (($reg0 = mysqli_fetch_array($res0, MYSQLI_ASSOC))){
                $datosActualesVehiculo[] = $reg0;
        }

        $idAsignacionC= $datosActualesVehiculo[0]['idAsignacionC'];
        $idvehiculoC= $datosActualesVehiculo[0]['idvehiculoC'];
        $NumeroPlacaC= $datosActualesVehiculo[0]['NumeroPlacaC'];
        $entidadFederativaIdC= $datosActualesVehiculo[0]['entidadFederativaIdC'];
        $empleadoConsecutivoIdC= $datosActualesVehiculo[0]['empleadoConsecutivoIdC'];
        $empleadoCategoriaIdC= $datosActualesVehiculo[0]['empleadoCategoriaIdC'];
        $idEntidadTrabajoC= $datosActualesVehiculo[0]['idEntidadTrabajoC'];
        $empleadoEstatusIdC= $datosActualesVehiculo[0]['empleadoEstatusIdC'];
        $PuestoEmpleadoC= $datosActualesVehiculo[0]['PuestoEmpleadoC'];
        $NumeroLicenciaC= $datosActualesVehiculo[0]['NumeroLicenciaC'];
        $KilometrajeC= $datosActualesVehiculo[0]['KilometrajeC'];
        $MotivodeCambioC= $datosActualesVehiculo[0]['MotivodeCambioC'];
        $FechaAsignacionC= $datosActualesVehiculo[0]['FechaAsignacionC'];
        $UsuarioCapturaC= $datosActualesVehiculo[0]['UsuarioCapturaC'];
        $EstatusRegistroC= $datosActualesVehiculo[0]['EstatusRegistroC'];

        $sqlH="INSERT INTO historicoAsignacionParqueVehicular (idAsignacionHistorico, idvehiculoHistorico, NumeroPlacaHistorico, entidadFederativaIdHistorico, empleadoConsecutivoIdHistorico, empleadoCategoriaIdHistorico, idEntidadTrabajoHistorico, empleadoEstatusIdHistorico, PuestoEmpleadoHistorico, NumeroLicenciaHistorico, KilometrajeHistorico, MotivodeCambioHistorico, FechaAsignacionHistorico, FechaInsercionAlHistorico, UsuarioCapturaHistorico, EstatusRegistroHistorico) 
            VALUES (
                '$idAsignacionC',
                '$idvehiculoC',        
                '$NumeroPlacaC',
                '$entidadFederativaIdC',
                '$empleadoConsecutivoIdC',
                '$empleadoCategoriaIdC',
                '$idEntidadTrabajoC',
                '$empleadoEstatusIdC',
                '$PuestoEmpleadoC',
                '$NumeroLicenciaC',
                '$KilometrajeC',
                '$MotivodeCambioC',
                '$FechaAsignacionC',
                now(),
                '$UsuarioCapturaC',
                '$EstatusRegistroC'
                )";//se inserta en el historico antes de hacer la reasignacion
        // $log->LogInfo("Valor de la variable sqlH " . var_export ($sqlH, true));
        $resH = mysqli_query($conexion, $sqlH);

        $sql2 = "UPDATE asignacionesparquevehicular
                 SET entidadFederativaIdC='$entidadEmpleadoUsuario',
                     empleadoConsecutivoIdC='$consecutivoEmpleadoUsuario',
                     empleadoCategoriaIdC='$categoriaEmpleadoUsuario',
                     idEntidadTrabajoC='$idEntidadTrabajo',
                     empleadoEstatusIdC='$empleadoEstatusId',
                     PuestoEmpleadoC='$descripcionPuesto',
                     NumeroLicenciaC='$numlicencia',
                     KilometrajeC='$kilometraje',
                     MotivodeCambioC='REASIGNACION POR SOLICITUD REALIZADA POR SUPERVISOR',
                     FechaAsignacionC=now(),
                     UsuarioCapturaC='$usuario',
                     EstatusRegistroC='ACTIVO'
                 WHERE idvehiculoC='$idvehiculo'";   
        $res2 = mysqli_query($conexion, $sql2);
    // $log->LogInfo("Valor de la variable sql2 " . var_export ($sql2, true));
    }
    $response["status"]= "success";
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);