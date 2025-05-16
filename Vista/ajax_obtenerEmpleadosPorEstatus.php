<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");


/*
if(!empty ($_POST))
{
*/
	
		// $log = new KLogger ( "ajaxObtenerEmpleadosPorEstatus.log" , KLogger::DEBUG );
		$estatusEmpleado=getValueFromPost("estatusEmpleado");

	try{
		

		$listaEmpleados= $negocio -> negocio_obtenerListaEmpleadosPorEstatus($estatusEmpleado);
   
        for ($i = 0; $i < count($listaEmpleados); $i++)
        {   
            $empleadoId = $listaEmpleados[$i] ["numeroEmpleado"];
            $nombreEmpleado = $listaEmpleados[$i] ["nombreCompleto"];
            $fechaIngreso = $listaEmpleados[$i] ["fechaIngresoEmpleado"];
            $listaEmpleados[$i] ["accion_confirmar_imss"] = "<a href='javascript:confirmar_imss(\"" . $empleadoId . "\",\"".$nombreEmpleado."\",\"".$fechaIngreso."\");'>
            <img src='img/editarEmpleado.png' /></a>";
            //<img src=https://".$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_NAME"] ."/img/editarEmpleado.png' /></a>";
        }
        
		$response["data"]= $listaEmpleados;

		// $log->LogInfo("Valor de variable de estatusEmpleado que viene de form" . var_export ($estatusEmpleado, true));
		

		// $log->LogInfo("Valor de la variable \$response punto: " . var_export ($response, true));

	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se pudo obtener Empleados";
	}
/*
}
*/

echo json_encode($response);

?>