<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio= new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");

if(!empty ($_POST))
{
	//$log = new KLogger ( "ultimonumeroDeempleado.log" , KLogger::DEBUG );
	$entidad = getValueFromPost ("entidad");
	$tipo = getValueFromPost ("tipo");
		//$log->LogInfo("Valor de la variable \$entidad: " . var_export ($entidad, true));
        //$log->LogInfo("Valor de la variable \$tipo: " . var_export ($tipo, true));
    try{
        $ultimoNumeroEmpleado = $negocio -> negocio_obtenerUltimoNumeroEmpleado($entidad, $tipo);
        $ultimoNumeroEmpleado=$ultimoNumeroEmpleado["ultimoEmpleado"];
        $primercaracter = substr($ultimoNumeroEmpleado, 0, 1);
        if($primercaracter=="0"){
            $ultimoNumeroEmpleado=substr($ultimoNumeroEmpleado, 1, strlen($ultimoNumeroEmpleado)); 
        }
             //$log->LogInfo("Valor de la variable \$response: " . var_export ($ultimoNumeroEmpleado, true));  
       $response ["ultimoNumeroEmpleado"] = $ultimoNumeroEmpleado; 
    }
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] = "No se pudo obtener el ultimo numero ";
    }
}
echo json_encode ($response);

?>