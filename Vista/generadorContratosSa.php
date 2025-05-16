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


if (!empty ($_GET))
{
$empleadoEntidad=$_GET["entidadEmpleado"];
$empleadoConsecutivo=$_GET["consecutivoEmpleado"];
$empleadoTipo=$_GET["tipoEmpleado"];
$usuario=$_SESSION ["userLog"];


try
    {

//$log -> LogInfo ("entidadEmpleado ".var_export ($empleadoEntidad, true));
//$log -> LogInfo ("consecutivoEmpleado ".var_export ($empleadoConsecutivo, true));
//$log -> LogInfo ("empleadoTipo ".var_export ($empleadoTipo, true));


$empleado= $negocio -> negocio_obtenerEmpleadoPorId($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo,$usuario);
$response["empleado"]= $empleado;

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
$genero= $response["empleado"][0]["descripcionGenero"];
$estadoCivil= $response["empleado"][0]["descripcionEstadoCivil"];
$fechaNacimiento= $response["empleado"][0]["fechaNacimiento"];
$curp= $response["empleado"][0]["curpEmpleado"];


$fecha2=date("m-d-Y",strtotime($fechaIngreso));

$asentamiento =$response["empleado"][0]["calle"]." ".$response["empleado"][0]["numeroExterior"]." ".$response["empleado"][0]["numeroInterior"]." ". $response["empleado"][0]["nombreTipoAsentamiento"]." ". $response["empleado"][0]["nombreAsentamiento"];
$asentamiento2=$asentamiento." ".$response["empleado"][0]["nombreMunicipio"].", ".$response["empleado"][0]["nombreEntidadFederativa"].", C.P. 56606";
//$nombreMunicipio =  $response["empleado"][0]["nombreMunicipio"].",".$response["empleado"][0]["nombreEntidadFederativa"];
$fecha3=date('d-m-Y', strtotime($fechaIngreso));
$diaSemana=utf8_decode(strtoupper(strftime("%A", strtotime($fecha3)) )); 
$nombreMes=utf8_decode(strtoupper(strftime("%B", strtotime($fecha3)) )); // Guardamos el Nombre del día de la semana.
$dia=strftime("%d", strtotime($fecha3));
$anio=strftime("%Y", strtotime($fecha3));

$fechaNac=date('d-m-Y', strtotime($fechaNacimiento));
$nombreMesNac=utf8_decode(strtoupper(strftime("%B", strtotime($fechaNac)) )); // Guardamos el Nombre del día de la semana.
$diaNac=strftime("%d", strtotime($fechaNac));
$anioNac=strftime("%Y", strtotime($fechaNac));



$pdf = new FPDI();

$pageCount = $pdf->setSourceFile("../archivos/contratosaindeterminado.pdf");
$tplIdx = $pdf->importPage(1);


$pdf->addPage();
$pdf->useTemplate($tplIdx, 5, null, 200);

$pdf->SetFont("Arial", 'B',9);

$pdf->Text(30, 33, utf8_decode($nombreEmpleado." ".$apellidoPaterno." ".$apellidoMaterno));
$pdf->Text(46, 97, utf8_decode($genero));
$pdf->Text(88, 97, utf8_decode($estadoCivil));
$pdf->Text(62, 101, utf8_decode($diaNac." DE ".$nombreMesNac." DE ".$anioNac));
$pdf->Text(115, 101, utf8_decode($curp));
$pdf->Text(161, 101, utf8_decode($rfcEmpleado));
$pdf->SetXY(70, 103);
$pdf->MultiCell(100, 5, utf8_decode(strtoupper($asentamiento2)), 0, 1);


$tplIdx = $pdf->importPage(2);
$pdf->addPage();
$pdf->useTemplate($tplIdx, 5, null, 200);
$pdf->SetFont("Arial", 'B',11);



$tplIdx = $pdf->importPage(3);
$pdf->addPage();
$pdf->useTemplate($tplIdx, 5, null, 200);
$pdf->SetFont("Arial", 'B',9);

$pdf->SetXY(97, 125);
$pdf->MultiCell(95, 5, utf8_decode(strtoupper($asentamiento2)), 0, 1);

$pdf->SetFont("Arial", 'B',8);
$pdf->Text(125, 181, utf8_decode($nombreEmpleado." ".$apellidoPaterno." ".$apellidoMaterno));


$pdf->Output();
$response = array("status" => "success");
}
catch (Exception $e)
{
	echo "NO SE PUEDE GENERAR CONTRATO".$e;
}
}else
{
	echo "NO SE PUEDE GENERAR CONTRATO";
}
?>

