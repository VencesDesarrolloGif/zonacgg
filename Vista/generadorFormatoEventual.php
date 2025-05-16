<?php
session_start();
use setasign\Fpdi\Fpdi;
require_once('../libs/fpdi/src/autoload.php');
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
require('../libs/fpdf/fpdf.php');
// require('../libs/fpdi/fpdi.php');

// $log = new KLogger ( "generarFormatoEventual.log" , KLogger::DEBUG );

$negocio = new Negocio();
$response = array ();



date_default_timezone_set('America/Mexico_City'); //Asignas la zona horaria de tu país.
setlocale(LC_TIME, 'spanish'); //Fijamos el tiempo local

verificarInicioSesion ($negocio);

$idEventual=$_GET["eventualId"];

if (empty($idEventual))
{

    $response = array (
        "status" => "error",
        "message" => "No se puede generar Formato Eventual."
    );  
    echo json_encode ($response);
    exit;
}

$usuarioCapturaNombre=$_SESSION ["userLog"]["nombre"];
$usuarioCapturApellidoMaterno=$_SESSION ["userLog"]["apellidoMaterno"];
$usuarioCapturaApellidoPaterno=$_SESSION ["userLog"]["apellidoPaterno"];


//$log -> LogInfo ("sesion ".var_export ($_SESSION ["userLog"], true));

$pdf = new FPDI();
$pageCount = $pdf->setSourceFile("../archivos/formularioRequisicionEv.pdf");
$tplIdx = $pdf->importPage(1);


$pdf->addPage('P', 'Letter');
$pdf->useTemplate($tplIdx, 5, null, 210);

$pdf->SetFont("Arial", 'B',14);
//$pdf->Text(65, 20, "FORMATO ENTRAGA DE DOCUMENTOS" );

$pdf->SetFont("Arial", 'B',10);
 //$pdf->Text(33, 72, utf8_decode($nombreCompleto) );
 //$pdf->Text(165, 37, $empleadoEntidad."-".$empleadoConsecutivo."-". $empleadoTipo );


//$pdf->SetFont("Arial", 'B',9);
//$fecha=date('d-m-Y');


$datosPuntoServicio= $negocio->selectDatosEventual($idEventual);

//$log->LogInfo("Valor de la variable \$datosPuntoServicio Datos: " . var_export ($datosPuntoServicio, true));


$folio=$datosPuntoServicio[0]["folioEventual"];
$cliente=$datosPuntoServicio[0]["razonSocial"];
$direccionFiscal=$datosPuntoServicio[0]["direccionFiscalCliente"];
$nombreComercial=$datosPuntoServicio[0]["nombreComercial"];
$rfcCliente=$datosPuntoServicio[0]["rfcCliente"];
$direccionPuntoServicio=$datosPuntoServicio[0]["direccionEventual"];
$fechaInicioServicio=$datosPuntoServicio[0]["fechaInicioEv"];
$fechaFinServicio=$datosPuntoServicio[0]["fechaFinEv"];

$contactoCliente=$datosPuntoServicio[0]["contactoCliente"];
$telefonoCliente=$datosPuntoServicio[0]["telefonoFijoCLiente"];
$puesto=$datosPuntoServicio[0]["descripcionPuesto"];
$turno=$datosPuntoServicio[0]["descripcionTurno"];
$cantidad=$datosPuntoServicio[0]["numElementosEv"];





//$log->LogInfo("Valor de la variable \$razonSocial Datos: " . var_export ($cliente, true));

$pdf->SetFont("Arial", 'B',10);

$pdf->SetXY(41, 19);
$pdf->MultiCell(165, 3.5, utf8_decode(strtoupper($usuarioCapturaNombre." ".$usuarioCapturaApellidoPaterno." ".$usuarioCapturApellidoMaterno)), 0, 'C');



$pdf->SetXY(41, 27);
$pdf->MultiCell(165, 3.5, utf8_decode(strtoupper($cliente)), 0, 'C');
$pdf->SetXY(41, 31);
$pdf->MultiCell(165, 3.5, utf8_decode(strtoupper($cliente)), 0, 'C');

