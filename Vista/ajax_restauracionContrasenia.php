<?php

require_once ("Helpers.php");
require_once("../Negocio/Negocio.class.php");

$negocio = new Negocio ();

$response = array ();


if (!empty ($_POST))
{
//$log = new KLogger ( "ajax_restaurarContra.log" , KLogger::DEBUG );

    $usuario=getValueFromPost("user");
    $contrasenia=getValueFromPost("contrasenia");
    $contrasenia2=getValueFromPost("contrasenia2");

    //$log->LogInfo("Valor de la variable \$usuario: " . var_export ($usuario, true));
    try
    {
        $negocio -> restaurarContraseniaByUsuario($usuario,$contrasenia, $contrasenia2);
        
        $response ["status"] = "success";
        $response ["message"] = "Se ha registrado la nueva contraseña para el usuario";
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