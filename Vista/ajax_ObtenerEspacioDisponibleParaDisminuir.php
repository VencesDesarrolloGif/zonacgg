<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo. 
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("../libs/phpmailer/class.phpmailer.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
$response = array ();
verificarInicioSesion ($negocio);
$response = array ();
$response ["status"] = "success";

$servicioPlantillaId = $_POST["servicioPlantillaId"];
try{
    $plantillaservicioDisponible = $negocio -> ObtenerEspacioPlantillaDisminuir($servicioPlantillaId);
    $EspacioDisponible = $plantillaservicioDisponible ["EspacioDisponible"];
    $response ["datos"] = $EspacioDisponible;
    
}catch( Exception $e ){
    $response ["status"] = "error";
    $response ["message"] = "La petición es incorrecta. Por favor corregir los datos proporcionados.";
}
echo json_encode ($response);
?>