<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");

//$log = new KLogger ( "ajax_INCAPACIDADdDDDD.log" , KLogger::DEBUG );
$usuario = $_SESSION ["userLog"];
$opcion=$_POST["opcion"];

//$log->LogInfo("Valor de usuario" . var_export ($usuario, true));


if($opcion==0){
$lineanegocio=$_POST["lineanegocio"];
try {
    $puestos   = $negocio->obtenerCatalogoPuestoPorTipoPuesto("03",$lineanegocio);
    $response["datos"] = $puestos;
    

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No Se Obtuvieron Puestos";
}
}else if ($opcion==1 || $opcion==2){ //la opcion 32 viene del form_ConsultaPersonal.php  este ajax corresponde normlmente al form_asistenciaPeriodo1.php


	//comnsultar si el empleado debe algun archivo de incapacidad
$numeroEmpleado=$_POST["numeroempleado"]; 
$numempleadoArray=explode("-",$numeroEmpleado);

$empleado ["entidadId"] = $numempleadoArray[0];
$empleado ["consecutivoId"] = $numempleadoArray[1];
$empleado ["tipoId"] = $numempleadoArray[2];

if($opcion==1){
    $opcion=2;

}elseif($opcion==2){
    $opcion=3;
}

 $conteoincapacidades2= $negocio -> insertandupdatefolioincapacidad("","","",$empleado,"","",$opcion);
 if(count($conteoincapacidades2)!=0){
    $response["idincapacidad"]= $conteoincapacidades2[0]["tipoIncapacidad"];
    $response["st7"]= $conteoincapacidades2[0]["st7"];
    $response["st2"]= $conteoincapacidades2[0]["st2"];
    $response["fechaInicioIncapacidad"]= $conteoincapacidades2[0]["fechaInicioIncapacidad"];
    $response["fechaFInIncapacidad"]= $conteoincapacidades2[0]["fechaFInIncapacidad"];
    
}else{
$response["idincapacidad"]="";
$response["st7"]= null;
$response["st2"]= null;
$response["fechaInicioIncapacidad"]= "";
$response["fechaFInIncapacidad"]="";
}

 

}
echo json_encode($response);
