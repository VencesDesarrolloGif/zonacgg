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
//$log -> LogInfo ("VALOR DE visitanteId". var_export ("hola funciona", true));

$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");

$empleadoEntidad=$_GET["entidadEmpleado"];
$empleadoConsecutivo=$_GET["consecutivoEmpleado"];
$empleadoTipo=$_GET["tipoEmpleado"];

//$log -> LogInfo ("entidadEmpleado ".var_export ($empleadoEntidad, true));
//$log -> LogInfo ("consecutivoEmpleado ".var_export ($empleadoConsecutivo, true));
//$log -> LogInfo ("empleadoTipo ".var_export ($empleadoTipo, true));


$empleado= $negocio -> negocio_obtenerEmpleadoPorId($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo);
$response["empleado"]= $empleado;

//$log->LogInfo("Valor de la variable \$response empleado: " . var_export ($response, true));
//$log->LogInfo("Valor de la variable \$empleado empleado: " . var_export ($response["empleado"][0]["apellidoPaterno"], true));
//$log->LogInfo("Valor de la variable \$apellido paterno empleado: " . var_export ($response["empleado"]["apellidoPaterno"], true));
date_default_timezone_set('America/Mexico_City'); //Asignas la zona horaria de tu país.
setlocale(LC_TIME, 'spanish'); //Fijamos el tiempo local
$diaSemana=strftime("%A", strtotime("19/05/2015")) ; // Guardamos el Nombre del día de la semana.
//echo “Hoy es:”.$diaSemana; //Imprimimos El día.

$apellidoPaterno=$response["empleado"][0]["apellidoPaterno"]. $diaSemana ;
$apellidoMaterno=$response["empleado"][0]["apellidoMaterno"];
$nombreEmpleado=$response["empleado"][0]["nombreEmpleado"];
$empleadoNumeroSeguroSocial=$response["empleado"][0]["empleadoNumeroSeguroSocial"];
$rfcEmpleado=$response["empleado"][0]["rfcEmpleado"];
$calle = $response["empleado"][0]["calle"];
$numeroExterior = $response["empleado"][0]["numeroExterior"];
$numeroInterior = $response["empleado"][0]["numeroInterior"];

$asentamiento =$response["empleado"][0]["calle"]." ".$response["empleado"][0]["numeroExterior"]." ".$response["empleado"][0]["numeroInterior"]." ". $response["empleado"][0]["nombreTipoAsentamiento"]." ". $response["empleado"][0]["nombreAsentamiento"];
$asentamiento2=$asentamiento." ".$response["empleado"][0]["nombreMunicipio"].", ".$response["empleado"][0]["nombreEntidadFederativa"].", C.P. 56606";
//$nombreMunicipio =  $response["empleado"][0]["nombreMunicipio"].",".$response["empleado"][0]["nombreEntidadFederativa"];

$pdf = new FPDI();

$pageCount = $pdf->setSourceFile("../archivos/cartapatronalblanco2.pdf");
$tplIdx = $pdf->importPage(1);

$pdf->addPage();
$pdf->useTemplate($tplIdx, 5, null, 200);
$pdf->SetFont("Arial", 'B',11);


//inserto la cabecera poniendo una imagen dentro de una celda
//$pdf->Cell(700,85,$pdf->Image('img/09516003.jpg',30,12,160),0,0,'C');

$pdf->SetFont('Arial','B',11);

$pdf->Text(97, 140, $apellidoPaterno);
$pdf->Text(97, 146, $apellidoMaterno);
$pdf->Text(97, 152, $nombreEmpleado);
$pdf->Text(97, 157, $rfcEmpleado);
$pdf->Text(97, 163, $empleadoNumeroSeguroSocial);
//$pdf->Text(97, 175, $calle);
$pdf->SetXY(96, 171);
$pdf->MultiCell(75, 5, utf8_decode(strtoupper($asentamiento2)), 0, 1);

$pdf->Output();
?>

