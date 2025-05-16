<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");

$negocio = new Negocio ();

$response = array ();

verificarInicioSesion ($negocio);

if (!empty ($_POST))
{
//$log = new KLogger ( "ajaxEdicionDatosDireccion.log" , KLogger::DEBUG );


    $usuario = $_SESSION ["userLog"]["usuario"];

    $datosDireccion= array (
    "entidadEmpleadoDirectorio" =>getValueFromPost("numeroEmpleadoEntidadEdited"),
    "consecutivoEmpleadoDirectorio" => getValueFromPost("numeroEmpleadoConsecutivoEdited"),
    "categoriaEmpleadoDirectorio" => getValueFromPost("numeroEmpleadoTipoEdited"),
    "idAsentamientoDireccion" => getValueFromPost("txtIdAsentamientoEdited"),
    "calle" => strtoupper(getValueFromPost("txtCalleEdited")),
    "numeroExterior" => strtoupper(getValueFromPost("txtNumeroExtEdited")),
    "numeroInterior" => strtoupper(getValueFromPost("txtNumeroIntEdited")),
    "telefonoFijoEmpleado" => getValueFromPost("txtTelefonoFijoEdited"),
    "telefonoMovilEmpleado" => getValueFromPost("txtTelefonoMovilEdited"),
    "correoEmpleado" =>getValueFromPost("txtCorreoEdited"),
    "usuarioCapturaDireccion" => $usuario,
    "idUnidadMedicaAsignada" => getValueFromPost("txtIdUmfEdited"),
    );

     //$log->LogInfo("Valor de la variable \$datosDireccion: " . var_export ($datosDireccion, true));
    try
    {
        $negocio -> negocio_editarDatosDireccion($datosDireccion);
        
        $response ["status"] = "success";
        $response ["message"] = "Empleado registrado éxitosamente";
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