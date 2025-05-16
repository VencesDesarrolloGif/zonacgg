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

$empleadoEntidad=$_GET["entidadEmpleado"];
$empleadoConsecutivo=$_GET["consecutivoEmpleado"];
$empleadoTipo=$_GET["tipoEmpleado"];

if (empty($empleadoEntidad)
    || empty ($empleadoConsecutivo)
    || empty ($empleadoTipo))
{

    $response = array (
        "status" => "error",
        "message" => "No se puede generar credencial por que no se proporcionó un número de empleado válido."
    );
    
    echo json_encode ($response);
    
    exit;
}

//$log -> LogInfo ("entidadEmpleado ".var_export ($empleadoEntidad, true));
//$log -> LogInfo ("consecutivoEmpleado ".var_export ($empleadoConsecutivo, true));
//$log -> LogInfo ("empleadoTipo ".var_export ($empleadoTipo, true));


$empleado= $negocio -> negocio_obtenerEmpleadoPorId($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo);
$response["empleado"]= $empleado;

if (empty ($empleado))
{
    $response = array (
        "status" => "error",
        "message" => "El número de empleado proporcionado no se encuentra registrado en el sistema."
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

$apellidoPaterno=$response["empleado"][0]["apellidoPaterno"];
$apellidoMaterno=$response["empleado"][0]["apellidoMaterno"];
$nombreEmpleado=$response["empleado"][0]["nombreEmpleado"];
$empleadoNumeroSeguroSocial=$response["empleado"][0]["empleadoNumeroSeguroSocial"];
$rfcEmpleado=$response["empleado"][0]["rfcEmpleado"];
$calle = $response["empleado"][0]["calle"];
$numeroExterior = $response["empleado"][0]["numeroExterior"];
$numeroInterior = $response["empleado"][0]["numeroInterior"];
$fechaIngreso= $response["empleado"][0]["fechaIngresoEmpleado"];
$curp= $response["empleado"][0]["curpEmpleado"];
$puesto=$response["empleado"][0]["descripcionPuesto"];
$fotoEmpleado=$response["empleado"][0]["fotoEmpleado"];


$fecha2=date("m-d-Y",strtotime($fechaIngreso));

$asentamiento =$response["empleado"][0]["calle"]." ".$response["empleado"][0]["numeroExterior"]." ".$response["empleado"][0]["numeroInterior"]." ". $response["empleado"][0]["nombreTipoAsentamiento"]." ". $response["empleado"][0]["nombreAsentamiento"];
$asentamiento2=$asentamiento." ".$response["empleado"][0]["nombreMunicipio"].", ".$response["empleado"][0]["nombreEntidadFederativa"].", C.P. 56606";
//$nombreMunicipio =  $response["empleado"][0]["nombreMunicipio"].",".$response["empleado"][0]["nombreEntidadFederativa"];
$fecha3=date('d-m-Y', strtotime($fechaIngreso));
$diaSemana=utf8_decode(strtoupper(strftime("%A", strtotime($fecha3)) )); 
$nombreMes=utf8_decode(strtoupper(strftime("%B", strtotime($fecha3)) )); // Guardamos el Nombre del día de la semana.
$dia=strftime("%d", strtotime($fecha3));
$anio=strftime("%Y", strtotime($fecha3));


$pdf = new FPDI();

$pageCount = $pdf->setSourceFile("../archivos/credencial2.pdf");
$tplIdx = $pdf->importPage(1);

$pdf->addPage('P', 'Letter');

$pdf->Image('img/Firma3.jpg',50,68,25);
$pdf->Image('img/Imagen3.jpg',43,35,35);

$pdf->Image('img/folioGif.jpg',140,24,50);

$pdf->SetFont("Arial", 'B',11);
$pdf->SetXY(33, 45);
//$pdf->Cell(45,5,utf8_decode($nombreEmpleado),1,1,'C');
$pdf->MultiCell(56, 4, utf8_decode(strtoupper($nombreEmpleado)),0,'C',0);
$pdf->SetXY(33, 53);
$pdf->MultiCell(56,4,utf8_decode($apellidoPaterno)." ".utf8_decode($apellidoMaterno),0,'C',0);


$pdf->SetFont("Arial", 'B',7);
$pdf->Text(186, 34, date("Y"));


$pdf->useTemplate($tplIdx, 5, null, 200);
$pdf->SetFont("Arial", '',8);


//inserto la cabecera poniendo una imagen dentro de una celda
//$pdf->Cell(50,50,$pdf->Image('img/09516003.jpg',10,20,20),1,1,'C');

$rutaImagen="thumbs/".$fotoEmpleado;


$pdf->Image($rutaImagen,90,37,24);

$pdf->Text(132, 54.5, $empleadoNumeroSeguroSocial);
$pdf->Text(164.5, 54.5, $curp);
$pdf->SetFont("Arial", '',6);
$pdf->Text(129,59.5,$dia." DE ".$nombreMes." DE ".$anio);


$pdf->SetFont("Arial", 'B',11);
$pdf->SetTextColor(244,169,000);

$pdf->SetXY(33, 62);
$pdf->MultiCell(55,4,$puesto,0,'C',0);



$pdf->SetFont("Arial", 'B',11);
$pdf->SetTextColor(231,037,018);
$pdf->Text(165, 28.5, $empleadoEntidad."-".$empleadoConsecutivo."-".$empleadoTipo);


$pdf->Output();
$response = array("status" => "success");



?>

