<?php
session_start ();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
$response = array ();
verificarInicioSesion ($negocio);
$datos = array();
//$log = new KLogger ( "ajaxRegistroHistoricoBaja.log" , KLogger::DEBUG );
 //$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
    $numeroEmpleado=getValueFromPost("numeroEmpleado");
    $empleadoidd = explode("-", $numeroEmpleado);
    $empleadoEntidad=$empleadoidd[0];
    $empleadoConsecutivo=$empleadoidd[1];
    $empleadoCategoria=$empleadoidd[2];
    try{
        $datos=  $negocio -> consultaEstatusTarjeta($empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria);


        $response ["status"] = "success";
        $response ["datos"]  = $datos;
    }catch (Exception $e){
        $response ["status"] = "error";
        $response ["mensaje"]= "error al consultar tarjeta despensa del empleado";
    }
echo json_encode ($response);
?>