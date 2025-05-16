<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajax_getStockUniformes.log" , KLogger::DEBUG );
$response = array("status" => "success");
$entidadUsuario = $_SESSION ["userLog"]["entidadFederativaUsuario"];
$entidadUsuario1=count($entidadUsuario);

$sucursalesUsuario=$_SESSION ["userLog"]["sucursalesUsuario"];
for ($i = 0; $i < count($sucursalesUsuario); $i++) {
            $sucursalesUsr[] = $sucursalesUsuario[$i];  // Guardamos solo los idEntidad
}
$sucArreglo = implode(',', $sucursalesUsr);

try{
	for($i=0;$i<$entidadUsuario1;$i++){
        if(!is_array($entidadUsuario)){
            $entidadparaconsulta=$entidadUsuario;
        }else{
            $entidadparaconsulta=$entidadUsuario[$i];
        }
        if($entidadparaconsulta=="09"){
            $entidadparaconsulta="09";
            $i=$entidadUsuario1;
        }else{
            $entidadparaconsulta="Intruso";
        }          
    }
//	$log->LogInfo("Valor de la variable entidadparaconsulta: " . var_export ($entidadparaconsulta, true));
	if($entidadparaconsulta == '09'){
		$uniformes = $negocio ->  obtenerStockUniforme();
	}else{
		$uniformes = $negocio ->  obtenerStockUniformeEntidad($entidadUsuario,$sucArreglo);
	}
	$response["data"]= $uniformes;
} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Lista de stock uniforme";	
}
echo json_encode($response);
?>