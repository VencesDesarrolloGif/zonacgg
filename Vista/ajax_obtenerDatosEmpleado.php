<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajaxObtenerDatosEmpleado.log" , KLogger::DEBUG );
$empleadoId=getValueFromPost("numeroEmpleado");
$Usuario =$_SESSION ["userLog"];
$rolUSR =$_SESSION ["userLog"]["rol"];
//$log->LogInfo("Valor de variable de Usuario" . var_export ($Usuario, true));
		
try{
    $empleadoidd = explode("-", $empleadoId);
    $empleadoEntidad    =$empleadoidd[0];
    $empleadoConsecutivo=$empleadoidd[1];
    $empleadoCategoria  =$empleadoidd[2];
    
    if($rolUSR== "Reclutador"){
    	$empleado= $negocio -> datosEmpleado($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria,$Usuario);
       }else if($rolUSR== "Supervisor" || $rolUSR== "Consulta Supervisor") {
		$PuntosServ= $negocio -> obtenerPuntosServSup($Usuario);
		$empleado= $negocio -> datosEmpleadoXSup($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria,$PuntosServ);
	       }

    if(count($empleado)== 0 && $rolUSR== "Reclutador") {
    	$response["status"]="error";
	$response["error"]="Este empleado no pertenece a las lineas de negocio o entidades federativas Asignadas";
       }else if((count($empleado)== 0) && ($rolUSR== "Supervisor" || $rolUSR== "Consulta Supervisor")){
     	     	$response["status"]="error";
	     	$response["error"] ="Este empleado no pertenece a ningún punto de servicio asignado";
    }else{
    	  $response["empleado"]= $empleado;
	 }
   }catch( Exception $e ){
		$response["status"]="error";
		$response["error"]="No se puedo obtener Empleado";
		}
//$log->LogInfo("Valor de variable de response" . var_export ($response, true));


echo json_encode($response);

?>