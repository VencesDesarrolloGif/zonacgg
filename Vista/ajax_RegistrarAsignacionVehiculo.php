<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/phpmailer/class.phpmailer.php");

$negocio = new Negocio ();
$response = array ();
verificarInicioSesion ($negocio);
//$log = new KLogger ( "form_RegistroNuevaAsignacion.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable \$_POST: " . var_export ($_POST, true));
if (!empty ($_POST))
{

    $CuentaConGif=$_POST['CuentaConGif'];
    $usuarioAsignacion = $_SESSION ["userLog"]["usuario"];

    if($CuentaConGif=="si"){
    $numeroempleado=$_POST['inpNumeroEmpleado'];
    $numeroempleadoseparar = explode("-",$numeroempleado);
    $entidadFederativaId = $numeroempleadoseparar[0];
    $empleadoConsecutivoId = $numeroempleadoseparar[1];
    $empleadoCategoriaId = $numeroempleadoseparar[2];
    }else{
    $entidadFederativaId = 0;
    $empleadoConsecutivoId = 0;
    $empleadoCategoriaId = 0;
    }

    $NuevaAsignacion = array (

    "inpNumroEcoVehiculo" =>   strtoupper(getValueFromPost("inpNumroEcoVehiculo")),
    "inpNumeroPlacas" =>   strtoupper(getValueFromPost("inpNumeroPlacas")),
    "Kilometraje" =>   strtoupper(getValueFromPost("Kilometraje")),
    "motivocambio" =>   strtoupper(getValueFromPost("motivocambio")),
    "PuestoEmpleado" =>   strtoupper(getValueFromPost("PuestoEmpleado")),
    "ocultoidentidadempleado" =>   strtoupper(getValueFromPost("ocultoidentidadempleado")),
    "LicenciaEmpleado" =>   strtoupper(getValueFromPost("LicenciaEmpleado")),
    "EstatusEmpleado" =>   strtoupper(getValueFromPost("EstatusEmpleado")),
    "entidadFederativaId" => $entidadFederativaId,
    "empleadoConsecutivoId" => $empleadoConsecutivoId,
    "empleadoCategoriaId" => $empleadoCategoriaId,
    "usuarioAsignacion" => $usuarioAsignacion,
    "CuentaConGif" =>   $CuentaConGif,
    "NombreEmpleado" =>   strtoupper(getValueFromPost("NombreEmpleado")),
    "ApellidoPEmpleado" =>   strtoupper(getValueFromPost("ApellidoPEmpleado")),
    "ApellidoMEmpleado" =>   strtoupper(getValueFromPost("ApellidoMEmpleado")),
    "EntidadFEmpleado" =>   strtoupper(getValueFromPost("EntidadFEmpleado"))); 
    // $log->LogInfo("Valor de la variable \$NuevaAsignacion: " . var_export ($NuevaAsignacion, true));
    try
    {
        $negocio -> negocio_registrarAsignacion($NuevaAsignacion);
        $response ["status"] = "success";
        $response ["message"] = "Asginacion Del Vehiculo Registrado Éxitosamente";    
        
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

