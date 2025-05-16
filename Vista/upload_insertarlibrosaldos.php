<?php

session_start ();

require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();
verificarInicioSesion($negocio);
// Obtenemos los datos del empleado
//$log = new KLogger ( "ajax_uploadinseertar librosaldos.log" , KLogger::DEBUG );

$response = array ();
$usuario = $_SESSION ["userLog"]["nombre"];
$response["status"] = "success";  
$selectTipoDeBanco  = $_POST["selectTipoDeBanco"];
$selectNumCuenta  = $_POST["selectNumCuenta"];

//$log->LogInfo("Variable sesion: " . var_export ($_SESSION, true));

 $negocio -> negocio_insertLibroSaldos($selectTipoDeBanco,$selectNumCuenta);//funcion para insertar
//$log->LogInfo("Valor de la fecha: " . var_export ($selectNumCuenta, true));
if( $response["status"] =='success'){
      
    $response["message"]='Archivos subidos correctamente';
}

//$log->LogInfo("Valor de la variable response: " . var_export ($response, true));

echo json_encode($response);

?> 