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
// $log = new KLogger ( "ajaxRegistroDatosDireccion.log" , KLogger::DEBUG );


    $usuario = $_SESSION ["userLog"]["usuario"];

    $datosDireccion= array (
    "entidadEmpleadoDirectorio" =>getValueFromPost("numeroEmpleadoEntidad"),
    "consecutivoEmpleadoDirectorio" => getValueFromPost("numeroEmpleadoConsecutivo"),
    "categoriaEmpleadoDirectorio" => getValueFromPost("numeroEmpleadoTipo"),
    "idAsentamientoDireccion" => getValueFromPost("txtIdAsentamiento"),
    "calle" => strtoupper(getValueFromPost("txtCalle")),
    "numeroExterior" => strtoupper(getValueFromPost("txtNumeroExt")),
    "numeroInterior" => strtoupper(getValueFromPost("txtNumeroInt")),
    "telefonoFijoEmpleado" => getValueFromPost("txtTelefonoFijo"),
    "telefonoMovilEmpleado" => getValueFromPost("txtTelefonoMovil"),
    "correoEmpleado" =>getValueFromPost("txtCorreo"),
    "usuarioCapturaDireccion" => $usuario,
    "idUnidadMedicaAsignada" => getValueFromPost("txtIdUmf"),
    );

     // $log->LogInfo("Valor de la variable \$datoPersonal: " . var_export ($datosDireccion, true));
    try
    {
        $negocio -> negocio_registroDatosDireccion($datosDireccion);
        
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