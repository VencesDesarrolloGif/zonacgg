<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
//$log=new KLogger("ajax_ConsultaTotalEmpleados.log", KLogger::DEBUG);
$negocio = new Negocio ();
verificarInicioSesion ($negocio);
$response = array();
$response["status"] = "error";
$lineaNeg = getValueFromPost ("lineaNegPermanencia");

try {
    $TotalesEmpleados= $negocio -> obtenerTotalEmpleados($lineaNeg);
    $conteo = count($TotalesEmpleados);

    if ($conteo !=1) {
    	# code...
    $response["totalEmpleados"]  =  $TotalesEmpleados[0]["TotalEmpleados"];
    $response["totalOperativos"]  =  $TotalesEmpleados[1]["TotalEmpleados"];
    $response["totalAdministrativos"]  =  $TotalesEmpleados[2]["TotalEmpleados"];
}else{
	$response["totalEmpleados"]  =  $TotalesEmpleados[0]["TotalEmpleados"];
    $response["totalOperativos"]  =  $TotalesEmpleados[0]["TotalEmpleados"];
    $response["totalAdministrativos"]  =  $TotalesEmpleados[0]["TotalEmpleados"];
}
    $response["status"] = "success";

//$log->LogInfo("Valor de la variable response: " . var_export ($response, true));     
  }catch (Exception $e) {
      $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
