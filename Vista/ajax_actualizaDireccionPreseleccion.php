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
//$log = new KLogger ( "ajaxRegistroDatosDireccion.log" , KLogger::DEBUG );

    

    $datosDireccion= array (
    "folio" => getValueFromPost("folioConsulta"),
    "codigoPostal" => getValueFromPost("txtCP"),
    "municipio" => getValueFromPost("municipioTexto"),
    "calle" => strtoupper(getValueFromPost("txtCalle")),
    "colonia" => strtoupper(getValueFromPost("coloniaTexto")),
    "numeroExterior" => getValueFromPost("txtNumeroExt"),
    "telefonoFijoEmpleado" => getValueFromPost("txtTelefonoFijo"),
    "telefonoMovilEmpleado" => getValueFromPost("txtTelefonoMovil"),
    "correoEmpleado" =>getValueFromPost("txtCorreo"),    
    );
     
    try
    {
        $negocio -> negocio_actualizaDireccionPreseleccion($datosDireccion);
        
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