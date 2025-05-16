<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
//$log               = new KLogger("ajax_consultaHistoricoFiniquitoDGaaaaaaaaaaaaaaaaaa.log", KLogger::DEBUG);
//$log->LogInfo("Valor de la variable datos1: " . var_export ($datos, true));     
$negocio            = new Negocio ();
$response           = array();
$response["status"] = "error";
$datos              = array();
$usuario            = $_SESSION ["userLog"]["usuario"];
$tipo= getValueFromPost("tipo");
$estatusEmpleado= getValueFromPost("estatusEmpleado");
$fechaconsultaInicial= getValueFromPost("fechaconsultaInicial");
$fechaconsultaFin= getValueFromPost("fechaconsultaFin");

try {
    $datos = $negocio -> obtenerHistoricoAlm($tipo,$estatusEmpleado,$fechaconsultaInicial,$fechaconsultaFin);
    for ($i = 0; $i < count($datos); $i++) {  
     
        $fechaBajaEmpleado       = $datos[$i]["fechaBajaEmpleado"];
        $fechaAsignacionHis      = $datos[$i]["fechaAsignacionHis"];        
        $estatusUniformeRecibido = $datos[$i]["estatusUniformeRecibido"];    
        $entidadRecepcionHis     = $datos[$i]["entidadRecepcionHis"];
        $fechaRecibidoHis        = $datos[$i]["fechaRecibidoHis"];
        $tipoMovimiento          = $datos[$i]["tipoMovimiento"];

        if($fechaBajaEmpleado == '0000-00-00' || $fechaBajaEmpleado == ' ' || $fechaBajaEmpleado == 'null' || $fechaBajaEmpleado == 'NULL' || $fechaBajaEmpleado == null || $fechaBajaEmpleado == NULL){
           $datos[$i]["fechaBajaEmpleado"]   = "<label style='color:green'> - </label>";
           $datos[$i]["fechaBajaEmpleado1"]   = 0;
          }

        if($fechaAsignacionHis == '0000-00-00' || $fechaAsignacionHis == ' ' || $fechaAsignacionHis == 'null' || $fechaAsignacionHis == 'NULL' || $fechaAsignacionHis == null || $fechaAsignacionHis == NULL){
           $datos[$i]["fechaAsignacionHis"]       = "<label style='color:red'> - </label>";
          }

        if ($estatusUniformeRecibido == '' || $estatusUniformeRecibido == 'null' || $estatusUniformeRecibido == 'NULL' || $estatusUniformeRecibido == null || $estatusUniformeRecibido == NULL) {
            $datos[$i]["estatusUniformeRecibido"] = "<label style='color:green'> - </label>";
           }
            elseif($estatusUniformeRecibido == '0'){
              $datos[$i]["estatusUniformeRecibido"] = "Recibir a Stock";
            } 
            elseif ($estatusUniformeRecibido == '1') {
             $datos[$i]["estatusUniformeRecibido"]="LAVANDERIA";
            } 
            elseif ($estatusUniformeRecibido == '2') {
             $datos[$i]["estatusUniformeRecibido"]="DESTRUCCION";
            } 
             elseif ($estatusUniformeRecibido == '3') {
             $datos[$i]["estatusUniformeRecibido"]="COBRO";
            }        

        if($entidadRecepcionHis == ' ' || $entidadRecepcionHis == 'null' || $entidadRecepcionHis == 'NULL' || $entidadRecepcionHis == null || $entidadRecepcionHis == NULL){
           $datos[$i]["entidadRecepcionHis"]   = "<label style='color:green'> - </label>";
          }

        if($fechaRecibidoHis == ' ' || $fechaRecibidoHis == 'null' || $fechaRecibidoHis == 'NULL' || $fechaRecibidoHis == null || $fechaRecibidoHis == NULL){
           $datos[$i]["fechaRecibidoHis"]   = "<label style='color:green'> - </label>";
          }

          if ($tipoMovimiento == '1') {//cambio
            $datos[$i]["tipoMovimiento"] = "<label style='color:green'> Asignado por almacen</label>";
           }else if ($tipoMovimiento == '2'){
                  $datos[$i]["tipoMovimiento"] = "<label style='color:red'> Devuelto </label>";;
                }else if ($tipoMovimiento == '3'){
                    $datos[$i]["tipoMovimiento"] = "<label style='color:blue'> Para Asignar </label>";;
                    }else if ($tipoMovimiento == '4'){
                        $datos[$i]["tipoMovimiento"] = "<label style='color:black'> Asignado por supervisor </label>";;
                        }else if ($tipoMovimiento == '5'){
                            $datos[$i]["tipoMovimiento"] = "<label style='color:gray'> Asignado por Consulta supervisor </label>";;
                            }else if ($tipoMovimiento == '6'){
                                $datos[$i]["tipoMovimiento"] = "<label style='color:blueviolet'> Asignado por Reclutador </label>";;
                                }else if ($tipoMovimiento == '7'){
                                    $datos[$i]["tipoMovimiento"] = "<label style='color:blueviolet'> Devuelto(uniformes Plantilla) </label>";;
                                    }  

    }
    $response["status"] = "success";
    $response["datos"]  = $datos;
//$log->LogInfo("Valor de la variable datos1: " . var_export ($datos, true));     

} catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
