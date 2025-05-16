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
//$log = new KLogger ( "ajax_EdicionFechaTerminoServicio.log" , KLogger::DEBUG );


   // $usuario = $_SESSION ["userLog"]["usuario"];

    $tipocompleto=$_POST["tipo"];
    $tipoarray=explode(" ",$tipocompleto);
    $tipo=$tipoarray[0];


    try
    {
        $resultado= $negocio -> getultimadeduccionsubida($tipo);

        $response ["datos"] = $resultado;
                
        $response ["status"] = "success";
       
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