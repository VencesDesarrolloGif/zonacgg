<?php
session_start();


require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
verificarInicioSesion ($negocio);
use setasign\Fpdi\Fpdi;
require_once('../libs/fpdi/src/autoload.php');

//require "../conexion/conexion.php";
//require_once "../../libs/logger/KLogger.php";
require_once "../libs/numLetras/numeroLetras.php";
require '../libs/fpdf/fpdf.php';
// require '../libs/fpdi/fpdi.php';
//$log = new KLogger("generadordocBajaEmpleadoRh.log", KLogger::DEBUG); 
setlocale(LC_ALL, 'es_ES');
$fechaDia = strftime("%d");
$fechaMes = strftime("%B");
$fechaAnio = strftime("%Y");
$EntidadTreabajoRh    = $_GET["EntidadTreabajoRh"];
$NumeroEmpleadoModal    = $_GET["NumeroEmpleadoModal"];
$NombreEmpleadoModal    = $_GET["NombreEmpleadoModal"];
$NombreSolicitanteRh    = $_GET["NombreSolicitanteRh"];
$FirmaInternaGuardiaRh    = $_GET["FirmaInternaGuardiaRh"];
$FirmaInternaRh    = $_GET["FirmaInternaRh"];
$pdf                       = new FPDI();
$numletras                 = new NumeroALetras();
$pageCount                 = $pdf->setSourceFile("uploads/ArchivosBaja/RENUNCIAS DE GIF SEGURIDAD 1.pdf");
$tplIdx                    = $pdf->importPage(1);
$pdf->addPage('P', 'Letter');
$pdf->useTemplate($tplIdx, null, null, null, null, true);
$pdf->SetFont("Arial", 'B', 9);
$pdf->SetXY(50, 47);
$pdf->Text(22, 19, utf8_decode($EntidadTreabajoRh));
$pdf->Text(107, 19, utf8_decode($fechaDia));
$pdf->Text(140, 19, utf8_decode($fechaMes));
$pdf->Text(169, 19, utf8_decode($fechaAnio));
$pdf->Text(65, 81, utf8_decode($NombreEmpleadoModal));
$pdf->Text(53, 87, utf8_decode($NumeroEmpleadoModal));
$pdf->Text(80, 240, utf8_decode($NombreEmpleadoModal));
$pdf->Text(77, 245, utf8_decode($FirmaInternaGuardiaRh));
//$pdf->Text(85, 245, utf8_decode($NombreEmpleadoModal));

$pdf->Output();
$response = array("status" => "success");
