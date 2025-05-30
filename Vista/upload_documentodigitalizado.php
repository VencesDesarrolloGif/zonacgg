<?php

session_start ();

require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");

$negocio = new Negocio();

verificarInicioSesion($negocio);


// Obtenemos los datos del empleado
$numeroEmpleadoEntidad = $_POST["numeroEmpleadoEntidad"];
$numeroEmpleadoConsecutivo = $_POST["numeroEmpleadoConsecutivo"];
$numeroEmpleadoTipo = $_POST ["numeroEmpleadoTipo"];
$documentoId = $_POST ["tipoDocumentoDigitalizado"];
$usuario = $_SESSION ["userLog"]["usuario"]; 


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


$keyOfFileUpload = "documentoDigitalizado";


$target_dir = dirname (__FILE__) . 
    DIRECTORY_SEPARATOR . "uploads" . 
    DIRECTORY_SEPARATOR . "documentosdigitalizados" . 
    DIRECTORY_SEPARATOR;
    
$target_file = $target_dir . 
    date("Ymd_His") . "_" . 
    sha1(basename($_FILES[$keyOfFileUpload]["name"]));

$archivo = $_FILES[$keyOfFileUpload]["name"];
$temporal = $_FILES[$keyOfFileUpload]["tmp_name"];


if (!is_uploaded_file($_FILES[$keyOfFileUpload]['tmp_name']))
{
    $response = array (
        "status" => "error",
        "message" => "El archivo no pudo subirse en el servidor. Probablemente el archivo es mayor al limite permitido."
    );
    
    echo json_encode ($response);
    
    exit;
}

if (!move_uploaded_file($_FILES[$keyOfFileUpload]["tmp_name"], $target_file)) 
{
    $response = array (
        "status" => "error",
        "message" => "El archivo no pudo guardarse en el servidor. Error del servidor o el archivo no es válido."
    );
    
    echo json_encode ($response);
    
    exit;
}


$documentacion = array (
    "empleadoEntidadFederativaId" => $numeroEmpleadoEntidad,
    "empleadoConsecutivo" => $numeroEmpleadoConsecutivo,
    "empleadoCategoriaId" => $numeroEmpleadoTipo,
    "documentoId" => $documentoId,
    "tipoDocumentoId" => 1,
    "documentoEstatusId" => 1,
    "nombreArchivoSeleccionado" => $archivo,
    "nombreArchivoGuardado" => $target_file
);

$negocio -> negocio_registrarDocumentosDigitalizados($documentacion);

$empleadoId = array (
    "entidadFederativaId" => $numeroEmpleadoEntidad,
    "consecutivo" => $numeroEmpleadoConsecutivo,
    "categoriaId" => $numeroEmpleadoTipo
    );

$documentosDigitalizados = $negocio -> negocio_obtenerDocumentosDigitalizados ($empleadoId, $documentoId);

$response = array (
    "status" => "ok",
    "message" => "Archivo: '" . $archivo . "' almacenado correctamente en el servidor",
    "documentos" => $documentosDigitalizados,
    "session" => var_export($_SESSION, true),
);


echo json_encode ($response);
?> 