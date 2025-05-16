<?php
session_start();
use setasign\Fpdi\Fpdi;
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
//$log = new KLogger("generadorActaAdministrativaVatado.log", KLogger::DEBUG);

$numempleado    = $_GET["numempleado"];
$ModuloBaja    = $_GET["ModuloBaja"];
$datos          = array();
//$log->LogInfo("Valor de la variable ModuloBaja: " . var_export ($ModuloBaja, true));
 
$datos= $negocio -> getDatosEmpleadoVetado($numempleado); 
//$log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));
date_default_timezone_set('America/Mexico_City'); //Asignas la zona horaria de tu país.
setlocale(LC_TIME, 'spanish'); //Fijamos el tiempo local
$NumeroEmpleadoVetado = $datos[0]["NumeroEmpleadoVetado"];
$NombreEmpleadoVetado = $datos[0]["NombreEmpleadoVetado"];
$NombreFirma = $datos[0]["NombreFirma"];
$MotivoVetado = $datos[0]["MotivoVetado"];
$FirmaEmpleado = $datos[0]["FirmaEmpleado"];
$FirmaSupervisor = $datos[0]["FirmaSupervisor"];
$FechaRegistroSolicitud = $datos[0]["FechaRegistroSolicitud"];
$FecahActual = date("Y-m-d H:i:s");
//$log->LogInfo("Valor de la variable FecahActual: " . var_export ($FecahActual, true));

$largocomentario = strlen($MotivoVetado);
//$log->LogInfo("Valor de la variable largocomentario: " . var_export ($largocomentario, true));
if($largocomentario >= "65" && $largocomentario <= "130"){
	  $Comentario1=substr($MotivoVetado, 0,65);
	  $Comentario2=substr($MotivoVetado, 65,65);
}else if($largocomentario >= "130" && $largocomentario <= "200"){
	$Comentario1=substr($MotivoVetado, 0,65);
	  $Comentario2=substr($MotivoVetado, 65,65);
	  $Comentario3=substr($MotivoVetado, 130,80);
}else{
	$Comentario1=$MotivoVetado;
}
//$log->LogInfo("Valor de la variable Comentario1: " . var_export ($Comentario1, true));
//$log->LogInfo("Valor de la variable Comentario2: " . var_export ($Comentario2, true));
//$log->LogInfo("Valor de la variable Comentario3: " . var_export ($Comentario3, true));

$FechaExplode = explode(' ',$FechaRegistroSolicitud);
$FechaHoy=$FechaExplode[0];
$HoraHoy=$FechaExplode[1];
$FechaExplodeHoy = explode('-',$FechaHoy);
$FechaAnio=$FechaExplodeHoy[0];
$FechaMes=$FechaExplodeHoy[1];
$FechaDia=$FechaExplodeHoy[2]; 
setlocale(LC_ALL, 'es_ES');
$dateObj   = DateTime::createFromFormat('!m', $FechaMes);
$fechaMes1 = strftime('%B', $dateObj->getTimestamp());
$FechaAnio1=substr($FechaAnio, 2,4);
if($ModuloBaja!="RH"){
	$FirmaEmpleado="SIN FIRMA";
}

//$log->LogInfo("Valor de la variable fechaMes1: " . var_export ($fechaMes1, true));

	$pdf                       = new FPDI();
	$numletras                 = new NumeroALetras();
	$pageCount                 = $pdf->setSourceFile("uploads/ActaAdministrativaVetados/Acta administrativa.pdf"); 
	$tplIdx                    = $pdf->importPage(1);
	$pdf->addPage('P', 'Letter');
	$pdf->useTemplate($tplIdx, null, null, null, null, true);
	$pdf->SetFont("Arial", 'B', 9);
	$pdf->SetXY(50, 47);
	$pdf->Text(78, 81, utf8_decode($HoraHoy));
	$pdf->Text(120, 81, utf8_decode($FechaDia));
	$pdf->Text(150, 81, utf8_decode($fechaMes1));
	$pdf->Text(42, 86, utf8_decode($FechaAnio1));
	$pdf->Text(96.5, 107, utf8_decode($NombreFirma));
	$pdf->Text(33.5, 117, utf8_decode($NombreEmpleadoVetado));
	$pdf->Text(148, 117, utf8_decode($NumeroEmpleadoVetado));
	if($largocomentario >= "70" && $largocomentario <= "140"){
	  	$pdf->Text(31, 132.5, utf8_decode($Comentario1));
		$pdf->Text(31, 137.5, utf8_decode($Comentario2));
	}else if($largocomentario >= "140" && $largocomentario < "210"){
		$pdf->Text(31, 132.5, utf8_decode($Comentario1));
		$pdf->Text(31, 137.5, utf8_decode($Comentario2));
		$pdf->Text(31, 142.5, utf8_decode($Comentario3));
	}else{
		$pdf->Text(31, 132.5, utf8_decode($Comentario1));
	}
	$pdf->Text(34, 224, utf8_decode($NombreEmpleadoVetado));
	$pdf->Text(34, 227, utf8_decode($FirmaEmpleado));

	$pdf->Text(122, 224, utf8_decode($NombreFirma));
	$pdf->Text(122, 227, utf8_decode($FirmaSupervisor));
	
	
	$pdf->Output();


$response = array("status" => "success");
