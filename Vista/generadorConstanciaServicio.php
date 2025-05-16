<?php
session_start();
use setasign\Fpdi\Fpdi;
require_once('../libs/fpdi/src/autoload.php');
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
require('../libs/fpdf/fpdf.php');
// require('../libs/fpdi/fpdi.php');

//$log = new KLogger ( "generarCartaPatronal.log" , KLogger::DEBUG );

$negocio = new Negocio();
$response = array ();

verificarInicioSesion ($negocio);

$folio=$_GET["folioAspirante"];


if (empty($folio))
{

    $response = array (
        "status" => "error",
        "message" => "No se puede generar la solicitud de empleo porque no se recibió un folio válido."
    );
    
    echo json_encode ($response);
    
    exit;
}

//$log -> LogInfo ("entidadEmpleado ".var_export ($empleadoEntidad, true));
//$log -> LogInfo ("consecutivoEmpleado ".var_export ($empleadoConsecutivo, true));
//$log -> LogInfo ("empleadoTipo ".var_export ($empleadoTipo, true));


$aspirante= $negocio -> negocio_obtenerAspirante($folio);

if (empty ($aspirante))
{
    $response = array (
        "status" => "error",
        "message" => "El folio del aspirante no se encuentra registrado en el sistema."
    );
    
    echo json_encode ($response);
    
    exit;
}

//$log->LogInfo("Valor de la variable \$response empleado: " . var_export ($response, true));
//$log->LogInfo("Valor de la variable \$empleado empleado: " . var_export ($response["empleado"][0]["apellidoPaterno"], true));
//$log->LogInfo("Valor de la variable \$apellido paterno empleado: " . var_export ($response["empleado"]["apellidoPaterno"], true));
date_default_timezone_set('America/Mexico_City'); //Asignas la zona horaria de tu país.
setlocale(LC_TIME, 'spanish'); //Fijamos el tiempo local

//echo “Hoy es:”.$diaSemana; //Imprimimos El día.





$pdf = new FPDI();

$pageCount = $pdf->setSourceFile("../archivos/expediente/constanciaServicio.pdf");
$tplIdx = $pdf->importPage(1);

$pdf->addPage('P', 'Letter');

$pdf->useTemplate($tplIdx, null, null, null, null, true); 






$entidadCod = $_SESSION ["userLog"]["entidadFederativaUsuario"];
$entidad = $_SESSION ["userLog"]["nombreEntidad"];




$pdf->Output();
$response = array("status" => "success");



?>

