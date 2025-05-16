<?php
session_start();
use setasign\Fpdi\Fpdi;
require_once('../libs/fpdi/src/autoload.php');
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
require_once "../libs/numLetras/numeroLetras.php";
require '../libs/fpdf/fpdf.php';
// require '../libs/fpdi/fpdi.php';
$negocio = new Negocio();
verificarInicioSesion($negocio);
//$log = new KLogger ( "ajaxgenerasolicitudpago.log" , KLogger::DEBUG );
//$log->LogInfo("Variable lineaNegocio: " . var_export ($descLineaNegocio, true) ."---->". var_export ($hdnidLineanegSolicitante, true));
$descEmpresa=$_GET["descripcionEmpresa"];
$areaSolicitante=$_GET["hdnCategoria"];  
$inpImporte=$_GET["inpImporte"];
$conceptos=$_GET["conceptos"];
$descripciones=$_GET["descripciones"];
$arraydescripciones = explode(",", $descripciones);//SE CONVIERTE $DESCRIPCIONES QUE VIENE DESDE JS A UN ARRAY EN PHP PARA PODER RECORRER EL ARREGLO Y PINTAR POSTERIORMENTE SUS VARIABLES EN EL DOCUMENTO
$importes=$_GET["importes"];
$arrayimportes = explode(",", $importes);//SE CONVIERTE $DESCRIPCIONES QUE VIENE DESDE JS A UN ARRAY EN PHP PARA PODER RECORRER EL ARREGLO Y PINTAR POSTERIORMENTE SUS VARIABLES EN EL DOCUMENTO
$observacion=$_GET["observacion"];//concepto del gasto CONCEPTO
$nombreEmpSolicita=$_GET["nombreEmpSolicita"];
$numeroEmpleado=($_GET["entidadEmpleadoSolicita"]."-".$_GET["ConsecutivoEmpleadoSolicita"]."-".$_GET["entidadEmpleadoSolicita"]);
$benificiario=$_GET["benificiario"];
$descripcionbanco=$_GET["descripcionbanco"];
$cuentaSolicitante=$_GET["cuentaSolicitante"];
$cuentaClabeSolicitante=$_GET["cuentaClabeSolicitante"];
$importe=$_GET["inpImporte"];
$fecha=date('d-m-Y');
$x="X";
$hdnidLineanegSolicitante=$_GET["hdnidLineanegSolicitante"];
$lineaNegocio=$negocio->negocio_obtenerListaLineaNegocio();
for($i=0;$i<count($lineaNegocio);$i++){
   if($lineaNegocio[$i]["idLineaNegocio"]==$hdnidLineanegSolicitante){
      $descLineaNegocio=$lineaNegocio[$i]["descripcionLineaNegocio"];
     break;
   }
}
date_default_timezone_set('America/Mexico_City'); //Asignas la zona horaria de tu país.
setlocale(LC_TIME, 'spanish'); //Fijamos el tiempo local
$pdf                       = new FPDI();
$numletras                 = new NumeroALetras();
$letras                    = $numletras->convertir($importe, 'PESOS', 'CENTAVOS');
$pageCount                 = $pdf->setSourceFile("../archivos/ComprobanteSolicitudPago.pdf");
$tplIdx                    = $pdf->importPage(1);
$tplIdx2                   = $pdf->importPage(2);
if($conceptos==0 || $conceptos==1){
//INICIA PAGINA 1
$pdf->addPage('P', 'Letter');
$pdf->useTemplate($tplIdx, null, null, null, null, true);
$pdf->SetFont("Arial", 'B', 9);
$pdf->SetXY(45.5, 48.5);
$pdf->MultiCell(58,5.4, utf8_decode($descEmpresa), 0, 'C');
$pdf->SetXY(45.5, 53.5);
$pdf->MultiCell(58,5.4, utf8_decode($areaSolicitante), 0, 'C');
$pdf->SetXY(139, 48.5);
$pdf->MultiCell(58,5.4, utf8_decode($fecha), 0, 'C');
if($conceptos==0){
$pdf->SetXY(139, 53.5);
$pdf->MultiCell(58,5.4, utf8_decode($x), 0, 'C');
}else if($conceptos==1){
$pdf->SetXY(139, 58.5);
$pdf->MultiCell(58,5.4, utf8_decode($x), 0, 'C');

}
 $coordy=106;
for($i=0;$i<count($arraydescripciones);$i++){
   $pdf->SetXY(12.5, $coordy);
   $pdf->MultiCell(33, 4, utf8_decode($arraydescripciones[$i]), 0, 'L');
   $pdf->SetXY(45, $coordy);
   $pdf->MultiCell(23, 4, utf8_decode("$".$arrayimportes[$i]), 0, 'C');
   $pdf->SetXY(173, $coordy);
   $pdf->MultiCell(24, 4, utf8_decode("$".$arrayimportes[$i]), 0, 'C');
   $coordy+=3;
}
$pdf->SetXY(45, 138);
$pdf->Cell(22.5, 5, utf8_decode("$" . number_format($importe, 2, '.', ',')), 0,0, 'C');
$pdf->SetXY(68, 105.5);
$pdf->MultiCell(70.5,2.5, utf8_decode($observacion), 0, 'C');
}//TERMINA PAGINA 1
//INICIA  PAGINA 2
$pdf->SetFont("Arial", 'B', 9);
$pdf->addPage('P', 'Letter');
$pdf->useTemplate($tplIdx2, null, null, null, null, true);
$pdf->SetXY(33, 28.6);
$pdf->MultiCell(112,4.9, utf8_decode($descEmpresa), 0, 'C');
$pdf->SetXY(118, 38.6);
$pdf->MultiCell(27.5, 4.4, utf8_decode($fecha), 0, 'C');
if($conceptos==0){
$pdf->SetXY(206, 29);
$pdf->MultiCell(5,4.8, utf8_decode($x), 0, 'C');
}else if($conceptos==1){
$pdf->SetXY(206, 38);
$pdf->MultiCell(5,4.8, utf8_decode($x), 0, 'C');
}else if($conceptos==2){
$pdf->SetXY(206,48);
$pdf->MultiCell(5,4.8, utf8_decode($x), 0, 'C');
}
$pdf->SetXY(33,48);
$pdf->MultiCell(67,9, utf8_decode($nombreEmpSolicita), 0, 'C');
$pdf->SetXY(126.5,48);
$pdf->MultiCell(19,9, utf8_decode($numeroEmpleado), 0, 'C');
$pdf->SetXY(33.2,62);
$pdf->MultiCell(112.3,4.3, utf8_decode($benificiario), 0, 'C');
$pdf->SetXY(149,62);
$pdf->MultiCell(66,4.3, utf8_decode($descLineaNegocio), 0, 'C');
$pdf->SetXY(33.2,71);
$pdf->MultiCell(40,9, utf8_decode($descripcionbanco), 0, 'C');
$pdf->SetXY(100,71);
$pdf->MultiCell(45,9, utf8_decode($cuentaSolicitante), 0, 'C');
$pdf->SetXY(173,71);
$pdf->MultiCell(42,9, utf8_decode($cuentaClabeSolicitante), 0, 'C');
$pdf->SetXY(1,91);
$pdf->MultiCell(214,3.5, utf8_decode($observacion), 0, 'C');
$pdf->SetXY(149,117);
$pdf->MultiCell(66,4, utf8_decode($letras. " 00/100 MXN"), 0, 'C');
$pdf->SetXY(46, 114.5);
$pdf->Cell(23, 9, utf8_decode("$" . number_format($importe, 2, '.', ',')), 0, 0, 'C');
//TERMINA  PAGINA 2
$pdf->Output();
$response = array("status" => "success");