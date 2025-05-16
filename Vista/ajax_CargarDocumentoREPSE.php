<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
require_once "../libs/numLetras/numeroLetras.php";
require('../libs/fpdf/fpdf.php');
// require('../libs/fpdi/fpdi.php');
use setasign\Fpdi\Fpdi;
require_once('../libs/fpdi/src/autoload.php');
//$log = new KLogger ( "ajax_cargaPapeletaDeuda.log" , KLogger::DEBUG );
$negocio = new Negocio();
$response = array ();
verificarInicioSesion ($negocio);
$nombreDocumento=$_GET["nombreDocumento"];

$pdf = new FPDI();
$pageCount = $pdf->setSourceFile("uploads/documentosREPSE/".$nombreDocumento);
$tplIdx = $pdf->importPage(1);
$pdf->addPage();
$pdf->useTemplate($tplIdx, null, null, null, null, true); 
$pdf->SetFont("Arial", 'B',10);
$pdf->SetFont("Arial", 'B',9.5);
$pdf->SetFont("Arial", 'B',8);
$pdf->Output();
$response = array("status" => "success");



?>

