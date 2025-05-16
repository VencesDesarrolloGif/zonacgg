<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");  

 
$negocio= new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success"); 

if(!empty ($_POST))
{
  //  $log = new KLogger ( "ajaxPuestosPorTipoLinea.log" , KLogger::DEBUG );
	$tipoPuesto= getValueFromPost ("tipoPuesto");
    $lineaNegocio= getValueFromPost ("lineaNegocio");
    $Caso= getValueFromPost ("Caso");
    try{
        if($Caso =="1"){
            $puestos = $negocio -> obtenerCatalogoPuestoPorTipoPuestoPlantillaReingreso($tipoPuesto, $lineaNegocio);
        }else{
            $puestos = $negocio -> obtenerCatalogoPuestoPorTipoPuesto($tipoPuesto, $lineaNegocio);
        }
        
        $response ["puestos"] = $puestos;
   //     $log->LogInfo("Valor de la variable \$responseajax de puesto segun tipo: " . var_export ($response, true));
        
    }
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] = "No se pudieron obtener los puestos";
    }
}

echo json_encode ($response); 
?>