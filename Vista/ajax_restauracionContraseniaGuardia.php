<?php

require_once ("Helpers.php");
require_once("../Negocio/Negocio.class.php");
$negocio = new Negocio ();
$response = array ();

if (!empty ($_POST))
{
//$log = new KLogger ( "ajax_restauracionContraseniaFirmaInterna.log" , KLogger::DEBUG );

    $contrasenia=getValueFromPost("contrasenia");
    $usuarioGuardia=getValueFromPost("usuarioGuardia");
    $correo=getValueFromPost("correo");
//    $log->LogInfo("Valor de la variable tipoEmpleadoFirma: " . var_export ($tipoEmpleadoFirma, true));
    try
    {
        $negocio -> restaurarContraseniaOaraGuardia($contrasenia,$usuarioGuardia,$correo);
        
        $response ["status"] = "success";
        $response ["message"] = "Se ha registrado la nueva contraseña para la contraseña del guardia";
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