<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
 
$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");

//$log = new KLogger ( "ajax_getDetalleAsistencia.log" , KLogger::DEBUG );
$usuario=$_SESSION["userLog"];
//$log->LogInfo("Valor de la variable \$usuario : " . var_export ($usuario, true));
/*
if(!empty ($_POST))
{
*/
	
		//$log = new KLogger ( "ajaxObtenerDetalleAsistencia.log" , KLogger::DEBUG ); 

		$fecha1=getValueFromPost("fechaConsulta1");
		$fecha2=getValueFromPost("fechaConsulta2");

	try{
		

		$lista= $negocio -> getDetalleAsistencia($fecha1, $fecha2,$usuario);
		for ($i = 0; $i < count($lista); $i++) {        
        	$DescripcioRolOP        = $lista[$i]["DescripcioRolOP"];
        	$DescincTurnoASistencia        = $lista[$i]["DescincTurnoASistencia"];
        	if($DescripcioRolOP !="" && $DescripcioRolOP!="null" && $DescripcioRolOP!="NULL" && $DescripcioRolOP!=null && $DescripcioRolOP!=NULL ){
				$lista[$i]["roloperativo"] = $DescripcioRolOP;
        	}
        	if( $DescincTurnoASistencia =="" || $DescincTurnoASistencia == "null" || $DescincTurnoASistencia == "NULL" || $DescincTurnoASistencia == null || $DescincTurnoASistencia == NULL ){
        		$lista[$i]["IncidenciaTurnoAsistencia"] = "SIN REGISTRO";
        	}else{
				$lista[$i]["IncidenciaTurnoAsistencia"] = $DescincTurnoASistencia;
        	}
    	}


		$response["data"]= $lista;
	

		//$log->LogInfo("Valor de la variable \$response : " . var_export ($response, true));

	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se pudo obtener detalle de asistencia";
	}
/*
}
*/

echo json_encode($response);

?>