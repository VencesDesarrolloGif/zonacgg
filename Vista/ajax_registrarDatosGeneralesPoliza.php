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
// $log = new KLogger ( "ajax_registrarDatosGeneralesPoliza.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable post: " . var_export ($_POST, true));
if (!empty ($_POST))
{

    $cantidadPT = strtoupper(getValueFromPost("inpCantidadPerdidaTotal"));
    if($cantidadPT=="null" or $cantidadPT=="NULL" or $cantidadPT==null or $cantidadPT==NULL or $cantidadPT=="SIN cantidadPT" or $cantidadPT==""){
       $cantidadPT = "0"; 
    }
    
    $selAparadaCristales = getValueFromPost("selAparadaCristales");
    if($selAparadaCristales=="null" or $selAparadaCristales=="NULL" or $selAparadaCristales==null or $selAparadaCristales==NULL or $selAparadaCristales==""){
       $selAparadaCristales = "0"; 
    }
    $selAparadaProteccionLegal = getValueFromPost("selAparadaProteccionLegal");
    if($selAparadaProteccionLegal=="null" or $selAparadaProteccionLegal=="NULL" or $selAparadaProteccionLegal==null or $selAparadaProteccionLegal==NULL or $selAparadaProteccionLegal==""){
       $selAparadaProteccionLegal = "0"; 
    }
    $selAparadaClub = getValueFromPost("selAparadaClub");
    if($selAparadaClub=="null" or $selAparadaClub=="NULL" or $selAparadaClub==null or $selAparadaClub==NULL or $selAparadaClub==""){
       $selAparadaClub = "0"; 
    }
    $inpPorcentajeCristales = strtoupper(getValueFromPost("inpPorcentajeCristales"));
    if($inpPorcentajeCristales=="null" or $inpPorcentajeCristales=="NULL" or $inpPorcentajeCristales==null or $inpPorcentajeCristales==NULL or $inpPorcentajeCristales==""){
       $inpPorcentajeCristales = "0"; 
    }
    $inpCantidadCristales = strtoupper(getValueFromPost("inpCantidadCristales"));
    if($inpCantidadCristales=="null" or $inpCantidadCristales=="NULL" or $inpCantidadCristales==null or $inpCantidadCristales==NULL or $inpCantidadCristales==""){
       $inpCantidadCristales = "0"; 
    }
    $inpCantidadPerdidaParcial = strtoupper(getValueFromPost("inpCantidadPerdidaParcial"));
    if($inpCantidadPerdidaParcial=="null" or $inpCantidadPerdidaParcial=="NULL" or $inpCantidadPerdidaParcial==null or $inpCantidadPerdidaParcial==NULL or $inpCantidadPerdidaParcial==""){
       $inpCantidadPerdidaParcial = "0"; 
    }
    $inpPorcentajeProteccionLegal = strtoupper(getValueFromPost("inpPorcentajeProteccionLegal"));
    if($inpPorcentajeProteccionLegal=="null" or $inpPorcentajeProteccionLegal=="NULL" or $inpPorcentajeProteccionLegal==null or $inpPorcentajeProteccionLegal==NULL or $inpPorcentajeProteccionLegal==""){
       $inpPorcentajeProteccionLegal = "0"; 
    }
    $inpCantidadProteccionLegal = strtoupper(getValueFromPost("inpCantidadProteccionLegal"));
    if($inpCantidadProteccionLegal=="null" or $inpCantidadProteccionLegal=="NULL" or $inpCantidadProteccionLegal==null or $inpCantidadProteccionLegal==NULL or $inpCantidadProteccionLegal==""){
       $inpCantidadProteccionLegal = "0"; 
    }
    $inpCantidadRobototal = strtoupper(getValueFromPost("inpCantidadRobototal"));
    if($inpCantidadRobototal=="null" or $inpCantidadRobototal=="NULL" or $inpCantidadRobototal==null or $inpCantidadRobototal==NULL or $inpCantidadRobototal==""){
       $inpCantidadRobototal = "0"; 
    }
    $inpPorcentajeClub = strtoupper(getValueFromPost("inpPorcentajeClub"));
    if($inpPorcentajeClub=="null" or $inpPorcentajeClub=="NULL" or $inpPorcentajeClub==null or $inpPorcentajeClub==NULL or $inpPorcentajeClub==""){
       $inpPorcentajeClub = "0"; 
    }
    $inpCantidadClub = strtoupper(getValueFromPost("inpCantidadClub"));
    if($inpCantidadClub=="null" or $inpCantidadClub=="NULL" or $inpCantidadClub==null or $inpCantidadClub==NULL or $inpCantidadClub==""){
       $inpCantidadClub = "0"; 
    }
    $inpCantidadDanosATerceros = strtoupper(getValueFromPost("inpCantidadDanosATerceros"));
    if($inpCantidadDanosATerceros=="null" or $inpCantidadDanosATerceros=="NULL" or $inpCantidadDanosATerceros==null or $inpCantidadDanosATerceros==NULL or $inpCantidadDanosATerceros==""){
       $inpCantidadDanosATerceros = "0"; 
    }
    $inpCantidadGastosMedicos = strtoupper(getValueFromPost("inpCantidadGastosMedicos"));
    if($inpCantidadGastosMedicos=="null" or $inpCantidadGastosMedicos=="NULL" or $inpCantidadGastosMedicos==null or $inpCantidadGastosMedicos==NULL or $inpCantidadGastosMedicos==""){
       $inpCantidadGastosMedicos = "0"; 
    }
    $inpCantidadAccidentes = strtoupper(getValueFromPost("inpCantidadAccidentes"));
    if($inpCantidadAccidentes=="null" or $inpCantidadAccidentes=="NULL" or $inpCantidadAccidentes==null or $inpCantidadAccidentes==NULL or $inpCantidadAccidentes==""){
       $inpCantidadAccidentes = "0"; 
    }
    
	$DatosPoliza = array (

    "selAparadaCristales" => $selAparadaCristales,
    "selAparadaProteccionLegal" => $selAparadaProteccionLegal,
    "selAparadaClub" => $selAparadaClub,
    "inpCantidadPerdidaTotal" => $cantidadPT,
    "inpPorcentajeCristales" => $inpPorcentajeCristales,
    "inpCantidadCristales" => $inpCantidadCristales,
    "inpCantidadPerdidaParcial" => $inpCantidadPerdidaParcial,
    "inpPorcentajeProteccionLegal" => $inpPorcentajeProteccionLegal,
    "inpCantidadProteccionLegal" => $inpCantidadProteccionLegal,
    "inpCantidadRobototal" => $inpCantidadRobototal,
    "inpPorcentajeClub" => $inpPorcentajeClub,
    "inpCantidadClub" => $inpCantidadClub,
    "inpCantidadDanosATerceros" => $inpCantidadDanosATerceros,
    "inpCantidadGastosMedicos" => $inpCantidadGastosMedicos,
    "inpCantidadAccidentes" => $inpCantidadAccidentes,

    "DMPTotal" => getValueFromPost("DMPTotal"),
    "Cristales" => getValueFromPost("Cristales"),
    "DMPParcial" => getValueFromPost("DMPParcial"),
    "ProteccionLegal" => getValueFromPost("ProteccionLegal"),
    "Robototal" => getValueFromPost("Robototal"),
    "Club" => getValueFromPost("Club"),
    "DanosATerceros" => getValueFromPost("DanosATerceros"),
    "GastosMedicos" => getValueFromPost("GastosMedicos"),
    "Accidentes" => getValueFromPost("Accidentes"),

    );

// $log->LogInfo("Valor de la variable DatosPoliza: " . var_export ($DatosPoliza, true));


    try
    {
        $idVehiculo = $negocio->getnumeco();
        $idVehiculoR=$idVehiculo[0];
    // 
        $negocio -> registrarDatosGenerasPoliza($DatosPoliza,$idVehiculoR); 
        $response ["status"] = "success";
        $response ["message"] = "Datos Poliza Registrado Éxitosamente";

        
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
