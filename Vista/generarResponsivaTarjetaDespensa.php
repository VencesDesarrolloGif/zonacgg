<?php
session_start();
use setasign\Fpdi\Fpdi;
require_once('../libs/fpdi/src/autoload.php');
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
require('../libs/fpdf/fpdf.php');
// require('../libs/fpdi/fpdi.php'); 

//$log = new KLogger ( "generarResponsivaTarjetaDespensa.log" , KLogger::DEBUG );

$negocio = new Negocio();
$response = array ();

verificarInicioSesion ($negocio);

$empleadoEntidad=$_GET["entidadEmpleado"];
$empleadoConsecutivo=$_GET["consecutivoEmpleado"];
$empleadoTipo=$_GET["tipoEmpleado"];
$usuario=$_SESSION ["userLog"];

if (empty($empleadoEntidad) || empty ($empleadoConsecutivo) || empty ($empleadoTipo))
{

    $response = array (
        "status" => "error",
        "message" => "No se puede generar la responsiva de la tarjeta por que no se proporcionó un número de empleado válido."
    );
    
    echo json_encode ($response);
    
    exit;
}

//$log -> LogInfo ("entidadEmpleado ".var_export ($empleadoEntidad, true));
//$log -> LogInfo ("consecutivoEmpleado ".var_export ($empleadoConsecutivo, true));
//$log -> LogInfo ("empleadoTipo ".var_export ($empleadoTipo, true));


$empleado= $negocio -> negocio_obtenerEmpleadoPorId($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo,$usuario);
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
date_default_timezone_set('America/Mexico_City'); //Asignas la zona horaria de tu país.
setlocale(LC_TIME, 'spanish'); //Fijamos el tiempo local

//echo “Hoy es:”.$diaSemana; //Imprimimos El día.
$apellidoPaterno=$response["empleado"][0]["apellidoPaterno"];
$apellidoMaterno=$response["empleado"][0]["apellidoMaterno"];
$nombreEmpleado=$response["empleado"][0]["nombreEmpleado"];
$empleadoNumeroSeguroSocial=$response["empleado"][0]["empleadoNumeroSeguroSocial"];
$rfcEmpleado=$response["empleado"][0]["rfcEmpleado"];
$fechaIngreso= $response["empleado"][0]["fechaIngresoEmpleado"];
$FechaASignacionEmpleado= $response["empleado"][0]["FechaASignacionEmpleado"];
$fotoEmpleado=$response["empleado"][0]["fotoEmpleado"];
$EntidadTarjeta=$response["empleado"][0]["EntidadTarjeta"];
$idIutTarjeta=$response["empleado"][0]["idIutTarjeta"];
$ApellidoPSup=$response["empleado"][0]["ApellidoPSup"];
$ApellidoMSup=$response["empleado"][0]["ApellidoMSup"];
$NombreSup=$response["empleado"][0]["NombreSup"];

if($FechaASignacionEmpleado == "" || $FechaASignacionEmpleado == "null" || $FechaASignacionEmpleado =="NULL" || $FechaASignacionEmpleado== null ){
    $FechaASignacionEmpleado = date('d-m-Y');
}

$asentamiento =$response["empleado"][0]["calle"]." ".$response["empleado"][0]["numeroExterior"]." ".$response["empleado"][0]["numeroInterior"]." ". $response["empleado"][0]["nombreTipoAsentamiento"]." ". $response["empleado"][0]["nombreAsentamiento"];
$asentamiento2=$asentamiento." ".$response["empleado"][0]["nombreMunicipio"].", ".$response["empleado"][0]["nombreEntidadFederativa"].", C.P.". $response["empleado"][0]["codigoPostalAsentamiento"];;
//$nombreMunicipio =  $response["empleado"][0]["nombreMunicipio"].",".$response["empleado"][0]["nombreEntidadFederativa"];
$fecha3=date('d-m-Y', strtotime($FechaASignacionEmpleado));
$diaSemana=strtoupper(strftime("%A", strtotime($fecha3)) ); 
$nombreMes=utf8_decode(strtoupper(strftime("%B", strtotime($fecha3)) )); // Guardamos el Nombre del día de la semana.
$dia=strftime("%d", strtotime($fecha3));
$anio=strftime("%Y", strtotime($fecha3));

//$fecha4=date('d-m-Y', strtotime(getdate()));
$fecha4=date('d-m-Y', strtotime($fechaIngreso));
$diaSemana1=utf8_decode(strtoupper(strftime("%A", strtotime($fecha4)) )); 
$nombreMes1=utf8_decode(strtoupper(strftime("%B", strtotime($fecha4)) )); // Guardamos el Nombre del día de la semana.
$dia1=strftime("%d", strtotime($fecha4));
$anio1=strftime("%Y", strtotime($fecha4));

if ($diaSemana1=="MI?RCOLES") {
    $diaSemana1="MIERCOLES";
}if ($diaSemana1=="S?BADO") {
    $diaSemana1="SABADO";
}

if ($diaSemana=="MI?RCOLES") {
    $diaSemana="MIERCOLES";
}if ($diaSemana=="S?BADO") {
    $diaSemana="SABADO";
}
$pdf = new FPDI();

$pageCount = $pdf->setSourceFile("../archivos/ResponsivaTarjetaDespensa1.pdf");
$tplIdx = $pdf->importPage(1);

$pdf->addPage();
//$pdf->useTemplate($tplIdx, 5, 0, 200);
$pdf->useTemplate($tplIdx, null, null, null, null, true); 
$pdf->SetFont("Arial", 'B',11);

$pdf->SetXY(80, 42);
$pdf->Cell(100,5,utf8_decode($EntidadTarjeta . " A ").$diaSemana. ", ".$dia." DE ".$nombreMes." DE ". $anio,0,1,'L');

//inserto la cabecera poniendo una imagen dentro de una celda
//$pdf->Cell(50,50,$pdf->Image('img/09516003.jpg',10,20,20),1,1,'C');

$rutaImagen="uploads/fotosempleados/".$fotoEmpleado;
$pdf->Image($rutaImagen,11,28,25);

$pdf->SetFont('Arial','B',10);

$pdf->Text(36, 81.3, utf8_decode($nombreEmpleado." ". $apellidoPaterno." ".$apellidoMaterno));
$pdf->Text(154, 81.3, utf8_decode($empleadoEntidad."-". $empleadoConsecutivo."-".$empleadoTipo));
$pdf->Text(94, 230, utf8_decode($NombreSup. " ". $ApellidoPSup." ". $ApellidoMSup));
$pdf->Text(92, 89.5, utf8_decode($idIutTarjeta));

$pdf->Text(99, 147, utf8_decode($apellidoPaterno));
$pdf->Text(99, 153, utf8_decode($apellidoMaterno));
$pdf->Text(99, 159, utf8_decode($nombreEmpleado));
$pdf->Text(99, 165, utf8_decode($rfcEmpleado));
$pdf->Text(99, 172, $empleadoNumeroSeguroSocial);
$pdf->Text(99, 178, $diaSemana1.", ".$dia1." DE ".$nombreMes1." DE ".$anio1);
$pdf->SetXY(99, 181);
$pdf->MultiCell(75, 4.5, utf8_decode(strtoupper($asentamiento2)), 0, 1);



$pdf->Output();
$response = array("status" => "success");



?>

