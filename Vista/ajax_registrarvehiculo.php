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
// $log = new KLogger ( "ajax_registrarvehiculo.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable post: " . var_export ($_POST, true));
if (!empty ($_POST))
{
    $usuarioCapturaV=$_SESSION ["userLog"]["usuario"];

	$idfotoVehiculo = getValueFromPost("idfotoVehiculo");
	$target_dir = dirname (__FILE__) . 
        DIRECTORY_SEPARATOR . "uploads" . 
        DIRECTORY_SEPARATOR . "ParqueVehicular" .
        DIRECTORY_SEPARATOR . "fotosvehiculos" .  
        DIRECTORY_SEPARATOR;
	
	$target_file = $target_dir . $idfotoVehiculo;

    $idfotoTarjeta = getValueFromPost ("idfotoTarjeta");
    $target_dir1 = dirname (__FILE__) . 
        DIRECTORY_SEPARATOR . "uploads" . 
        DIRECTORY_SEPARATOR . "ParqueVehicular" . 
        DIRECTORY_SEPARATOR . "fotostarjetacirculacion" . 
        DIRECTORY_SEPARATOR;
    
    $target_file1 = $target_dir1 . $idfotoTarjeta;

    $idfotoPoliza = getValueFromPost ("idfotoPoliza");
    $target_dir2 = dirname (__FILE__) . 
        DIRECTORY_SEPARATOR . "uploads" . 
        DIRECTORY_SEPARATOR . "ParqueVehicular" .
        DIRECTORY_SEPARATOR . "fotospolizaseguros" .  
        DIRECTORY_SEPARATOR;
    
    $target_file2 = $target_dir2 . $idfotoPoliza;

    $idfotoFactura = getValueFromPost ("idfotoFactura");
    $target_dir3 = dirname (__FILE__) . 
        DIRECTORY_SEPARATOR . "uploads" . 
        DIRECTORY_SEPARATOR . "ParqueVehicular" . 
        DIRECTORY_SEPARATOR . "fotosfacturascarros" . 
        DIRECTORY_SEPARATOR;
    
    $target_file3 = $target_dir3 . $idfotoFactura;
	
	if (!file_exists ($target_file))
	{
		$idfotoVehiculo = "";
	}
    if (!file_exists ($target_file1))
    {
        $idfotoTarjeta = "";
    }
    if (!file_exists ($target_file2))
    {
        $idfotoPoliza = "";
    }
    if (!file_exists ($target_file3))
    {
        $idfotoFactura = "";
    }


    $pais = getValueFromPost("selPaisOrigen");

    if($pais=="null" or $pais=="NULL" or $pais==null or $pais==NULL or $pais==""){
       $pais = "0"; 
    }
    $inpFechaDeIniciotarjeta = getValueFromPost("inpFechaDeIniciotarjeta");
    $inpFechaDeTerminotarjeta = getValueFromPost("inpFechaDeTerminotarjeta");

	$Vehiculo = array (
        
    "inpCentimetrosCubicos" => strtoupper(getValueFromPost("inpCentimetrosCubicos")),  
    "selCilindrosDelVehiculo" => getValueFromPost("selCilindrosDelVehiculo"),
    "selempresaexterno" => getValueFromPost("selempresaexterno"),
    "seltarjetacirculacion" => getValueFromPost("seltarjetacirculacion"),
    "selCuentaConNumeroMotro" => getValueFromPost("selCuentaConNumeroMotro"),
    "selPaisOrigen" => $pais,
    "selVehiculoNuevoViejo" => getValueFromPost("selVehiculoNuevoViejo"),
    "selAseguradora" => getValueFromPost("selAseguradora"),
    "selTipoDePoliza" => getValueFromPost("selTipoDePoliza"),
    "inpFechaDeIniciotarjeta" => strtoupper(getValueFromPost("inpFechaDeIniciotarjeta")),
    "inpFechaDeTerminotarjeta" => strtoupper(getValueFromPost("inpFechaDeTerminotarjeta")),
    "inpNumeroPoliza" => strtoupper(getValueFromPost("inpNumeroPoliza")),
    "selFechaIniciPoliza" => strtoupper(getValueFromPost("selFechaIniciPoliza")),
    "selFechaFinPoliza" => strtoupper(getValueFromPost("selFechaFinPoliza")),
    "selEngomado" => getValueFromPost("selEngomado"),
    "selColor" => getValueFromPost("selColor"),
    "fechaingreso" => getValueFromPost("fechaingreso"),
    "selPlacas" => getValueFromPost("selPlacas"),
    "selModalidad" => getValueFromPost("selModalidad"),
    "numeroPlacas" => strtoupper(getValueFromPost("numeroPlacas")),
    "selMarca" => getValueFromPost("selMarca"),
    "selModelo" => getValueFromPost("selModelo"),
    "selTipoDeVehiculo" => getValueFromPost("selTipoDeVehiculo"),
    "idfotoVehiculo" => $idfotoVehiculo,
    "idfotoTarjeta" => $idfotoTarjeta,
    "idfotoPoliza" => $idfotoPoliza,
    "idfotoFactura" => $idfotoFactura,
    "inpAnio" => strtoupper(getValueFromPost("inpAnio")),
    "inpNumeroDeSerie" => strtoupper(getValueFromPost("inpNumeroDeSerie")),
    "inpNumeroDeMotor" => strtoupper(getValueFromPost("inpNumeroDeMotor")),
    "fechaCompra" => getValueFromPost("fechaCompra"),
    "selLineaDeNegocio" => getValueFromPost("selLineaDeNegocio"),
    "selEntidad" => getValueFromPost("selEntidad"),
    "usuarioCapturavehiculo" => $usuarioCapturaV,

    ); 
        // $log->LogInfo("Valor de la variable Vehiculo: " . var_export ($Vehiculo, true));

    try
    {
        $negocio -> registrarVehiculo($Vehiculo); 
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
