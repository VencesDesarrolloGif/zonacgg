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

    $costoNuevo=$_POST["costoNuevo"];
    $idEventual=$_POST["idEventual"];

//$log = new KLogger ( "ajaxRegistroEventual.log" , KLogger::DEBUG );

    $usuario = $_SESSION ["userLog"]["usuario"];



     
    try
    {
        $negocio -> negocio_actualizarCostoEventual($idEventual,$costoNuevo);
        
        $response ["status"] = "success";
        $response ["message"] = "Costo actualizado con éxito";
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