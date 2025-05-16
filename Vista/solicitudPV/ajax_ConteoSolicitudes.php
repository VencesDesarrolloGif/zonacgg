<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
$vehiculosXplaca    = array();
$asignacionesVehiculares= array();
// $log = new KLogger ( "ajax_ConteoSolicitudes.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
try {
    $sql = "SELECT idSolicitudVehiculo,
                   placaSolicitudSup
            FROM solicitudesvehiculosupervisor
            WHERE estatusSolicitud='1'"; 

    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
    }
    $response[0]["totalSolicitudes"]=count($datos);

    if($datos==null || $datos=="NULL") {
       $response[0]["totalSolicitudes"] ="0";
       $response[0]["registrarVehiculo"]="0";
       $response[0]["activarVehiculo"]  ="0";
       $response[0]["asignacionListo"]  ="0";
       $response[0]["vehiculoAsignado"] ="0";
    }else{

        $registrarVehiculo=0;
        $activarVehiculo=0;
        $asignacionListo=0;
        $vehiculoAsignado=0;
            
        for($i = 0; $i < count($datos); $i++){
            $placaSolicitudSup  = $datos[$i]["placaSolicitudSup"];
            $vehiculosXplaca=[];
            $sql1 = "SELECT idvehiculo,EstatusDelVehiculo
                     FROM parquevehicular pv
                     WHERE NumeroPlaca='$placaSolicitudSup'";

            $res1 = mysqli_query($conexion, $sql1);
            while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
                    $vehiculosXplaca[] = $reg1;
            }
            
            if($vehiculosXplaca==null || $vehiculosXplaca=="NULL") {
               $registrarVehiculo++;
            }else{//si hay coincidencia
                  $idvehiculo=$vehiculosXplaca[0]["idvehiculo"];
                  $estatusVehiculo=$vehiculosXplaca[0]["EstatusDelVehiculo"];

                  if($estatusVehiculo==0){
                         $activarVehiculo++;
                  }else{
                        $sql2 = "SELECT * 
                                 FROM asignacionesparquevehicular
                                 WHERE idvehiculoC='$idvehiculo'
                                 ORDER BY idAsignacionC DESC
                                 LIMIT 1";   
                        $res2 = mysqli_query($conexion, $sql2);
                        while (($reg2 = mysqli_fetch_array($res2, MYSQLI_ASSOC))){
                            $asignacionesVehiculares[] = $reg2;
                        }
                  
                        if($asignacionesVehiculares==null || $asignacionesVehiculares=="NULL"){//no tiene asignaciones
                              $asignacionListo++;
                        }else{//si tiene asignaciones
                           $vehiculoAsignado++;
                        }
                    }// else estatus vehiculo
            }
        }//for
    $response["status"]= "success";
    $response[0]["registrarVehiculo"] =$registrarVehiculo;
    $response[0]["activarVehiculo"]  =$activarVehiculo;
    $response[0]["asignacionListo"]  =$asignacionListo;
    $response[0]["vehiculoAsignado"] =$vehiculoAsignado;
    }//else null
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";
}
echo json_encode($response);
