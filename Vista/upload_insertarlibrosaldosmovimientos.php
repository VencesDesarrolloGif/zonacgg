<?php

session_start ();

require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();
verificarInicioSesion($negocio);
// Obtenemos los datos del empleado
// $log = new KLogger ( "ajax_uploadpdf.log" , KLogger::DEBUG );
$response = array ();
$usuario = $_SESSION ["userLog"]["usuario"];
$response["status"] = "success";

$selectTipoDeBanco  = $_POST["selectTipoDeBanco"];
$selectNumCuenta  = $_POST["selectNumCuenta"];
$monto        		= $_POST["monto"];
$Case        		= $_POST["Case"];
// $log->LogInfo("Valor de la variable Case: " . var_export ($Case, true));
//$log->LogInfo("Variable sesion: " . var_export ($_SESSION, true));
 $negocio -> negocio_insertLibroSaldosMovimientos($selectTipoDeBanco,$selectNumCuenta,$monto,$Case);//funcion para insertar

if( $response["status"] =='success'){
   //   $log->LogInfo("Valor de la fecha: " . var_export ($fecha, true));
    $response["message"]='Archivos subidos correctamente';
}



echo json_encode($response);

?> 