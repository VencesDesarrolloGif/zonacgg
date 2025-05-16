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
//$log = new KLogger ( "ajaxRegistroDatosFamiliares.log" , KLogger::DEBUG );

$usuario = $_SESSION ["userLog"]["usuario"];

    $datosFamiliares = array (
    "idEntidadEmpleadoFamiliar" => getValueFromPost("numeroEmpleadoEntidad"),
    "idConsecutivoEmpleadoFamiliar" => getValueFromPost("numeroEmpleadoConsecutivo"),
    "idCategoriaEmpleadoFamiliar" => getValueFromPost("numeroEmpleadoTipo"),
    "nombreFamiliar" => strtoupper(getValueFromPost("nombreFamiliar")),
    "idParentescoFamiliar" => getValueFromPost("idParentescoFamiliar"),
    "beneficiario" => getValueFromPost("beneficiario"),
    "usuarioCapturaDatoFamiliar" => $usuario,

    );

    // $log->LogInfo("Valor de la variable \$datosFamiliares: " . var_export ($datosFamiliares, true));
    try
    {
       // $negocio -> negocio_registroDatosFamiliares($datosFamiliares);
        $negocio -> negocio_registroDatosBeneficiarioStore($datosFamiliares);
        
        $response ["status"] = "success";
        $response ["message"] = "Datos Familiares registrados Exitosamente";
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