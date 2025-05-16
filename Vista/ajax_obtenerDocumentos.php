<?php

session_start ();
 
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");

$negocio = new Negocio();

verificarInicioSesion($negocio);

//$log = new KLogger ( "ajaxConsultaDocumentos.log" , KLogger::DEBUG );
// Obtenemos los datos del empleado
$numeroEmpleadoEntidad = $_POST["numeroEmpleadoEntidadEdited"];
$numeroEmpleadoConsecutivo = $_POST["numeroEmpleadoConsecutivoEdited"];
$numeroEmpleadoTipo = $_POST ["numeroEmpleadoTipoEdited"];
$documentoId = $_POST ["tipoDocumentoDigitalizado"];
$usuario=$_SESSION ["userLog"];

//$log->LogInfo("Valor de la variable \$numeroEmpleadoEntidad: " . var_export ($numeroEmpleadoEntidad, true));
//$log->LogInfo("Valor de la variable \$numeroEmpleadoConsecutivo: " . var_export ($numeroEmpleadoConsecutivo, true));
//$log->LogInfo("Valor de la variable \$numeroEmpleadoTipo: " . var_export ($numeroEmpleadoTipo, true));

// Validamos que los datos del empleado tengan valor
if (empty($numeroEmpleadoEntidad)
    || empty ($numeroEmpleadoConsecutivo)
    || empty ($numeroEmpleadoTipo))
{
    $response = array (
        "status" => "error",
        "message" => "No se puede registrar el archivo proporcionado por que no se proporcionó un número de empleado válido."
    );
    
    echo json_encode ($response);
    
    exit;
}


// Validamos que los datos del empleado existan en la base de datos
    $empleado = $negocio -> negocio_obtenerEmpleadoPorId(
    $numeroEmpleadoEntidad, 
    $numeroEmpleadoConsecutivo, 
    $numeroEmpleadoTipo,$usuario);


    
if (empty ($empleado))
{
    $response = array (
        "status" => "error",
        "message" => "El numero de empleado proporcionado no se encuentra registrado en el sistema."
    );
    
    echo json_encode ($response);
    
    exit;
}

$empleadoId = array (
    "entidadFederativaId" => $numeroEmpleadoEntidad,
    "consecutivo" => $numeroEmpleadoConsecutivo,
    "categoriaId" => $numeroEmpleadoTipo
    );

$documentosDigitalizados = $negocio -> negocio_obtenerDocumentosDigitalizados ($empleadoId, $documentoId);

$response = array (
    "status" => "ok",
    "documentos" => $documentosDigitalizados,
    "session" => var_export($_SESSION, true),
);

//$log->LogInfo("Valor de la variable \$response: " . var_export ($response, true));


echo json_encode ($response);
?> 