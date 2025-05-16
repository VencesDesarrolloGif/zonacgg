<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");

$negocio = new Negocio ();

$response = array ();

verificarInicioSesion ($negocio);

if (!empty ($_POST))
{



    $usuario = $_SESSION ["userLog"]["usuario"];

    $usuarioId= getValueFromPost("usuarioId");

     
    try
    {
        $negocio -> bloqueoUsuario($usuarioId);
        
        $response ["status"] = "success";
        $response ["message"] = "Cuenta de usuario bloqueada";
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