<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
$datos=array();
$response = array("status" => "success");

		//$log = new KLogger ( "ajaxObtenerEmpleadoPorId.log" , KLogger::DEBUG );
		$accion=$_POST["accion"];
		$ctaclabebeneficiario=$_POST["ctaclabebeneficiario"];
		$lineanegocio=$_POST["lineanegocio"];

		
	try{                         if($accion==0){  
									$ctaclabe=substr($ctaclabebeneficiario, 0,3);
									$banco= $negocio -> negocio_getcatbancosSolicitudPago($ctaclabe);
									$listaclaves=$negocio -> negocio_getlistaClavesSolicitudPago($lineanegocio);

									$datos["listaclaves"]=$listaclaves;


							if(count($banco)==1){
							$datos["idbanco"]=$banco[0]["idCuentaBanco"];
									$datos["nombrebanco"]=$descripcionBanco=$banco[0]["nombreBanco"];
							}else{
									$datos["idbanco"]=0;
									$datos["nombrebanco"]="SIN INFORMACIÓN";}
									//$log->LogInfo("Valor de variable cuntabancom" . var_export (count($banco), true));
									

}elseif($accion==1){

$listabancos=$negocio -> obtenerBancosEmpresa();//de esta consulta dependen mas formularios no modificar la consulta.

$datos=$listabancos;
}

$response["datos"]= $datos;



	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Empleado";
	}


echo json_encode($response);

?>