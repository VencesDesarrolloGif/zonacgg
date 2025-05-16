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
	
		//$log = new KLogger ( "ajaxObtenerEnProcesoImss.log" , KLogger::DEBUG );
		//$estatusEmpleado=getValueFromPost("estatusEmpleado");

	try{
		

		$listaEmpleados= $negocio -> obtenerListaEmpleadosEnProcesoImss();
   
        for ($i = 0; $i < count($listaEmpleados); $i++)
        {   
            $empleadoId = $listaEmpleados[$i] ["numeroEmpleado"];
            $apellidoPaterno = $listaEmpleados[$i] ["apellidoPaterno"];
            $apellidoMaterno = $listaEmpleados[$i] ["apellidoMaterno"];
            $nombreEmpleado1 = $listaEmpleados[$i] ["nombreEmpleado"];
            $nombreEmpleado=$apellidoPaterno." ".$apellidoMaterno." ".$nombreEmpleado1;
            $fechaImss = $listaEmpleados[$i] ["fechaImss"];
            $registroPatronal = $listaEmpleados[$i] ["registroPatronal"];
            $folioTxt = $listaEmpleados[$i] ["folioTxt"];
			$listaEmpleados[$i] ["accion_confirmar_imss_alta"] = "<a href='javascript:confirmar_imss_rechazo(\"" . $empleadoId . "\",\"".$nombreEmpleado."\",\"".$fechaImss."\");'><img src='img/cancel.png' /></a>";
            //$listaEmpleados[$i] ["accion_confirmar_imss"] = "hola";

        }
        
		$response["data"]= $listaEmpleados;

		//$log->LogInfo("Valor de variable de estatusEmpleado que viene de form" . var_export ($estatusEmpleado, true));
		

		//$log->LogInfo("Valor de la variable \$response punto: " . var_export ($response, true));

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