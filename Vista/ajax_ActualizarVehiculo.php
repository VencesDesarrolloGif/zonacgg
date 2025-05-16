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
$log = new KLogger ( "ajax_registrarvehiculo.log" , KLogger::DEBUG );
$log->LogInfo("Valor de la variable post: " . var_export ($_POST, true));
$log->LogInfo("Valor de la variable files: " . var_export ($_FILES, true));
if (!empty ($_POST))
{
    $usuarioCapturaV=$_SESSION ["userLog"]["usuario"];


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

    $pais = strtoupper(getValueFromPost("selPaisOrigen"));
    if($pais=="null" or $pais=="NULL" or $pais==null or $pais==NULL or $pais=="" or $pais=="SIN PAIS"){
       $pais = "0"; 
    }
	$EdicionVehiculo = array (
       
     
    "selLineaDeNegocioEdicion" => getValueFromPost("selLineaDeNegocio"),
    "selEntidadEdicion" => getValueFromPost("selEntidad"),
    "seltarjetacirculacionEdicion" => getValueFromPost("seltarjetacirculacion"),
    "numeroeconomicoconsultaEdicion" => strtoupper(getValueFromPost("numeroeconomicoconsulta")),
    "selCuentaConNumeroMotroEdicion" => getValueFromPost("selCuentaConNumeroMotro"),
    "selPaisOrigenEdicion" => $pais,
    "inpFechaDeIniciotarjetaEdicion" => strtoupper(getValueFromPost("inpFechaDeIniciotarjeta")),
    "inpFechaDeTerminotarjetaEdicion" => strtoupper(getValueFromPost("inpFechaDeTerminotarjeta")),
    "inpNumeroPolizaEdicion" => strtoupper(getValueFromPost("inpNumeroPoliza")),
    "selFechaIniciPolizaEdicion" => strtoupper(getValueFromPost("selFechaIniciPoliza")),
    "selFechaFinPolizaEdicion" => strtoupper(getValueFromPost("selFechaFinPoliza")),
    "selEngomadoEdicion" => getValueFromPost("selEngomado"),
    "numeroPlacasEdicion" => strtoupper(getValueFromPost("numeroPlacas")),
    "idfotoTarjetaEdicion" => $idfotoTarjeta,
    "idfotoPolizaEdicion" => $idfotoPoliza,
    "idfotoFacturaEdicion" => $idfotoFactura, 
    "inpNumeroDeMotorEdicion" => strtoupper(getValueFromPost("inpNumeroDeMotor")),
    "usuarioCapturavehiculoEdicion" => $usuarioCapturaV,
    "inpNumeroTarjetaLLaveEdicion" => strtoupper(getValueFromPost("inpNumeroTarjetaLLave")),
    "inpNumeroTarjetaGasolinaEdicion" => strtoupper(getValueFromPost("inpNumeroTarjetaGasolina")),
    "inpNIPEdicion" => strtoupper(getValueFromPost("inpNIP")),
    "selAseguradoraEdicion" => getValueFromPost("selAseguradora"),
    "selTipoDePolizaEdicion" => getValueFromPost("selTipoDePoliza"),

    ); 
        $log->LogInfo("Valor de la variable \$Vehiculo: " . var_export ($_POST, true));

    try
    {
        $negocio -> ActualizarVehiculo($EdicionVehiculo); 
        $response ["status"] = "success";
        $response ["message"] = "Vehiculo Actualizado Éxitosamente";

        
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
