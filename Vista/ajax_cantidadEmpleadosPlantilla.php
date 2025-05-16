<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");
$idPuntosDeServicio = $_POST['idPuntosDeServicio'];
$idPlantilla = $_POST['idPlantilla'];
try{
    //$log = new KLogger ( "ajaxUltimoNumeroOrden.log" , KLogger::DEBUG );

    $CantidadEmpleados = $negocio->negocio_ObtenerCantidadEmleadosPlantilla($idPuntosDeServicio,$idPlantilla);
    $response["datos"]= $CantidadEmpleados;
    //$log -> LogInfo ("ultimoNumeroOrden" . var_export ($ultimoNumeroOrden, true));
} 
catch( Exception $e )
{
    $response["status"]="error";
    $response["error"]="No se puedo obtener la cantidad de empleados en esta plantilla";
}

echo json_encode($response);


?>