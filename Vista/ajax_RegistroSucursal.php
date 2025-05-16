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
// $log = new KLogger ( "form_RegistroNuevaEmpresa.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable \$_POST: " . var_export ($_POST, true));

if (!empty ($_POST))
{
    $usuarioSucursal = $_SESSION ["userLog"]["usuario"];
    $NuevaSucursal = array (
    "clienteSucursal" =>  getValueFromPost("clienteSucursal"),
    "sellineNegociosucursal" =>  getValueFromPost("sellineNegociosucursal"),
    "selRGN" =>  getValueFromPost("selRGN"),
    "Estado" =>  getValueFromPost("Estado"),
    "Municipio" =>  getValueFromPost("Municipio"),
    "selColonia" =>  getValueFromPost("selColonia"),
    "EconomicoCliente" =>   strtoupper(getValueFromPost("txtEconomicoCliente")),
    "NumeroEconomicoSucursal" =>   strtoupper(getValueFromPost("txtNumeroEconomicoSucursal")),
    "NombreSucursal" =>   strtoupper(getValueFromPost("txtNombreSucursal")),
    "CodigoPostal" =>   strtoupper(getValueFromPost("txCodigoPostal")),
    "DireccionSucursal" =>   strtoupper(getValueFromPost("txtDireccionSucursal")),
    "latitudSucursal" =>   strtoupper(getValueFromPost("txtlatitudSucursal")),
    "LongitudSucursal" =>   strtoupper(getValueFromPost("txtLongitudSucursal")),
    "fechaAltaSucursal" =>   strtoupper(getValueFromPost("txtfechaAltaSucursal")),
    "ContactoFacturacionSucursal" =>   strtoupper(getValueFromPost("txtContactoFacturacionSucursal")),
    "CorreoFacturacionSucursal" =>   strtoupper(getValueFromPost("txtCorreoFacturacionSucursal")),
    "TelefonoFijoFacturacionSucursal" =>   strtoupper(getValueFromPost("txtTelefonoFijoFacturacionSucursal")),
    "TelefonoMovilFacturacionSucursal" =>   strtoupper(getValueFromPost("txtTelefonoMovilFacturacionSucursal")),
    "TerminosFacturacionSucursal" =>   strtoupper(getValueFromPost("txtTerminosFacturacionSucursal")),
    "ContactoTesoreriaSucursal" =>   strtoupper(getValueFromPost("txtContactoTesoreriaSucursal")),
    "CorreoTesoreriaSucursal" =>   strtoupper(getValueFromPost("txtCorreoTesoreriaSucursal")),
    "TelefonoFijoTesoreriaSucursal" =>   strtoupper(getValueFromPost("txtTelefonoFijoTesoreriaSucursal")),
    "TelefonoMovilTesoreriaSucursal" =>   strtoupper(getValueFromPost("txtTelefonoMovilTesoreriaSucursal")),
    "ContactoOperativoSucursal" =>   strtoupper(getValueFromPost("txtContactoOperativoSucursal")),
    "CorreoOperativoSucursal" =>   strtoupper(getValueFromPost("txtCorreoOperativoSucursal")),
    "TelefonoFijoOperativoSucursal" =>   strtoupper(getValueFromPost("txtTelefonoFijoOperativoSucursal")),
    "TelefonoMovilOperativoSucursal" =>   strtoupper(getValueFromPost("txtTelefonoMovilOperativoSucursal")),
    "usuarioCapturaSucursal" => $usuarioSucursal,
);    
     //$log->LogInfo("Valor de la variable \$puntoServicio: " . var_export ($puntoServicio, true));
    try
    {
        $negocio -> negocio_registrarNuevaSucursal($NuevaSucursal);
        $response ["status"] = "success";
        $response ["message"] = "Nueva Sucursal registrada éxitosamente";    
        
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

