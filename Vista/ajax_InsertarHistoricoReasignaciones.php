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
//$log = new KLogger ( "form_RegistroNuEvaAsignacion.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable \$_POST: " . var_export ($_POST, true));

if (!empty ($_POST))
{
    $numeroeconomico=$_POST['numeroeconomico'];
    $CuentaConGifHistorico=$_POST['CuentaConGifHistorico'];
    try
    {
        $negocio -> negocio_InsertarEnHistorico($numeroeconomico,$CuentaConGifHistorico);
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

