<?php
session_start();
use setasign\Fpdi\Fpdi;
require_once('../libs/fpdi/src/autoload.php');
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
require_once "../libs/numLetras/numeroLetras.php";
require('../libs/fpdf/fpdf.php');
// require('../libs/fpdi/fpdi.php');
//$log = new KLogger ( "ajax_cargaPapeletaDeuda.log" , KLogger::DEBUG );
$negocio = new Negocio();
$response = array ();
verificarInicioSesion ($negocio);
$numletras  = new NumeroALetras();

$entidadEmpDeuda=$_GET["entidadEmpDeudaU"];
$consecutivoEmpDeuda=$_GET["consecutivoEmpDeudaU"];
$categoriaEmpDeuda=$_GET["categoriaEmpDeudaU"];
$idDeudaUni=$_GET["idDeudaUni"];

$deudascalzado= $negocio -> obtenerDeudaCalzado($entidadEmpDeuda, $consecutivoEmpDeuda, $categoriaEmpDeuda,$idDeudaUni);

    $idordenDU   =$deudascalzado[0]["idordenDU"];
    $nombreDeudor   =$deudascalzado[0]["nombreDeudor"];
    $numeroDeudor   =$deudascalzado[0]["numeroDeudor"];
    $fechaRecepcionUnifDeuda   =$deudascalzado[0]["fechaRecepcionUnifDeuda"];
    $FechaAsigUnifD   =$deudascalzado[0]["FechaAsigUnifD"];
    $puntoServicio  =$deudascalzado[0]["puntoServicio"];

if ($idordenDU!=0) {
    $fechaSeparada= explode(' ', $FechaAsigUnifD);
    $SoloFecha= $fechaSeparada[0];
}else{
    $fechaSeparada= explode(' ', $fechaRecepcionUnifDeuda);
    $SoloFecha= $fechaSeparada[0];
}
    $montoDeuda =$deudascalzado[0]["montoDeuda"];
    $firmaDeudor    =$deudascalzado[0]["firmaDeudor"];
    $nombreEmpAsigDeudar    =$deudascalzado[0]["nombreEmpAsigDeudar"];
    $firmaEmpAsigDeuda  =$deudascalzado[0]["firmaEmpAsigDeuda"];
    $letrasMONTO= $numletras->convertir($montoDeuda, 'PESOS', 'CENTAVOS');
    $letrasMONTO11= $letrasMONTO." 00/100 MXN";
    $largomonto = strlen($letrasMONTO11);
    if($largomonto>="40" && $largomonto<"80"){
        $letrasMONTO1=substr($letrasMONTO11, 0,40);
        $letrasMONTO2=substr($letrasMONTO11, 40,40);
    }else if($largomonto>="80" && $largomonto<"120"){
        $letrasMONTO1=substr($letrasMONTO11, 0,40);
        $letrasMONTO2=substr($letrasMONTO11, 40,40);
        $letrasMONTO3=substr($letrasMONTO11, 80,40);
    }else{
        $letrasMONTO1=$letrasMONTO11;
    }
$pdf = new FPDI();
$pageCount = $pdf->setSourceFile("../archivos/solicitudPago.pdf");
$tplIdx = $pdf->importPage(1);
$pdf->addPage();
$pdf->useTemplate($tplIdx, null, null, null, null, true); 
$pdf->SetFont("Arial", 'B',10);
$pdf->Text(42, 24, utf8_decode("CORPORATIVO GIF"));
$pdf->Text(40, 45.5, utf8_decode($nombreEmpAsigDeudar));//solicitante ;numero de la derecha es para arriba/abajo
$pdf->Text(198.5, 41.2, utf8_decode("X"));
$pdf->Text(40, 54, utf8_decode($nombreDeudor));
$pdf->Text(121, 32.5, utf8_decode($SoloFecha));
$pdf->Text(95, 83, utf8_decode("PRESTAMO"));
$pdf->Text(30, 103.5, utf8_decode("$".$montoDeuda));
$pdf->Text(40,128, utf8_decode($firmaEmpAsigDeuda));
$pdf->Text(40,124, utf8_decode($nombreEmpAsigDeudar));
$pdf->Text(120,128, utf8_decode($firmaDeudor));
$pdf->Text(120,124, utf8_decode($nombreDeudor));
$pdf->SetFont("Arial", 'B',9.5);
$pdf->Text(125.1, 45, utf8_decode($numeroDeudor));
$pdf->Text(145, 54, utf8_decode($puntoServicio));
$pdf->SetFont("Arial", 'B',8);
if($largomonto>="40" && $largomonto<"80"){
    $pdf->text(137, 103.5, utf8_decode($letrasMONTO1));
    $pdf->text(137, 107.5, utf8_decode($letrasMONTO2));
}else if($largomonto>="80" && $largomonto<"120"){
    $pdf->text(137, 103.5, utf8_decode($letrasMONTO1));
    $pdf->text(137, 107.5, utf8_decode($letrasMONTO2));
    $pdf->text(137, 111.5, utf8_decode($letrasMONTO3));
}else{
    $pdf->text(137, 103.5, utf8_decode($letrasMONTO1));
}

$pdf->Output();
$response = array("status" => "success");



?>

