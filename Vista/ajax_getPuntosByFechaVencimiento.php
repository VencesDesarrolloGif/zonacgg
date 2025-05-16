<?php


session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajax_getPuntosByFechaVencimiento.log" , KLogger::DEBUG );
$response = array("status" => "success");


try{

	$listaPuntos= $negocio -> getPuntosByFechaVencimiento();
	$response["listaPuntos"]= $listaPuntos;
	//$log->LogInfo("Valor de la variable \$listaPuntos: " . var_export ($response, true));

} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener consulta";
}

echo json_encode($response);
/*

	
		$log = new KLogger ( "ajaxObtenerEmpleadosSinBajaImss.log" , KLogger::DEBUG );
		//$estatusEmpleado=getValueFromPost("estatusEmpleado");

	try{
		

		$listaPuntos= $negocio -> obtenerlistaPuntosSinBajaImss();
   
        for ($i = 0; $i < count($listaPuntos); $i++)
        {   
            $empleadoId = $listaPuntos[$i] ["numeroEmpleado"];
            $nombreEmpleado = $listaPuntos[$i] ["apellidoPaterno"];
            $fechaIngreso = $listaPuntos[$i] ["fechaIngresoEmpleado"];
            //$listaPuntos[$i] ["accion_confirmar_imss"] = "<a href='javascript:confirmar_imss(\"" . $empleadoId . "\",\"".$nombreEmpleado."\",\"".$fechaIngreso."\");'>
            //<img src='img/editarEmpleado.png' /></a>";
            //<img src=https://".$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_NAME"] ."/img/editarEmpleado.png' /></a>";
        }
        
		$response["data"]= $listaPuntos;

		//$log->LogInfo("Valor de variable de estatusEmpleado que viene de form" . var_export ($estatusEmpleado, true));
		

		$log->LogInfo("Valor de la variable \$response punto: " . var_export ($response, true));

	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se pudo obtener Empleados";
	}

echo json_encode($response);

*/

?>

