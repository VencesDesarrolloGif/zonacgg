<?php

require_once ("Helpers.php");
require_once("../Negocio/Negocio.class.php");

$negocio = new Negocio ();

$response = array ();


if (!empty ($_POST))
{
//$log = new KLogger ( "ajax_restaurarContra.log" , KLogger::DEBUG );

    $entidad=getValueFromPost("entidadEmpleado");
    $consecutivo=getValueFromPost("consecutivoEmpleado");
    $categoria=getValueFromPost("categoriaEmpleado");

    //$log->LogInfo("Valor de la variable \$usuario: " . var_export ($usuario, true));
    try
    {
        $listaEmpleados= $negocio -> negocio_getUsuariosEmpleado($entidad,$consecutivo,$categoria);
                
        $response ["status"] = "success";
        $response ["usuarios"] = $listaEmpleados;
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