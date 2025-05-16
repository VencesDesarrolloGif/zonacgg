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
$usuario = $_SESSION ["userLog"];

verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajaxNewFactura.log" , KLogger::DEBUG );
  

if (!empty ($_POST))
{    
    $usuarioCaptura=$_SESSION ["userLog"]["usuario"];
    			
    $listaUniformes=getValueFromPost("listaUniformes");
    $mercanciaEntregada=getValueFromPost("mercanciaEntregada");
    $tipoPago=getValueFromPost("tipoPago");
    $descripcionPago=getValueFromPost("descripcionPago");
    $totalFactura=getValueFromPost("totalFactura");
    $proveedor=getValueFromPost("proveedor");    
    $facturaPagada=getValueFromPost("facturaPagada");
    $lineaNegocio=getValueFromPost("lineaNegocio");
    $entidadProducto=getValueFromPost("entidadProducto");
    //$entidadProducto=$usuarioCaptura=$_SESSION ["userLog"]["entidadFederativaUsuario"];

    //$log->LogInfo("Valor de la variable entidadProducto : " . var_export ($entidadProducto, true));
    
     
    try
    {
        $folioFactura=$listaUniformes[0]["idFactura"];
        //$log->LogInfo("Valor de la variable \$lista: " . var_export (count($listaUniformes), true));
        $negocio -> generarFactura($folioFactura,$proveedor,$lineaNegocio,$tipoPago,$descripcionPago,$listaUniformes,$totalFactura,$mercanciaEntregada,$facturaPagada,$entidadProducto);

        $response ["status"] = "success";
        $response ["message"] = "La Factura fue generada con éxito ";
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