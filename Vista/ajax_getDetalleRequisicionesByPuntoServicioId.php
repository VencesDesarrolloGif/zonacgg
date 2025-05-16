<?php
session_start ();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
verificarInicioSesion ($negocio); 
//$log = new KLogger ( "ajax_getDetalleRequisicionesByPuntoServicioId.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable \$puntoServicioId: " . var_export ($_SESSION, true));
$response = array("status" => "success");
try{
	$puntoServicioId=getValueFromPost ("puntoServicioId");
	//$log->LogInfo("Valor de la variable \$puntoServicioId: " . var_export ($puntoServicioId, true));
	$lista= $negocio -> getDetalleRequisicionesByPuntoServicioId($puntoServicioId,1,1);
	for ($i = 0; $i < count($lista); $i++)
    {
    	$datos = array (
			"puntoServicio" => $lista [$i]["puntoServicioPlantillaId"],
    		"puestoId" =>  $lista [$i]["puestoPlantillaId"],
    		"rolId" => $lista [$i]["tipoTurnoPlantillaId"],
   		);
    $lista [$i]["cuotaDiaria"] = $negocio -> getCuotaDiariaByPerfil($datos);
        //$log->LogInfo("Valor de la variable \$lista: " . var_export ($lista, true));   
    }
	$response["lista"]= $lista;
	//$log->LogInfo("Valor de la variable \$lista: " . var_export ($response, true));
} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener consulta";
}

echo json_encode($response);

