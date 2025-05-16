<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");


$negocio= new Negocio();

verificarInicioSesion ($negocio);

$supervisorId= getValueFromPost ("supervisorId");
$nombre= getValueFromPost ("nombre");


if(($_SESSION ["userLog"]["rol"]=="Analista Asistencia" || $_SESSION ["userLog"]["rol"]=="Facturacion") and $supervisorId!='' ){
    
    $usuario=$supervisorId;
    
}else if ($_SESSION["userLog"]["rol"]=="Supervisor" || $_SESSION["userLog"]["rol"]=="Consulta Supervisor"){

    $usuario = $_SESSION ["userLog"]["empleadoId"];
}

//$log = new KLogger ( "ajaxGetPuntosBySupervisor.log" , KLogger::DEBUG );
        $empleadoidd = explode("-", $usuario);

        $supervisorEntidad=$empleadoidd[0];
        $supervisorConsecutivo=$empleadoidd[1];
        $supervisorTipo=$empleadoidd[2];

        //$log->LogInfo("Valor de la variable \$supervisorEntidad: " . var_export ($supervisorEntidad, true));
        //$log->LogInfo("Valor de la variable \$supervisorConsecutivo: " . var_export ($supervisorConsecutivo, true));
        //$log->LogInfo("Valor de la variable \$supervisorTipo: " . var_export ($supervisorTipo, true));

$response = array("status" => "success");


    try{

        $puntos = $negocio -> getPuntosServiciosSupervisorByNamePunto($supervisorEntidad, $supervisorConsecutivo, $supervisorTipo, $nombre);
        //$log->LogInfo("Valor de la variable \$supervisorTipo: " . var_export ($puntos, true));
        
        $response ["puntos"] = $puntos;
        //$log->LogInfo("Valor de la variable \$responseajax de puntos segun tipo: " . var_export ($response, true));
        
    }
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] = "No se pudieron obtener los puntos";
    }

echo json_encode ($response);
?>