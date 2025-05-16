<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajaxReporteRequisicines.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable \$response: " . var_export ($response, true));
$response = array("status" => "success");
$tipoBusquedaPlantilla=$_POST['tipoBusquedaPlantilla'];

try{
	$lista= $negocio -> getRequisicionesFromVentas($tipoBusquedaPlantilla);

    for($i = 0; $i < count($lista); $i++){   
        $servicioPlantillaId = $lista[$i] ["servicioPlantillaId"];
        $puntoServicioPlantillaId = $lista[$i] ["puntoServicioPlantillaId"];
        $puntoServicio = $lista[$i] ["puntoServicio"];
        $numeroCentroCosto = $lista[$i] ["numeroCentroCosto"];
        $razonSocial = $lista[$i] ["razonSocial"];
        $numeroElementos = $lista[$i] ["numeroElementos"];
        $descripcionPuesto = $lista[$i] ["descripcionPuesto"];
        $descripcionTurno = $lista[$i] ["descripcionTurno"];            
        $fechaInicio = $lista[$i] ["fechaInicio"];
        $nombreEntidadFederativa = $lista[$i] ["nombreEntidadFederativa"];
        $fechaTerminoPlantilla = $lista[$i] ["fechaTerminoPlantilla"];
        $estatusPlantilla = $lista[$i] ["estatusPlantilla"];
        $rolOperativoPlantilla  = $lista[$i] ["rolOperativoPlantilla"];
    }
		$response["data"]= $lista;
}catch( Exception $e ){
	$response["status"]="error";
	$response["error"]="No se puedo obtener reporte";
}
echo json_encode($response);
?>