<?php

session_start();  

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php"); 
require_once("../libs/logger/KLogger.php");


$negocio= new Negocio();

verificarInicioSesion ($negocio);
  
$response = array();

if(!empty ($_POST))
{
	//$log = new KLogger ( "ajaxObtenerPlantillasPerfil.log" , KLogger::DEBUG );
    
    $puestoPlantillaId=getValueFromPost("puestoPlantillaId");
    $tipoTurnoPlantillaId=getValueFromPost("tipoTurnoPlantillaId");    
    $puntoServicioPlantillaId=getValueFromPost("puntoServicioPlantillaId");
    //$log->LogInfo("Valor de la variable \$puestoPlantillaId: " . var_export ($puestoPlantillaId, true));
    //$log->LogInfo("Valor de la variable \$tipoTurnoPlantillaId: " . var_export ($tipoTurnoPlantillaId, true));
    //$log->LogInfo("Valor de la variable \$generoElementoId: " . var_export ($generoElementoId, true));
    //$log->LogInfo("Valor de la variable \$puntoServicioPlantillaId: " . var_export ($puntoServicioPlantillaId, true));

    try{ 

        $lista = $negocio -> getplantillasparaselectorcontrataciones($puestoPlantillaId, $tipoTurnoPlantillaId, $puntoServicioPlantillaId);

        //$log->LogInfo("Valor de la variable lista: " . var_export ($lista, true));
        
     $response ["datos"] = $lista;
        //$log->LogInfo("Valor de la variable \$response: " . var_export ($response, true));


}catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] = "No se pudieron obtener Datos";
    }
}

echo json_encode ($response);
?>
