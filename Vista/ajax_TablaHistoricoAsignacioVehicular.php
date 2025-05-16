<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajaxObtenerVehiculosVerificacion.log" , KLogger::DEBUG );
$response = array("status" => "success");
$consulta=$_POST['consulta'];
$FechaInicial=$_POST['FechaInicial'];
$FechaFinal=$_POST['FechaFinal'];


// $log->LogInfo("Valor de la variable RolUsuarioVerificacion " . var_export ($RolUsuarioVerificacion, true));

try{
  $ListaAsignacionesVehiculo= $negocio -> traerlistaAsignacionVehiculo($consulta,$FechaInicial,$FechaFinal);
  $ListaAsignacionesVehiculo=array_merge($ListaAsignacionesVehiculo);// merge sirve para eliminar los campos vacion y hacer el consecutivo del array
  //$log->LogInfo("Valor de la variable listalicenciatotal " . var_export ($listalicenciatotal, true));
  for ($i = 0; $i < count($ListaAsignacionesVehiculo); $i++)
    {
      $ListaAsignacionesVehiculo[$i]["idvehiculoHistorico"];
      $ListaAsignacionesVehiculo[$i]["NumeroPlacaHistorico"];
      $ListaAsignacionesVehiculo[$i]["PuestoEmpleadoHistorico"];
      $ListaAsignacionesVehiculo[$i]["NumeroLicenciaHistorico"];
      $ListaAsignacionesVehiculo[$i]["KilometrajeHistorico"];
      $ListaAsignacionesVehiculo[$i]["MotivodeCambioHistorico"];
      $ListaAsignacionesVehiculo[$i]["FechaAsignacionHistorico"];
      $ListaAsignacionesVehiculo[$i]["FechaInsercionAlHistorico"];
      $ListaAsignacionesVehiculo[$i]["UsuarioCapturaHistorico"];

      $entidadFederativaIdHistorico1 = $ListaAsignacionesVehiculo[$i]["entidadFederativaIdHistorico"];
      $empleadoConsecutivoIdHistorico1 = $ListaAsignacionesVehiculo[$i]["empleadoConsecutivoIdHistorico"];
      $empleadoCategoriaIdHistorico1 = $ListaAsignacionesVehiculo[$i]["empleadoCategoriaIdHistorico"];
      $empleadoEstatusIdHistorico1 = $ListaAsignacionesVehiculo[$i]["empleadoEstatusIdHistorico"];
      $apellidoPaterno1 = $ListaAsignacionesVehiculo[$i]["apellidoPaterno"];
      $apellidoMaterno1 = $ListaAsignacionesVehiculo[$i]["apellidoMaterno"];
      $nombreEmpleado1 = $ListaAsignacionesVehiculo[$i]["nombreEmpleado"];
      $idEntidadTrabajoHistorico1 = $ListaAsignacionesVehiculo[$i]["idEntidadTrabajoHistorico"];
      $nombreEntidadFederativa1 = $ListaAsignacionesVehiculo[$i]["nombreEntidadFederativa"];

      if($empleadoEstatusIdHistorico1 == "NO ASIGNAD"){
        $ListaAsignacionesVehiculo[$i]["NombreYNumeroEmpleado"] = ($entidadFederativaIdHistorico1 . " " . $empleadoConsecutivoIdHistorico1 . " " . $empleadoCategoriaIdHistorico1);
        $ListaAsignacionesVehiculo[$i]["EntidadEmpleado"]=($idEntidadTrabajoHistorico1);

      }else{
        $ListaAsignacionesVehiculo[$i]["NombreYNumeroEmpleado"] = ($entidadFederativaIdHistorico1 . "-" . $empleadoConsecutivoIdHistorico1 . "-" . $empleadoCategoriaIdHistorico1 . " " . $nombreEmpleado1 . " " . $apellidoPaterno1 . " " . $apellidoMaterno1);
        $ListaAsignacionesVehiculo[$i]["EntidadEmpleado"]=($nombreEntidadFederativa1);
      }


    } // for I
  $response["data"]= $ListaAsignacionesVehiculo;
}catch( Exception $e )
  {
  $response["status"]="error";
  $response["error"]="No se pudo obtener lista de las asignaciones de los vehiculos";
  }
echo json_encode($response);
?>