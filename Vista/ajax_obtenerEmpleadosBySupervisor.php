<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);
// $log = new KLogger ( "ajaxObtenerEmpleadosBySupervisor.log" , KLogger::DEBUG );

$response = array("status" => "success");

if(!empty ($_POST))
{

	
		// $log = new KLogger ( "ajaxObtenerEmpleadosBySupervisor.log" , KLogger::DEBUG );
		//$estatusEmpleado=getValueFromPost("estatusEmpleado");
		$usuario = $_SESSION ["userLog"]["empleadoId"];
		$fecha1=getValueFromPost("fecha1");
		$fecha2=getValueFromPost("fecha2");
		$periodoId=getValueFromPost("periodoId");

		$empleadoidd = explode("-", $usuario);

		$supervisorEntidad=$empleadoidd[0];
        $supervisorConsecutivo=$empleadoidd[1];
        $supervisorTipo=$empleadoidd[2];

		// $log->LogInfo("Valor de variable de fecha1" . var_export ($fecha1, true));
		// $log->LogInfo("Valor de variable de fecha2" . var_export ($fecha2, true));
		// $log->LogInfo("Valor de variable de usuario" . var_export ($usuario, true));
		// $log->LogInfo("Valor de variable de usuario" . var_export ($supervisorEntidad, true));
		// $log->LogInfo("Valor de variable de usuario" . var_export ($supervisorConsecutivo, true));
		// $log->LogInfo("Valor de variable de usuario" . var_export ($supervisorTipo, true));


	try{
		

		$listaEmpleados= $negocio -> getListaEmpleadosBySupervisor($fecha1, $fecha2, $supervisorEntidad, $supervisorConsecutivo,$supervisorTipo, $periodoId);
		$listaIncidencias= $negocio -> getCatalogoIncidencias();

		// $log->LogInfo("Valor de variable de listaIncidencias" . var_export ($listaIncidencias, true));


    $currentDay = date ("d");
    $currentMonth = date ("m");
    $currentYear = date ("Y");

    $startDay = 1;
    $endDay = 15;

    if ($currentDay > 15)
    {
        $startDay = 16;
        $endDay = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
    }

    // Crea el select
    $incidencias = "<select style='width:70px;' onchange='doChange(this);'>";
    for ($i = 0; $i < count ($listaIncidencias); $i++)
    {
        $incidencias .= "<option value='" . $listaIncidencias[$i]["incidenciaId"] . "'>" . $listaIncidencias[$i]["nomenclaturaIncidencia"] . "</option>";
    }
    $incidencias .= "</select>";

    $items = array ();
    for ($i = $startDay; $i <= $endDay; $i++)
    {
        $items["dia_" . $i] = $incidencias; 
    }


		for ($i = 0; $i < count($listaEmpleados); $i++)
        {   

            $numeroEmpleado = $listaEmpleados[$i] ["numeroEmpleado"];
            $nombreEmpleado = $listaEmpleados[$i] ["nombreEmpleado"];
            $descripcionPuesto = $listaEmpleados[$i] ["descripcionPuesto"];
            $descripcionTurno = $listaEmpleados[$i] ["descripcionTurno"];
            $puntoServicio = $listaEmpleados[$i] ["puntoServicio"];
            //$listaEmpleados[$i]["diferencia"]=abs($elementosContratados-$numeroElementos);
            //

            $listaEmpleados[$i] = array_merge ($listaEmpleados[$i], $items);
        }
        
		$response["data"]= $listaEmpleados;

		// $log->LogInfo("Valor de variable de listaEmpleados" . var_export ($listaEmpleados, true));
		

		// $log->LogInfo("Valor de la variable \$response punto: " . var_export ($response, true));

	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se pudo obtener lista de empleados";
	}

}
else
{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}


echo json_encode($response);

?>
