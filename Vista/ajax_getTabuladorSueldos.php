<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();
 
verificarInicioSesion ($negocio);
// $log = new KLogger ( "ajaxConsultaEmpleadosByPuntoServicio.log" , KLogger::DEBUG );
$accion=$_POST["accion"];
$lineanegocioo10=$_POST["lineanegocioo10"];
$lineanegocioo20=$_POST["lineanegocioo20"];
$response = array("status" => "success");

try{

	if($accion==0 ){
		$lista= $negocio -> getTabuladorSueldos($lineanegocioo10,$lineanegocioo20);
		// $log->LogInfo("Valor de la variable lista " . var_export ($lista, true));
		for($i = 0; $i < count($lista); $i++){
			$puntoServicioPlantillaId = $lista[$i]["puntoServicioPlantillaId"];
			$puestoPlantillaId = $lista[$i]["puestoPlantillaId"];
			$tipoTurnoPlantillaId = $lista[$i]["tipoTurnoPlantillaId"];
			$sueldo = $lista[$i]["sueldo"];
			$puntoServicio = $lista[$i]["puntoServicio"];
			$esatusPunto = $lista[$i]["esatusPunto"];
			if($sueldo==null){
                $lista[$i]["sueldo"]="NO DEFINIDO";
            }
            if($esatusPunto==1){
                $lista[$i]["esatusPunto"]="ACTIVO";
            }else{
                $lista[$i]["esatusPunto"]="INACTIVO";
            }
        	$lista[$i]["Archivo"]="<img style='width: 45%' title='Editar Registro De Sueldo'src='img/editarLapiz.jpg' class='cursorImg' onclick=EditarRegistroSueldoPuntosServicio('$puntoServicioPlantillaId','$puestoPlantillaId','$tipoTurnoPlantillaId','$sueldo')>";

    	}
	}else if( $accion==1){
		$lista= $negocio -> getTabuladorSueldosPlantillasinactivas($lineanegocioo10,$lineanegocioo20);
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

