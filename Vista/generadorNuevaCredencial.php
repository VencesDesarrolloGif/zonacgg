<?php
session_start();
use setasign\Fpdi\Fpdi;
require_once('../libs/fpdi/src/autoload.php');
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
require('../libs/fpdf/fpdf.php');
// require('../libs/fpdi/fpdi.php');
require('../libs/barcode/barcode.inc.php');
//enviar el usuario para que pueda traer la consulta negocio_obtenerEmpleadoPorId

// $log = new KLogger ( "generarNuevaCredencial.log" , KLogger::DEBUG );




$usuario=$_SESSION ["userLog"];


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


$repse= $negocio -> negocio_obtenerRepse();
$NumAcuerdo = $repse[0]["NumAcuerdo"];
$NumFolioIngreso = $repse[0]["NumFolioIngreso"];
// $log->LogInfo("Valor de la variable Repse empleado: " . var_export ($repse, true));
// $log->LogInfo("Valor de la variable Repse NumAcuerdo: " . var_export ($NumAcuerdo, true));
// $log->LogInfo("Valor de la variable Repse NumFolioIngreso: " . var_export ($NumFolioIngreso, true));
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
$fotoFirma=$response["empleado"][0]["fotoFirma"];

$fecha2=date("m-d-Y",strtotime($fechaIngreso));

$asentamiento =$response["empleado"][0]["calle"]." ".$response["empleado"][0]["numeroExterior"]." ".$response["empleado"][0]["numeroInterior"]." ". $response["empleado"][0]["nombreTipoAsentamiento"]." ". $response["empleado"][0]["nombreAsentamiento"];
$asentamiento2=$asentamiento." ".$response["empleado"][0]["nombreMunicipio"].", ".$response["empleado"][0]["nombreEntidadFederativa"].", C.P. 56606";
//$nombreMunicipio =  $response["empleado"][0]["nombreMunicipio"].",".$response["empleado"][0]["nombreEntidadFederativa"];
$fecha3=date('d-m-Y', strtotime($fechaIngreso));
$diaSemana=utf8_decode(strtoupper(strftime("%A", strtotime($fecha3)) )); 
$nombreMes=utf8_decode(strtoupper(strftime("%B", strtotime($fecha3)) )); // Guardamos el Nombre del día de la semana.
$dia=strftime("%d", strtotime($fecha3));
$anio=strftime("%Y", strtotime($fecha3));
$mes=strftime("%M", strtotime($fecha3));

$pdf = new FPDI();

$pageCount = $pdf->setSourceFile("../archivos/NC2.pdf");
$tplIdx = $pdf->importPage(1);

$pdf->addPage('P', 'Letter');

$pdf->useTemplate($tplIdx, 0.6, 2, 210);
$pdf->SetMargins(0, 0 , 0); 


//$pdf -> addPage('P','mm',array(86,54));

//$pdf->SetMargins(0, 0 , 0); 

// $pdf->Image('img/Firma3.jpg',50,68,25);
//$pdf->Image('img/Imagen3.jpg',43,35,35);

// $pdf->Image('img/folioGif.jpg',140,24,50);

//$pdf->Image('../archivos/NCF.jpg',0.2,1,54,86);

$pdf->SetFont("Arial", 'B',7);



//$pdf->useTemplate($tplIdx, 0, 0, 200);

//$pdf->useTemplate($tplIdx, 0, 0, 86);
$pdf->SetFont("Arial", '',7);

//inserto la cabecera poniendo una imagen dentro de una celda
//$pdf->Cell(50,50,$pdf->Image('img/09516003.jpg',10,20,20),1,1,'C');

//$rutaImagen="thumbs/".$fotoEmpleado;


$rutaImagen="uploads/fotosempleados/".$fotoEmpleado;

// $pdf->Text(132, 54.5, $empleadoNumeroSeguroSocial);
// $pdf->Text(164.5, 54.5, $curp);
$pdf->SetFont("Arial", '',7);
// $pdf->Text(129,59.5,$dia." DE ".$nombreMes." DE ".$anio);

$pdf->SetFont("Arial", 'B',8);
$pdf->SetTextColor(29,96,131);

$pdf->SetXY(0.3, 61.5);
$pdf->MultiCell(54, 2, utf8_decode(strtoupper($nombreEmpleado)),0,'C',0);

$pdf->SetXY(0.3, 66);
$pdf->MultiCell(54,2,utf8_decode($apellidoPaterno)." ".utf8_decode($apellidoMaterno),0,'C',0);

$pdf->SetXY(0.3, 70);
//$pdf->SetTextColor(244,169,000);
$pdf->MultiCell(54,2,utf8_decode($puesto),0,'C',0);

$pdf->Image($rutaImagen,13,28.6,28.2,32);




$tplIdx = $pdf->importPage(2);
$pdf->addPage('P', 'Letter');
$pdf->useTemplate($tplIdx, null, null, null, null, true);
//$pdf->Image('../archivos/NCA2.jpg',0.2,0.5,54,86);

$pdf->SetFont("Arial", 'B',6);
$pdf->SetTextColor(255,255,255);
$pdf->Text(44, 84.1, date("Y"));

$pdf->SetFont("Arial", 'B',5);
$pdf->SetTextColor(0,0,0);
$pdf->Text(1, 4.8, "No. de acuerdo:");
$pdf->SetFont("Arial", '',3.7);
$pdf->SetTextColor(0,0,0);
$pdf->Text(0.5, 7.5, $NumAcuerdo);

$pdf->SetFont("Arial", 'B',4.5);
$pdf->SetTextColor(0,0,0);
$pdf->Text(38, 4.8, "No. de folio Ingreso:");
$pdf->SetFont("Arial", '',6);
$pdf->SetTextColor(0,0,0);
$pdf->Text(39, 7.5, $NumFolioIngreso);

$pdf->SetFont("Arial", '',11);
$pdf->SetTextColor(0,0,0);
$pdf->Text(20, 12.5, $empleadoEntidad."-".$empleadoConsecutivo."-".$empleadoTipo);


$pdf->SetFont("Arial", '',5.5);
$pdf->SetTextColor(0,0,0);
$pdf->Text(11.3, 16, "DGSP/188-12/2082");
$pdf->Text(41,16,$fecha3);
$pdf->Text(11.3, 20.5, "0439-16");
$pdf->Text(42, 20.5, "4094-16");
$pdf->Text(7, 24.5, $empleadoNumeroSeguroSocial);
$pdf->Text(30, 24.5, $curp);

$pdf->Image('../archivos/supervisor2.jpg',36,26.5,6);
$pdf->Image('../archivos/gerenteOperaciones.jpg',31,31.5,15);
$pdf->Image('../archivos/leyendaFirmaEmpleado.jpg',8.5,31.5,13);

$code='img/barcode/barcode_'.$empleadoEntidad."-".$empleadoConsecutivo."-".$empleadoTipo.'.gif';



$A=new barCodeGenrator('*'.$empleadoEntidad."-".$empleadoConsecutivo."-".$empleadoTipo.'*',1,$code, 120, 100, true);

// $log -> LogInfo ("sessiok ".var_export ($A, true));
$pdf->Image($code,10,39,33.5,20);


if($fotoFirma!="")
{
$rutaFirma="uploads/firmas/".$fotoFirma;
$pdf->Image($rutaFirma,6,25.5,22);
}


$pdf->Output();
$response = array("status" => "success");



?>

