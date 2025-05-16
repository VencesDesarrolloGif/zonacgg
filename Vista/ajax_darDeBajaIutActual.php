<?php
session_start();
require_once("../Negocio/Negocio.class.php"); 
require_once ("Helpers.php");
$negocio= new Negocio();
verificarInicioSesion ($negocio);
$response = array("status" => "success");
$NumEmpModal= getValueFromPost ("NumEmpModalBaja");
$constraseniaFirma= getValueFromPost ("constraseniaFirma");
$ComentarioBajaTarjeta= getValueFromPost ("ComentarioBajaTarjeta");
$txtnumeroIutEdited= getValueFromPost ("txtnumeroIutEdited");
$usuario=$_SESSION ["userLog"]["usuario"];
//$log = new KLogger ( "ajaxGetFirmaSolicitada.log" , KLogger::DEBUG );

try{

    $negocio -> UpdateBajaTarjetaDespensa($NumEmpModal, $constraseniaFirma,$ComentarioBajaTarjeta,$txtnumeroIutEdited,$usuario);
    //$log->LogInfo("Valor de la variable \$responseajax de puntos segun tipo: " . var_export ($response, true));
    
}
catch (Exception $e)
{
    $response ["status"] = "error";
    $response ["message"] = "No se pudieron obtener los puntos"; 
}

echo json_encode ($response);
?>