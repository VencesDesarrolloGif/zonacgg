<?php
session_start();
require_once("../Negocio/Negocio.class.php");  
require_once ("Helpers.php"); 
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio); 
$response = array("status" => "success");
// $log = new KLogger ( "ajaxObtenerEmpleadoPorIdaaaaa.log" , KLogger::DEBUG );
if(!empty ($_POST)){
   $empleadoId=getValueFromPost("numeroEmpleado"); 
   $usuario=$_SESSION ["userLog"];  
 try{
    $empleadoidd = explode("-", $empleadoId);
    $empleadoEntidad=$empleadoidd[0];
    $empleadoConsecutivo=$empleadoidd[1]; 
    $empleadoCategoria=$empleadoidd[2]; 
// $log->LogInfo("Valor de variable empleadoId" . var_export ($empleadoId, true));
// $log->LogInfo("Valor de variable empleadoEntidad" . var_export ($empleadoEntidad, true));
// $log->LogInfo("Valor de variable empleadoConsecutivo" . var_export ($empleadoConsecutivo, true));
// $log->LogInfo("Valor de variable empleadoCategoria" . var_export ($empleadoCategoria, true));
// $log->LogInfo("Valor de variable usuario" . var_export ($usuario, true));
    $empleado= $negocio -> negocio_obtenerEmpleadoPorId($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria,$usuario);
// $log->LogInfo("Valor de variable empleado" . var_export ($empleado, true));
    
   if(count($empleado)!=0) {
      $fechaIngresoEmpleado=$empleado[0]["fechaIngresoEmpleado"];
      $claveINE=$empleado[0]["claveINE"];
      $fechaBajaEmpleado   =$empleado[0]["fechaBajaEmpleado"];
      $idCuentaBanco   =$empleado[0]["idCuentaBanco"];
      $numeroCtaClabe   =$empleado[0]["numeroCtaClabe"];
      $claveIne   =$empleado[0]["claveINE"];

      $idPuesto   =$empleado[0]["empleadoIdPuesto"];

      if($idPuesto==6){
         $noGerenteAsignado   =$empleado[0]["noGerenteRegAsignado"];

         if($noGerenteAsignado!=""){

            $empleadoidd = explode("-", $noGerenteAsignado);
            $gerenteEntidad=$empleadoidd[0];
            $gerenteConsecutivo=$empleadoidd[1];
            $gerenteCategoria=$empleadoidd[2];

            $nombreGerente= $negocio -> getGerenteSup($gerenteEntidad, $gerenteConsecutivo, $gerenteCategoria);
            $gerenteNombre   =$nombreGerente[0]["nombreGerenteSup"];
            $empleado[0]["nameGerente"]=$gerenteNombre;
         }else{
         $empleado[0]["nameGerente"]="GERENTE REGIONAL";
         }
      }else{
         $empleado[0]["nameGerente"]="GERENTE REGIONAL";
      }


      $idClabeBanco =  substr($numeroCtaClabe, 0, 3);
     if($fechaBajaEmpleado== "" || $fechaBajaEmpleado== 0 || $fechaBajaEmpleado== "NULL" || $fechaBajaEmpleado== "null" || $fechaBajaEmpleado== "0000-00-00") {
        $fechaBajaEmpleado=date('Y-m-d');
       }
   	 $coberturaEMP= $negocio -> obtenerCoberturaXEmp($fechaIngresoEmpleado,$fechaBajaEmpleado,$empleadoId);//se reutiliza la funcion de negocio y persistencia
    	 $response["coberturaEMP"]= $coberturaEMP;
       if ($idCuentaBanco=='') {
             $banco= $negocio -> obtenerBancoByClabe($idClabeBanco);//se reutiliza la funcion de negocio y persistencia
             if(count($banco)>0) {
                $idBancoXClabe=$banco[0]["idCuentaBanco"];
                $empleado[0]["idCuentaBanco"]=$idBancoXClabe;
             }else{
                $empleado[0]["idCuentaBanco"]="";
             }
       }
      if($claveINE== "" || $claveINE== "NULL" || $claveINE== "null" || $claveINE== null || $claveINE==NULL || $claveINE=="SIN INFORMACION"){
         $empleado[0]["claveINE"]="SIN INFORMACION";
      }
   }
    $response["empleado"]= $empleado; 
// $log->LogInfo("Valor de variable response" . var_export ($response, true));
   }catch(Exception $e ){
	  $response["status"]="error";
	  $response["error"]="No se puedo obtener Empleado";
	 }
}
echo json_encode($response);

?>