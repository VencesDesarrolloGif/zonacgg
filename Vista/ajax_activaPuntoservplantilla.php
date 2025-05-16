<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajaxConsultaEmpleadosByPuntoServicio.log" , KLogger::DEBUG );
$estatuspunto=$_POST["estatuspunto"];
$estatusplantilla=$_POST["estatusplantilla"];
$idpuntoservicio=$_POST["idpuntoservicio"];
$idplantilla=$_POST["idplantilla"];
$response = array("status" => "success");
  if($estatuspunto=="ACTIVO" && $estatusplantilla==0){
    	//solo activar plantilla
   		 $flagactivacion=0;
  }else if($estatuspunto=="INACTIVO" && $estatusplantilla==0){
    	//activar punto de servicio y plantilla
    	$flagactivacion=1;
  	}
try{
	$tipodeactivacion=$negocio -> activar_plantilla_PuntoServicio($flagactivacion,$idpuntoservicio,$idplantilla);
	$response["tipoactivacion"]=$tipodeactivacion;

}catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener consulta";
}
echo json_encode($response);