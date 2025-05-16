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
        "message" => "No se puede generar la carta compromiso porque no se recibió un folio válido."
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
$apPaterno=$aspirante[0]["apPaternoPreseleccion"];
$apMaterno=$aspirante[0]["apMaternoPreseleccion"];
$nombre=$aspirante[0]["nombrePreseleccion"];
$codigoPostal=$aspirante[0]["cpPreseleccion"];
$calle=$aspirante[0]["callePreseleccion"];
$numeroCalle=$aspirante[0]["numeroPreseleccion"];
$colonia=$aspirante[0]["coloniaPreseleccion"];
$municipio=$aspirante[0]["municipioPreseleccion"];
$email=$aspirante[0]["emailPreseleccion"];
$telMovil=$aspirante[0]["telMovilPreseleccion"];

$pdf = new FPDI();

$pageCount = $pdf->setSourceFile("../archivos/expediente/croquis.pdf");
$tplIdx = $pdf->importPage(1);

$pdf->addPage('P', 'Letter');

$pdf->SetFont("Arial", 'B',9);

$pdf->useTemplate($tplIdx, null, null, null, null, true); 


$pdf->Text(44, 40, utf8_decode(strtoupper($nombre)." ".strtoupper($apPaterno)." ".strtoupper($apMaterno)));

$pdf->Text(135, 40, utf8_decode($telMovil));

$pdf->Text(48, 47, utf8_decode(strtoupper($calle)));

$pdf->Text(135, 47, utf8_decode($numeroCalle));

$pdf->Text(23, 62, utf8_decode(strtoupper($colonia)));
$pdf->Text(95, 62, utf8_decode(strtoupper($municipio)));
$pdf->Text(150, 62, utf8_decode($codigoPostal));


$pdf->Output();
$response = array("status" => "success");



?>

