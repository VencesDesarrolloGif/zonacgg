<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio (); 
$response = array ();
$response ["status"] = "error"; 

verificarInicioSesion ($negocio);
// $log = new KLogger ( "ajax_registrarDatosGeneralesAccesorios.log" , KLogger::DEBUG );
   // $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));

if (!empty ($_POST))
{
    
	$AccesorosVehiculos = array (
    "DesarmadorC" => getValueFromPost("DesarmadorC"),
    "DesarmadorP" => getValueFromPost("DesarmadorP"),
    "Cables" => getValueFromPost("Cables"),
    "Senal" => getValueFromPost("Senal"),
    "Llave" => getValueFromPost("Llave"),
    "Llanta" => getValueFromPost("Llanta"),
    "Gato" => getValueFromPost("Gato"),
    "CLlave" => getValueFromPost("CLlave"),
    "TarjetaLlave" => getValueFromPost("TarjetaLlave"),
    "TarjetaGasolina" => getValueFromPost("TarjetaGasolina"),
    "inpNumeroTarjetaLLave" =>   strtoupper(getValueFromPost("inpNumeroTarjetaLLave")),
    "inpNumeroTarjetaGasolina" =>   strtoupper(getValueFromPost("inpNumeroTarjetaGasolina")),
    "inpNIP" =>   strtoupper(getValueFromPost("inpNIP")),
    );
    try
    {
        $idVehiculoaccesorios = $negocio->getnumeco();
        $idVehiculoaccesoriosR=$idVehiculoaccesorios[0];

   // $log->LogInfo("Valor de la variable AccesorosVehiculos: " . var_export ($AccesorosVehiculos, true));

        $negocio -> registrarAccesoriosVehiculo($AccesorosVehiculos,$idVehiculoaccesoriosR); 
        $response ["status"] = "success";
        $response ["message"] = "Accesorios Registrados Éxitosamente";

        
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
