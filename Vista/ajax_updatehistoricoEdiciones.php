<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
$response = array ();
$datos=array();
$idEdicion=$_POST["idEdicion"];
$usuario = $_SESSION ["userLog"]["rol"];
//$dato1=array();
//$log = new KLogger ( "ajaxinsertarhistoricoediter.log" , KLogger::DEBUG );
verificarInicioSesion ($negocio);


if (!empty ($_POST))
{
    try
    {
  //  $log->LogInfo("Valor de la variable \$datastring: " . var_export ($idEdicion, true));
        
        $update = $negocio->negocio_actualizarhistoricoedicion($idEdicion,$usuario);

            $response ["status"] = "success";
            $response ["datos"] = $datos; 
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