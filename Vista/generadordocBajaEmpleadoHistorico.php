<?php
session_start();

// require_once ("../../libs/logger/KLogger.php");
use setasign\Fpdi\Fpdi;
// require('../../libs/fpdf/fpdf.php');
require_once('../libs/fpdi/src/autoload.php');

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
verificarInicioSesion ($negocio);

//require "../conexion/conexion.php";
//require_once "../../libs/logger/KLogger.php";
require_once "../libs/numLetras/numeroLetras.php";
require '../libs/fpdf/fpdf.php';
// require '../libs/fpdi/fpdi.php';
//$log = new KLogger("ajax_generadorBajaEmpleado.log", KLogger::DEBUG);

$numempleado    = $_GET["numempleado"];
$RolUsuario    = $_GET["RolUsuario"];
$fechaSolicitud    = $_GET["fechaSolicitud"];
$datos          = array();
 
$datos= $negocio -> getDatosEmpBajaFolioBajaHistorico($numempleado,$fechaSolicitud);
//$log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));
date_default_timezone_set('America/Mexico_City'); //Asignas la zona horaria de tu país.
setlocale(LC_TIME, 'spanish'); //Fijamos el tiempo local
$EntidadEmpBaja = $datos[0]["EntidadEmpBaja"];
$ConsecutivoEmpBaja = $datos[0]["ConsecutivoEmpBaja"];
$CaegoriaEmpBaja = $datos[0]["CaegoriaEmpBaja"];
$nombreEmpleado = $datos[0]["nombreEmpleado"];
$apellidoPaterno = $datos[0]["apellidoPaterno"];
$apellidoMaterno = $datos[0]["apellidoMaterno"];

$EntidadFirmaEmpBaja = $datos[0]["EntidadFirmaEmpBaja"];
$ConsecutivoFirmaEmpBaja = $datos[0]["ConsecutivoFirmaEmpBaja"];
$CategoriaFirmaEmpBaja = $datos[0]["CategoriaFirmaEmpBaja"];

$FechaSolicitudBaja = $datos[0]["FechaSolicitudBaja"];
$NombreEmpBaja = $datos[0]["NombreEmpBaja"];
$numeroEmpleadoBaja = $EntidadEmpBaja . "-" . $ConsecutivoEmpBaja . "-" . $CaegoriaEmpBaja; 
$EstadoEmpBaja = $datos[0]["EstadoEmpBaja"];
$ServicioClienteEmpBaja = $datos[0]["ServicioClienteEmpBaja"];
$PuntoServicioEmpBaja1 = $datos[0]["PuntoServicioEmpBaja1"];
$SupervisorNombreEmpBaja = $datos[0]["SupervisorNombreEmpBaja"];
$MotivoEmpBaja = $datos[0]["MotivoEmpBaja"];
$ComentarioEmpBaja = $datos[0]["ComentarioEmpBaja"];
$nombreFirma = $nombreEmpleado . " " . $apellidoPaterno . " " . $apellidoMaterno; 
$FirmaCifradaEmpBaja = $datos[0]["FirmaCifradaEmpBaja"];
$FechaRegistroSolicitud = $datos[0]["FechaRegistroSolicitud"];
$FirmaCifradaElementoBaja = $datos[0]["FirmaCifradaElementoBaja"];
$marca = "X";
$largocomentario = strlen($ComentarioEmpBaja);
if($largocomentario > "100"){
	  $Comentario1=substr($ComentarioEmpBaja, 0,100);
	  $Comentario2=substr($ComentarioEmpBaja, 100,210);
}else{
	$Comentario1=$ComentarioEmpBaja;
}
if($MotivoEmpBaja == '9'){
$ancho = "62";
$largo = "85";
}else if($MotivoEmpBaja == '7'){
$ancho = "141";
$largo = "84.5";
}else if($MotivoEmpBaja == '10'){
$ancho = "190.5";
$largo = "84.5";
}else if($MotivoEmpBaja == '6'){
$ancho = "62";
$largo = "92";
}else {
$ancho = "141";
$largo = "92";
}
$FechaExplode = explode('-',$FechaRegistroSolicitud);
$fechaAnio=$FechaExplode[0];
$fechaMes1=$FechaExplode[1];
$fechaDia=$FechaExplode[2]; 
setlocale(LC_ALL, 'es_ES');
$monthNum  = 3;
$dateObj   = DateTime::createFromFormat('!m', $fechaMes1); //prueba
$fechaMes = strftime('%B', $dateObj->getTimestamp());


if($RolUsuario =="Lider Unidad"){
	$pdf                       = new FPDI();
	$numletras                 = new NumeroALetras();
	$pageCount                 = $pdf->setSourceFile("uploads/ArchivosBaja/RENUNCIAS DE GIF SEGURIDAD 1.pdf"); 
	$tplIdx                    = $pdf->importPage(1);
	$pdf->addPage('P', 'Letter');
	$pdf->useTemplate($tplIdx, null, null, null, null, true);
	$pdf->SetFont("Arial", 'B', 9);
	$pdf->SetXY(50, 47);
	$pdf->Text(70, 19, utf8_decode($EstadoEmpBaja));
	$pdf->Text(124, 19, utf8_decode($fechaDia));
	$pdf->Text(145, 19, utf8_decode($fechaMes));
	$pdf->Text(175, 19, utf8_decode($fechaAnio));
	$pdf->Text(65, 81, utf8_decode($NombreEmpBaja));
	$pdf->Text(70, 86, utf8_decode($numeroEmpleadoBaja));
	$pdf->Text(80, 240, utf8_decode($NombreEmpBaja));
	$pdf->Text(77, 245, utf8_decode($FirmaCifradaElementoBaja));
//$pdf->Text(85, 245, utf8_decode($NombreEmpleadoModal));
	
	$pdf->Output();
}else{
	$pdf                       = new FPDI();
	$numletras                 = new NumeroALetras();
	$pageCount                 = $pdf->setSourceFile("uploads/ArchivosBaja/FORMATOBAJAEMPLEADO.pdf");
	$tplIdx                    = $pdf->importPage(1);
	$pdf->addPage('P', 'Letter');
	$pdf->useTemplate($tplIdx, null, null, null, null, true);
	$pdf->SetFont("Arial", 'B', 9);
	$pdf->SetXY(50, 47);
	$pdf->Text(155, 42, utf8_decode($FechaSolicitudBaja));
	$pdf->Text(55, 46, utf8_decode($NombreEmpBaja));
	$pdf->Text(48, 50, utf8_decode($numeroEmpleadoBaja));
	$pdf->Text(30, 54, utf8_decode($EstadoEmpBaja));
	$pdf->Text(52, 58, utf8_decode($ServicioClienteEmpBaja));
	$pdf->Text(75, 62, utf8_decode($PuntoServicioEmpBaja1));
	$pdf->Text(39, 66, utf8_decode($SupervisorNombreEmpBaja));
	$pdf->Text($ancho, $largo, utf8_decode($marca));
	if($largocomentario > "100"){
		$pdf->Text(39, 100.5, utf8_decode($Comentario1));
		$pdf->Text(13, 105, utf8_decode($Comentario2));
	}else{
		$pdf->Text(39, 100.5, utf8_decode($Comentario1));
	}
	
	$pdf->Text(25, 125.5, utf8_decode($nombreFirma));
	$pdf->Text(20, 129.5, utf8_decode($FirmaCifradaEmpBaja));
	$pdf->Text(153, 129.5, utf8_decode($FechaRegistroSolicitud));
	$pdf->Output();
}




$response = array("status" => "success");
