<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
$response = array("status" => "success");
// $log = new KLogger ( "ajaxGetUniformesEmpleado.log" , KLogger::DEBUG );
$empleadoEntidad    =getValueFromPost("entidadEmpleado");
$empleadoConsecutivo=getValueFromPost("consecutivoEmpleado");
$empleadoCategoria  =getValueFromPost("categoriaEmpleado");
$usoPropio   =getValueFromPost("valSI");
$usoPlantilla=getValueFromPost("valNO");

if($usoPropio==1) {
   $totalUniformesARecibir = $negocio ->  obtenerUniformesParaRecibir($empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria);
   $TotalaRecibir   = $totalUniformesARecibir[0]["totaluniformesARecibir"];	
   $deudaEnPlantilla= $negocio ->  obtenerUniformesParaPlantilla($empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria);//se hace tambien para saber si no se deben uniformes de plantilla
   $conteoDeuda     =$deudaEnPlantilla[0]["totaluniformesARecibir"];
}else{
      $totalUniformesARecibir= $negocio ->  obtenerUniformesParaPlantilla($empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria);
      $TotalaRecibir = $totalUniformesARecibir[0]["totaluniformesARecibir"];
      $deudaUsoPropio= $negocio ->  obtenerUniformesParaRecibir($empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria);//se hace tambien para saber si no se deben uniformes de uso propio
      $conteoDeuda	 = $deudaUsoPropio[0]["totaluniformesARecibir"];
     }

try{
	$cardexUnido=array();
	$contNuevo=0;

	if($usoPropio==1) {
	   $cardex = $negocio -> obtenerCardexEmpleado($empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria);
	}else{
	   $cardex = $negocio -> obtenerCardexSupPlantilla($empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria);//si se muestra calzado xq no se cobra al asignar ya que era para plantilla
	}

	for($i=0 ; $i< count($cardex);$i++){

	$idTipoMercancia=$cardex[$i]["idTipoMercancia"];
  	// $log->LogInfo("Valor de la variable idTipoMercancia: " . var_export ($idTipoMercancia, true));	
  	// $log->LogInfo("Valor de la variable costoUniforme: " . var_export ($cardex[$i]["costoUniforme"], true));	
  	// $log->LogInfo("Valor de la variable costoReal: " . var_export ($cardex[$i]["costoReal"], true));	
		
		$idUnif=$cardex[$i]["idUniforme"];
		$cardexUnido[$contNuevo]["idUniforme"]=$cardex[$i]["idUniforme"];
		$cantidad=$cardex[$i]["cantidadUniforme"];
  	// $log->LogInfo("Valor de la variable cantidad: " . var_export ($cantidad, true));	

		if($cantidad==2 && $usoPlantilla==1) {
	       if($idTipoMercancia==5) {
		       $costoUnif=$cardex[$i]["costoUniforme"]/2;
		       $cardexUnido[$contNuevo]["costoUniforme"] =$costoUnif;
	   }else{
	         $cardexUnido[$contNuevo]["costoUniforme"] =$cardex[$i]["costoReal"];
	   }

		}else if($cantidad==1 && $usoPlantilla==1){
	       if($idTipoMercancia==5){
           	 $costoUnif=$cardex[$i]["costoUniforme"];
        		 $cardexUnido[$contNuevo]["costoUniforme"]=$costoUnif;
        	 }else{
        	 		 $costoUnif=$cardex[$i]["costoReal"];
        		 	 $cardexUnido[$contNuevo]["costoUniforme"]=$costoUnif;
        	 }
		}

		if($usoPropio==1) {
           $cardexUnido[$contNuevo]["costoUniforme"]=$cardex[$i]["costoUniforme"];
		}

		$cardexUnido[$contNuevo]["idTipoMercancia"]=$cardex[$i]["idTipoMercancia"];
		$cardexUnido[$contNuevo]["codigoUniforme"] =$cardex[$i]["codigoUniforme"];
		$cardexUnido[$contNuevo]["descUniforme"]   =$cardex[$i]["descUniforme"];
		$cardexUnido[$contNuevo]["fechaAsignacion"]=$cardex[$i]["fechaAsignacion"];

        if($usoPlantilla==1){
	       $cardexUnido[$contNuevo]["idAsignacionUniformeASupervisor"]=$cardex[$i]["idAsignacionUniformeASupervisor"];
		}
		$contNuevo++;

		if($cantidad==2){
		   $cardexUnido[$contNuevo]["idUniforme"]	  =$cardex[$i]["idUniforme"];
		   $cardexUnido[$contNuevo]["idTipoMercancia"]=$cardex[$i]["idTipoMercancia"];
		   $cardexUnido[$contNuevo]["codigoUniforme"] =$cardex[$i]["codigoUniforme"];
		   $cardexUnido[$contNuevo]["descUniforme"]   =$cardex[$i]["descUniforme"];
		   $cardexUnido[$contNuevo]["fechaAsignacion"]=$cardex[$i]["fechaAsignacion"];
		
		   if($usoPropio==1) {
              $cardexUnido[$contNuevo]["costoUniforme"]  =$cardex[$i]["costoUniforme"];
		   }else{
	             if($cardex[$i]["idTipoMercancia"]==5) {
	            	 $cardexUnido[$contNuevo]["costoUniforme"]  =$cardex[$i]["costoUniforme"]/2;
	             	}else{
			             $cardexUnido[$contNuevo]["costoUniforme"]  =$cardex[$i]["costoReal"];
	             	}
	            }
		   
		   if($usoPlantilla==1) {
		      $cardexUnido[$contNuevo]["idAsignacionUniformeASupervisor"]=$cardex[$i]["idAsignacionUniformeASupervisor"];
		     }
		   $contNuevo++;
		}//IF
	}//FOR
	$response["lista"]= $cardexUnido;
	$response["totalUniformes"]= $TotalaRecibir;
	$response["deudaUniformes"]= $conteoDeuda;
  	//$log->LogInfo("Valor de la variable \$response: " . var_export ($response, true));	
} 
catch(Exception $e ){
		$response["status"]="error";
		$response["error"]="No se pudo obtener el cardex del empleado";	
	}
echo json_encode($response);
?>


