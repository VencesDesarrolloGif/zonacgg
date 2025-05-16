<?php

session_start();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php"); 
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
$response = array ();
verificarInicioSesion($negocio);
	// $log = new KLogger ( "ajax_updateSueldo.log" , KLogger::DEBUG );
    // $log->LogInfo("Valor de la variable POST: " . var_export ($_POST, true)); 

    $usuario = $_SESSION ["userLog"]["usuario"];
	//$costoTurno=str_replace('$', '', getValueFromPost("txtCostoTurnoEdited"));
    $sueldo=getValueFromPost("valor");
    if(is_numeric($sueldo) == false){
        $response ["status"] = "error";
        $response ["message"] = "Ingrese sueldo correctamente (No se permiten letras)";
    }else{
        $bonoAsistencia=0; 
        $bonoPuntualidad=0;
        $cuotaDiaria=($sueldo-($bonoAsistencia*2+$bonoPuntualidad*2))/30;

	    $datos = array (
	        "puntoServicio" => getValueFromPost("puntoServicioPlantillaId"),
            "puestoId" =>  getValueFromPost("puestoId"),
            "rolId" => getValueFromPost("rolId"),
            "sueldo" => $sueldo,
            "cuotaDiaria" => $cuotaDiaria,
            "usuario" => $usuario,
   	    );
        try
        {
            $registro= $negocio -> getDatosTabuladdorByPuntoPuestoRol($datos);
            if($registro==false){
                $negocio -> insertSueldoAndCuota($datos);
            }else{
                $negocio -> updateSueldoAndCuota($datos);
            }
            $response ["status"] = "success";
            $response ["message"] = "El sueldo fue editado con éxito";
        } 
        catch (Exception $e)
        {
            $response ["status"] = "error";
            $response ["message"] =  $e -> getMessage ();
        }
    }
    echo json_encode ($response);
?>