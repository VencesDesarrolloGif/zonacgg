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
  $ListaEdicionVehiculo= $negocio -> traerlistaEdicionVehiculo($consulta,$FechaInicial,$FechaFinal);
  $ListaEdicionVehiculo=array_merge($ListaEdicionVehiculo);// merge sirve para eliminar los campos vacion y hacer el consecutivo del array
  //$log->LogInfo("Valor de la variable listalicenciatotal " . var_export ($listalicenciatotal, true));
  for ($i = 0; $i < count($ListaEdicionVehiculo); $i++)
    {

      $ListaEdicionVehiculo[$i]["NumeroEco"];
      $ListaEdicionVehiculo[$i]["ColorEngomado"];
      $ListaEdicionVehiculo[$i]["LineaNegocio"];
      $ListaEdicionVehiculo[$i]["Entidad"];
      $ListaEdicionVehiculo[$i]["Placas"];
      $ListaEdicionVehiculo[$i]["TipoTarjeta"];
      $ListaEdicionVehiculo[$i]["FechaInicioVegenciaTC"];
      $ListaEdicionVehiculo[$i]["FechaFinVigenciaTC"];
      $ListaEdicionVehiculo[$i]["TieneMotor"];
      $ListaEdicionVehiculo[$i]["Pais"];
      $ListaEdicionVehiculo[$i]["NumeroNip"];
      $ListaEdicionVehiculo[$i]["Aseguradora"];
      $ListaEdicionVehiculo[$i]["TipoPoliza"];
      $ListaEdicionVehiculo[$i]["FechaInicioPoliza"];
      $ListaEdicionVehiculo[$i]["FechaFinalPoliza"];
      $ListaEdicionVehiculo[$i]["NombreTarjetaC"];
      $ListaEdicionVehiculo[$i]["NombrePoliza"];
      $ListaEdicionVehiculo[$i]["NombreFactura"];
      $ListaEdicionVehiculo[$i]["UsuarioEdited"];
      $ListaEdicionVehiculo[$i]["FechaEdicion"];
      $ListaEdicionVehiculo[$i]["NumeroDeMotor"];
      $NumeroTarjetaLlave = $ListaEdicionVehiculo[$i]["NumeroTarjetaLlave"];
      $NumeroTarjetaGas = $ListaEdicionVehiculo[$i]["NumeroTarjetaGas"];
      $NumeroPoliza = $ListaEdicionVehiculo[$i]["NumeroPoliza"];


      if($NumeroTarjetaLlave == "" || $NumeroTarjetaLlave == "null" || $NumeroTarjetaLlave == "NULL" || $NumeroTarjetaLlave == null || $NumeroTarjetaLlave == NULL){
        $ListaEdicionVehiculo[$i]["NumeroTarjetaLlave"] = "";
      }else{
        $ListaEdicionVehiculo[$i]["NumeroTarjetaLlave"] =$NumeroTarjetaLlave;
      }
      if($NumeroTarjetaGas == "" || $NumeroTarjetaGas == "null" || $NumeroTarjetaGas == "NULL" || $NumeroTarjetaGas == null || $NumeroTarjetaGas == NULL){
      $ListaEdicionVehiculo[$i]["NumeroTarjetaGas"] = "";
      }else{
        $ListaEdicionVehiculo[$i]["NumeroTarjetaGas"] =$NumeroTarjetaGas;
      }
      if($NumeroPoliza == "" || $NumeroPoliza == "null" || $NumeroPoliza == "NULL" || $NumeroPoliza == null || $NumeroPoliza == NULL){
      $ListaEdicionVehiculo[$i]["NumeroPoliza"] = "";
      }else{
        $ListaEdicionVehiculo[$i]["NumeroPoliza"] =$NumeroPoliza;
        
      }
    } // for I
	$response["data"]= $ListaEdicionVehiculo;
}catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se pudo obtener lista de la edicion de los vehiculos";
	}
echo json_encode($response);
?>