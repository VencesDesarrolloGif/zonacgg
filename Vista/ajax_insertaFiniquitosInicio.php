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
//$log = new KLogger ( "ajaxInsertaFiniquito.log" , KLogger::DEBUG );

    

    $folioBaja=getValueFromPost("folioTxtBaja");

    // $log->LogInfo("Valor de la variable \$folioBaja: " . var_export ($folioBaja, true));
    try
    {
        $negocio -> negocio_insertarFiniquito($folioBaja);
                
        $response ["status"] = "success";
        $response ["message"] = "Confirmación finalizada";
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