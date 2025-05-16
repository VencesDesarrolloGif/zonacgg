<?php

require_once ("Helpers.php");
require_once("../Negocio/Negocio.class.php");

$negocio = new Negocio ();

$response = array ();


if (!empty ($_POST))
{
//$log = new KLogger ( "ajax_restaurarContra.log" , KLogger::DEBUG );

    $usuario=getValueFromPost("usuario");
   

    //$log->LogInfo("Valor de la variable \$usuario: " . var_export ($usuario, true));
    try
    {
        $rolUsuario= $negocio -> negocio_getrolUsuariosEmpleado($usuario);
                
        $response ["status"] = "success";
        $response ["rolusuario"] = $rolUsuario;
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