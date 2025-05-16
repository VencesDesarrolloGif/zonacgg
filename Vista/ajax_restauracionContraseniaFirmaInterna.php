<?php

require_once ("Helpers.php");
require_once("../Negocio/Negocio.class.php");
$negocio = new Negocio ();
$response = array ();

if (!empty ($_POST))
{
//$log = new KLogger ( "ajax_restauracionContraseniaFirmaInterna.log" , KLogger::DEBUG );

    $contrasenia=getValueFromPost("contrasenia");
    $entidadEmpleadoFirma=getValueFromPost("entidadEmpleadoFirma");
    $consecutivoEmpleadoFirma=getValueFromPost("consecutivoEmpleadoFirma");
    $tipoEmpleadoFirma=getValueFromPost("tipoEmpleadoFirma");
//    $log->LogInfo("Valor de la variable tipoEmpleadoFirma: " . var_export ($tipoEmpleadoFirma, true));
    try
    {
        $negocio -> restaurarContraseniaFrimaElectronicaint($contrasenia,$entidadEmpleadoFirma, $consecutivoEmpleadoFirma, $tipoEmpleadoFirma);
        
        $response ["status"] = "success";
        $response ["message"] = "Se ha registrado la nueva contraseña para la firma electronica interna";
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