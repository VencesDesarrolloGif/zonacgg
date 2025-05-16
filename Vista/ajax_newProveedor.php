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
$usuario = $_SESSION ["userLog"]["usuario"];

verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajaxNewProveedor.log" , KLogger::DEBUG );
  

if (!empty ($_POST))
{
    
    $usuarioCaptura=$_SESSION ["userLog"]["usuario"];
            
    $datos = array (
    "numeroContableProv" => getValueFromPost("txtNumeroContable"),
    "nombreProveedor" => getValueFromPost("nombreProveedor"),
    "rfcProveedor" => getValueFromPost("rfcProveedor"),
    "contactoProveedor" => getValueFromPost("contactoProveedor"),
    "bancoProveedor" => getValueFromPost("selectBancoProv"),
    "noCuentaProveedor" => getValueFromPost("noCuentaProveedor"),
    "ctaProveedor" => getValueFromPost("ctaProveedor"),    
    "telefonoProveedor" => getValueFromPost("telefonoProveedor"),
    "correoProveedor" => getValueFromPost("correoProveedor"),
    "domicilioProveedor" => getValueFromPost("domicilioProveedor"),

    );

    

     
    try
    {

        $negocio -> newProveedor($datos);
               
        $response ["status"] = "success";
        $response ["message"] = "El proveedor <strong>".$datos["nombreProveedor"]."</strong> fue registrado con éxito ";
        //$log->LogInfo("Valor de la variable \$datos: " . var_export ($datos, true));

        
    } 
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }
}
else
{    
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}

echo json_encode ($response);
?>
