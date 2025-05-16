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
$log = new KLogger ( "ajax_InsertarHistorico.log" , KLogger::DEBUG );
$log->LogInfo("Valor de la variable Vehiculo: " . var_export ($_POST, true));

if (!empty ($_POST))
{
    $usuarioCapturaHISTORICO=$_SESSION ["userLog"]["usuario"];
    $pais = strtoupper(getValueFromPost("paishiden"));
    if($pais=="null" or $pais=="NULL" or $pais==null or $pais==NULL or $pais=="SIN PAIS" or $pais==""){
       $pais = "0"; 
    }

	$VehiculoHistoricoEdicion = array (
    "selLineaDeNegocioHidenHistorico" => strtoupper(getValueFromPost("selLineaDeNegocioHiden")),
    "selEntidadHidenHistorico" => strtoupper(getValueFromPost("selEntidadHiden")),
    "tarjetchidenHistorico" => strtoupper(getValueFromPost("tarjetchiden")),
    "numeroeconomicoconsultaHistorico" => strtoupper(getValueFromPost("numeroeconomicoconsulta")),
    "tienemotorhidenHistorico" => strtoupper(getValueFromPost("tienemotorhiden")),
    "paishidenHistorico" => $pais,
    "fechainiciotarjetahidenHistorico" => strtoupper(getValueFromPost("fechainiciotarjetahiden")),
    "fechaterminotarjetahidenHistorico" => strtoupper(getValueFromPost("fechaterminotarjetahiden")),
    "numeropolizahidenHistorico" => strtoupper(getValueFromPost("numeropolizahiden")),
    "colorengomadohidenHistorico" => strtoupper(getValueFromPost("colorengomadohiden")),
    "numeroplacashidenHistorico" => strtoupper(getValueFromPost("numeroplacashiden")),
    "fototarjetahidenHistorico" => strtoupper(getValueFromPost("fototarjetahiden")),
    "fotopolizahidenHistorico" => strtoupper(getValueFromPost("fotopolizahiden")),
    "fotofacturahidenHistorico" => strtoupper(getValueFromPost("fotofacturahiden")),
    "numeromotrohidenHistorico" => strtoupper(getValueFromPost("numeromotrohiden")),
    "inpNumeroTarjetaLLavehidenHistorico" => strtoupper(getValueFromPost("inpNumeroTarjetaLLavehiden")),
    "inpNumeroTarjetaGasolinahidenHistorico" => strtoupper(getValueFromPost("inpNumeroTarjetaGasolinahiden")),
    "inpNIPhidenHistorico" => strtoupper(getValueFromPost("inpNIPhiden")),
    "selAseguradorahidenHistorico" => strtoupper(getValueFromPost("selAseguradorahiden")),
    "selTipoDePolizahidenHistorico" => strtoupper(getValueFromPost("selTipoDePolizahiden")),
    "selFechaIniciPolizaHidenHistorico" => strtoupper(getValueFromPost("selFechaIniciPolizaHiden")),
    "selFechaFinPolizaHidenHistorico" => strtoupper(getValueFromPost("selFechaFinPolizaHiden")),
    "usuarioCapturavehiculoHistorico" => $usuarioCapturaHISTORICO,

    ); 
   $log->LogInfo("Valor de la variable Vehiculo: " . var_export ($VehiculoHistoricoEdicion, true));
    try
    {
        $negocio -> HistoricoEdiconVehiculo($VehiculoHistoricoEdicion); 
        $response ["status"] = "success";
        $response ["message"] = "Vehiculo Registrado Éxitosamente";

        
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
