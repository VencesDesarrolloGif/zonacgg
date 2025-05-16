<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
$vehiculosXplaca    = array();
$asignacionesVehiculares= array();
// $log = new KLogger ( "ajax_ConsultaSolicitudes.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
try {
    $sql = "SELECT idSolicitudVehiculo,
                   fechaSolicitudVehiculo,
                   placaSolicitudSup,
                   kmSolicitudSup,
                   usuario,
                   concat_ws('-',ue.entidadEmpleadoUsuario, ue.consecutivoEmpleadoUsuario, ue.categoriaEmpleadoUsuario) as NumeroEmpleado,
                   concat_ws(' ',nombreEmpleado,apellidoPaterno,apellidoMaterno) as supervisor,
                   imagenFrontal,
                   imagenDerecha,
                   imagenIzquierda,
                   imagenTrasera,
                   ue.entidadEmpleadoUsuario,
                   ue.consecutivoEmpleadoUsuario,
                   ue.categoriaEmpleadoUsuario,
                   e.idEntidadTrabajo,
                   e.empleadoEstatusId,
                   CP.descripcionPuesto,
                   e.numlicencia
            FROM solicitudesvehiculosupervisor sv
            LEFT JOIN usuario_empleado ue on (ue.usuario=sv.usuarioSupSolicita)
            LEFT JOIN empleados e on (e.entidadFederativaId=ue.entidadEmpleadoUsuario and e.empleadoConsecutivoId=ue.consecutivoEmpleadoUsuario and e.empleadoCategoriaId=ue.categoriaEmpleadoUsuario)
            LEFT JOIN catalogopuestos cp on (e.empleadoIdPuesto=cp.idPuesto)
            WHERE estatusSolicitud='1'"; 
// $log->LogInfo("Valor de la variable sql " . var_export ($sql, true));

    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
    }

    if($datos==null || $datos=="NULL") {
       $datos[0]["NumeroEmpleado"]="SIN INFORMACIÓN";
       $datos[0]["supervisor"]="SIN INFORMACIÓN";
       $datos[0]["placaSolicitudSup"]="SIN INFORMACIÓN";
       $datos[0]["kmSolicitudSup"]="SIN INFORMACIÓN";
       $datos[0]["fechaSolicitudVehiculo"]="SIN INFORMACIÓN";
       $datos[0]["imgFrontal"]="SIN INFORMACIÓN";
       $datos[0]["imgDerecha"]="SIN INFORMACIÓN";
       $datos[0]["imgIzquierda"]="SIN INFORMACIÓN";
       $datos[0]["imgTrasera"]="SIN INFORMACIÓN";
       $datos[0]["informacion"]="SIN INFORMACIÓN";
       $datos[0]["accion"]="SIN INFORMACIÓN";
    }else{

        for($i = 0; $i < count($datos); $i++){
            
            $idSolicitudVehiculo= $datos[$i]["idSolicitudVehiculo"];
            $placaSolicitudSup  = $datos[$i]["placaSolicitudSup"];
            $kmSolicitudSup  = $datos[$i]["kmSolicitudSup"];
            $imagenFrontal  = $datos[$i]["imagenFrontal"];
            $imagenDerecha  = $datos[$i]["imagenDerecha"];
            $imagenIzquierda= $datos[$i]["imagenIzquierda"];
            $imagenTrasera  = $datos[$i]["imagenTrasera"];

            $entidadEmpleadoUsuario    = $datos[$i]["entidadEmpleadoUsuario"];
            $consecutivoEmpleadoUsuario= $datos[$i]["consecutivoEmpleadoUsuario"];
            $categoriaEmpleadoUsuario  = $datos[$i]["categoriaEmpleadoUsuario"];
            $idEntidadTrabajo  = $datos[$i]["idEntidadTrabajo"];
            $empleadoEstatusId = $datos[$i]["empleadoEstatusId"];
            $descripcionPuesto = $datos[$i]["descripcionPuesto"];
            $numlicencia = $datos[$i]["numlicencia"];

            $imgFrontal ="../../../Gif_App_Asistencia/".$imagenFrontal;
            $imgDerecha ="../../../Gif_App_Asistencia/".$imagenDerecha;
            $imgIzquierda ="../../../Gif_App_Asistencia/".$imagenIzquierda;
            $imgTrasera ="../../../Gif_App_Asistencia/".$imagenTrasera;
            $vehiculosXplaca=[];
            $sql1 = "SELECT idvehiculo,EstatusDelVehiculo
                     FROM parquevehicular pv
                     WHERE NumeroPlaca='$placaSolicitudSup'";   
            // $log->LogInfo("Valor de la variable sql1 " . var_export ($sql1, true));
            $res1 = mysqli_query($conexion, $sql1);
            while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
                    $vehiculosXplaca[] = $reg1;
            }
            
            if($vehiculosXplaca==null || $vehiculosXplaca=="NULL") {
               $datos[$i]["informacion"] = "<p style='white-space: pre-line;'>NO HAY REGISTRO DE ALGÚN VEHICULO CON ESTA PLACA EN EL PARQUE VEHICULAR GIF.
                                                <span style='color: blue;'>REGISTRA EL VEHICULO PARA PODER REALIZAR LA ASIGNACIÓN</span>
                                            </p>";

              $datos[$i]["accion"] = "<img style='width: 30%' title='REGISTRA EL VEHICULO' src='img/alert.png' class='cursorImg' onclick=btnVehiculoNuevo();>";

            }else{//si hay coincidencia
                  $idvehiculo=$vehiculosXplaca[0]["idvehiculo"];
                  $estatusVehiculo=$vehiculosXplaca[0]["EstatusDelVehiculo"];

                  if($estatusVehiculo==0){
                         $datos[$i]["informacion"]="<p style='white-space: pre-line;'><span style='color: red;'>VEHICULO ACTUALMENTE DADO DE BAJA</span></p>";
                         $datos[$i]["accion"] ="<img style='width: 30%'; title='ACTUALIZA ESTATUS DEL VEHICULO' src='img/alert.png' class='cursorImg' onclick=btnVehiculoBaja();>";   
                  }else{
                        $sql2 = "SELECT * 
                                 FROM asignacionesparquevehicular
                                 WHERE idvehiculoC='$idvehiculo'
                                 ORDER BY idAsignacionC DESC
                                 LIMIT 1";   
                        // $log->LogInfo("Valor de la variable sql2 " . var_export ($sql2, true));
                        $res2 = mysqli_query($conexion, $sql2);
                        while (($reg2 = mysqli_fetch_array($res2, MYSQLI_ASSOC))){
                            $asignacionesVehiculares[] = $reg2;
                        }
                  
                        if($asignacionesVehiculares==null || $asignacionesVehiculares=="NULL"){//no tiene asignaciones
                              $datos[$i]["informacion"]="<p style='white-space: pre-line;'><span style='color: green;'>LISTO PARA ASIGNAR</p></span>";
                              $datos[$i]["accion"]="<img style='width: 30%'; title='Confirmar solicitud' src='img/confirmarImss.png' class='cursorImg' id='btnConfirmarSolicitud' onclick=\"btnConfirmarSolicitudVehiculo('$idSolicitudVehiculo',1,'$idvehiculo','$placaSolicitudSup','$entidadEmpleadoUsuario','$consecutivoEmpleadoUsuario','$categoriaEmpleadoUsuario','$idEntidadTrabajo','$empleadoEstatusId','$descripcionPuesto','$numlicencia','$kmSolicitudSup')\">";
                        }else{//si tiene asignaciones
                           $datos[$i]["informacion"] = "<p style='white-space: pre-line;'>
                                                          <span style='color: red;'>
                                                              VEHICULO CON ASIGNACION ACTIVA
                                                          </span>
                                                        </p>";
                           $datos[$i]["accion"] = "<img style='width: 30%;' title='Confirmar reasignación' src='img/confirmarImss.png' class='cursorImg' id='btnConfirmarSolicitud' onclick=\"preguntaReasignación('$idSolicitudVehiculo', '2', '$idvehiculo', '$placaSolicitudSup', '$entidadEmpleadoUsuario', '$consecutivoEmpleadoUsuario', '$categoriaEmpleadoUsuario', '$idEntidadTrabajo', '$empleadoEstatusId', '$descripcionPuesto', '$numlicencia', '$kmSolicitudSup')\">";
                        }
                    }
            }
            $datos[$i]["imgFrontal"]  ="<div style='text-align: center;'>" .
                                        "<img style='width: 30%'; title='Abrir Documento' src='img/pdf.png' class='cursorImg' id='btnAbrirDoc' onclick=btnAbrirFotoSolicitudVehiculo('$imgFrontal')>".
                                        "</div>";

            $datos[$i]["imgDerecha"]  ="<div style='text-align: center;'>" .
                                        "<img style='width: 22%'; title='Abrir Documento' src='img/pdf.png' class='cursorImg' id='btnAbrirDoc' onclick=btnAbrirFotoSolicitudVehiculo('$imgDerecha')>".
                                        "</div>";
            $datos[$i]["imgIzquierda"]="<div style='text-align: center;'>" .
                                        "<img style='width: 22%'; title='Abrir Documento' src='img/pdf.png' class='cursorImg' id='btnAbrirDoc' onclick=btnAbrirFotoSolicitudVehiculo('$imgIzquierda')>".
                                        "</div>";
            $datos[$i]["imgTrasera"] = "<div style='text-align: center;'>" .
                                        "<img style='width: 32%'; title='Abrir Documento' src='img/pdf.png' class='cursorImg' id='btnAbrirDoc' onclick=btnAbrirFotoSolicitudVehiculo('$imgTrasera')>".
                                       "</div>";
        }
    }
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