$pdf->SetXY(41, 35);
$pdf->MultiCell(150, 3.5, utf8_decode(strtoupper($direccionFiscal)), 0, 'C');

$pdf->SetXY(41, 39);
$pdf->MultiCell(165, 3.5, utf8_decode(strtoupper($nombreComercial)), 0, 'C');

$pdf->SetXY(41, 43);
$pdf->MultiCell(165, 3.5, utf8_decode(strtoupper($rfcCliente)), 0, 'C');

$pdf->SetXY(41, 50);
$pdf->MultiCell(120, 5, utf8_decode(strtoupper($direccionPuntoServicio)), 0, 'C');

$pdf->SetFont("Arial", 'U',10);
$pdf->Text(180, 13, "FOLIO: EV-".$folio);

$pdf->SetFont("Arial", 'B',8);
$pdf->SetXY(107, 53);
$pdf->MultiCell(132, 10, utf8_decode(strtoupper($fechaInicioServicio)), 0, 'C');

$pdf->SetXY(130, 53);
$pdf->MultiCell(132, 10, utf8_decode(strtoupper($fechaFinServicio)), 0, 'C');
//echo $responseEmpleadoDocumento;

$pdf->SetFont("Arial", 'B',10);
$pdf->Text(32, 80, utf8_decode(strtoupper($contactoCliente)));
$pdf->Text(135, 80, utf8_decode(strtoupper($telefonoCliente)));

//$log->LogInfo("Valor de la variable \$response documentos: " . var_export ($response, true));
    $totalFacturar=0;
  $y=102;

  $pdf->SetFont("Arial", '',9);

$pdf->SetXY(47.5, $y);
$pdf->MultiCell(64.5, 7, utf8_decode(strtoupper($puesto)), 1, 1);

$pdf->SetXY(112, $y);
$pdf->MultiCell(10.3, 7,$cantidad, 1, 'C');

$pdf->SetFont("Arial", '',8);

$pdf->SetXY(122.3, $y);
$pdf->MultiCell(10.9, 7, utf8_decode(strtoupper($turno)), 1, 1);

 //echo $response["documentos"][$i]["nombreDocumento"]."</br>";
    
$subtotal=$datosPuntoServicio[0]["costoEventual"];

$iva=$subtotal*0.16;

$total=$subtotal+$iva;

$pdf->SetFont("Arial", '',7);

$pdf->SetXY(133.3, $y);
$pdf->MultiCell(15.7, 7, "$".number_format((float)$subtotal, 2, '.', ','), 1,'C');


$pdf->SetXY(149, $y);
$pdf->MultiCell(14.6, 7, "$".number_format((float)$iva, 2, '.', ','), 1, 'C');

$pdf->SetXY(163.6, $y);
$pdf->MultiCell(17.1, 7, "$".number_format((float)$total, 2, '.', ','), 1, 'C');


$elementosEv= $negocio->negocio_traerElementosByEventual($idEventual);


 $y=132;

$pdf->SetFont("Arial", '',9);
 for($i=0;$i<count($elementosEv);$i++){
    $nombreElemento=$elementosEv[$i]["nombreElemento"];
    $numeroElemento=$elementosEv[$i]["numeroEmpleado"];
    $apPaterno=$elementosEv[$i]["apPaternoE"];
    $apMaterno=$elementosEv[$i]["apMaternoE"];


    $pdf->SetXY(47,$y);
    $pdf->MultiCell(29.7, 6, utf8_decode(strtoupper($numeroElemento)), 1, 'C');

    $pdf->SetXY(76.8,$y);
    $pdf->MultiCell(31.1, 6, utf8_decode(strtoupper($nombreElemento)), 1, 'C');

    $pdf->SetXY(108,$y);
    $pdf->MultiCell(35.9, 6, utf8_decode(strtoupper($apPaterno)), 1, 'C');

    $pdf->SetXY(144,$y);
    $pdf->MultiCell(36.35, 6, utf8_decode(strtoupper($apMaterno)), 1, 'C');

    $y=$y+6;

 }  

    
 //$pdf->Text(33, 72, utf8_decode($nombreCompleto) );



$pdf->Output();

?>

