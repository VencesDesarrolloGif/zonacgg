<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio (); 


$response = array ();
$response ["status"] = "error";

verificarInicioSesion ($negocio);
// $log = new KLogger ( "ajaxNewFactura.log" , KLogger::DEBUG );
  

if (!empty ($_POST))
{    
    $usuarioCaptura=$_SESSION ["userLog"]["usuario"];
    			
    $listaUniLavanderia=getValueFromPost("listaUniformes");
    $folioLavanderia=getValueFromPost("folioLavanderia");
    $totalEnvio=getValueFromPost("totalLavanderia");    
    $entidadEnvio=$usuarioCaptura=$_SESSION ["userLog"]["entidadFederativaUsuario"];
    
    
     
    try
    {        
        //$log->LogInfo("Valor de la variable \$lista: " . var_export (count($listaUniformes), true));
        $negocio -> negocio_enviarLavanderia($folioLavanderia,$entidadEnvio,$totalEnvio,$listaUniLavanderia);

        $response ["status"] = "success";
        $response ["message"] = "Envio realizado con éxito";
        //$log->LogInfo("Valor de la variable \$datos: " . var_export ($datos, true));

        
    } 
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }
}

echo json_encode ($response);
?> 