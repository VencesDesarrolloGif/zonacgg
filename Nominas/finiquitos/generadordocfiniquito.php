<?php
session_start();
use setasign\Fpdi\Fpdi;
require_once('../../libs/fpdi/src/autoload.php');
require "../conexion/conexion.php";
require_once "../../libs/logger/KLogger.php";
require_once "../../libs/numLetras/numeroLetras.php";
require '../../libs/fpdf/fpdf.php';
// require '../../libs/fpdi/fpdi.php';
$numempleado    = $_GET["numempleado"];
$fechabaja      = $_GET["fechabaja"];
$fechaalta      = $_GET["fechaalta"];

$empleadoidd = explode("-", $numempleado);
/*
          $entidademp     = substr($numempleado, 0, 2);
$consecutivoemp = substr($numempleado, 3, 4);
$categoriaemp   = substr($numempleado, 8, 2); 
*/
        $entidademp=$empleadoidd[0];
        $consecutivoemp=$empleadoidd[1];
        $categoriaemp=$empleadoidd[2];          
$datos          = array();
//$log = new KLogger("ajax_diastrabajados.log", KLogger::DEBUG);
$sql = "SELECT concat(empleados.entidadFederativaId,'-',empleados.empleadoConsecutivoId,'-',empleados.empleadoCategoriaId)AS numempleado,
                    concat(empleados.apellidoPaterno,' ',empleados.apellidoMaterno,' ',empleados.nombreEmpleado) AS nombreempleado,
                     catalogopuestos.descripcionPuesto,entidadesfederativas.nombreEntidadFederativa,datosimss.fechaImss,datosimss.fechaBajaImss,finiquitos.fechaAlta,finiquitos.fechaBaja,
                     finiquitos.prestamoFiniquito,finiquitos.infonavitFiniquito,finiquitos.fonacotFiniquito,cuotas_empleados.cuotaDiariaEmpleado, finiquitos.diasTrabajados, finiquitos.antiguedadTotal,
                     finiquitos.diasParaPPVacaciones, finiquitos.factorPropVacaciones, finiquitos.calculoDiasAguinaldo,
                     finiquitos.separacion, finiquitos.diasDeVacaciones, finiquitos.factorDiasAguinaldo, finiquitos.propVacaciones,
                     finiquitos.primaVacacionalNeta, finiquitos.proporcionNetaAguinaldo,finiquitos.diasDePago,
                     finiquitos.aumentoGratificacion, finiquitos.calculoBruto, finiquitos.pagoNeto,finiquitos.propVacacionesSA,finiquitos.primaVacacionalSA,
                     finiquitos.propAginaldoSA,finiquitos.diasPagoSA,finiquitos.pagoNetoSA,finiquitos.diferenciaGratificacionSA,finiquitos.ingresoAcumulableSA,finiquitos.limiteInferiorisr,
                     finiquitos.excedenteLimiteSA,finiquitos.tasaAplicable,finiquitos.resultado,finiquitos.cuotaFija,finiquitos.isr,finiquitos.netoAlPago,datosimss.salarioDiario,finiquitos.pensionFiniquito,finiquitos.VacacionesPendientes,finiquitos.ProporcionVacPorAntig,finiquitos.uniformesFiniquito,finiquitos.idFiniquito
            FROM  finiquitos
               LEFT JOIN  empleados
               ON finiquitos.entidadEmpFiniquito=empleados.entidadFederativaId
               AND finiquitos.consecutivoEmpFiniquito=empleados.empleadoConsecutivoId
               AND finiquitos.categoriaEmpFiniquito=empleados.empleadoCategoriaId
               LEFT JOIN datosimss
               ON datosimss.empladoEntidadImss=empleados.entidadFederativaId
               AND datosimss.empleadoConsecutivoImss=empleados.empleadoConsecutivoId
               AND datosimss.empleadoCategoriaImss=empleados.empleadoCategoriaId
               LEFT JOIN cuotas_empleados
               ON cuotas_empleados.empleadoEntidadCuota=finiquitos.entidadEmpFiniquito
               AND cuotas_empleados.empleadoConsecutivoCuota=finiquitos.consecutivoEmpFiniquito
               AND cuotas_empleados.empleadoCategoriaCuota=finiquitos.categoriaEmpFiniquito
               LEFT JOIN  catalogopuestos
               ON empleados.empleadoIdPuesto=catalogopuestos.idPuesto
               LEFT JOIN entidadesfederativas
               ON empleados.idEntidadTrabajo=entidadesfederativas.idEntidadFederativa
            where finiquitos.entidadEmpFiniquito='$entidademp'
            and finiquitos.consecutivoEmpFiniquito='$consecutivoemp'
            and finiquitos.categoriaEmpFiniquito='$categoriaemp'
            and finiquitos.fechaAlta='$fechaalta'
            and finiquitos.fechaBaja='$fechabaja'";
$res = mysqli_query($conexion, $sql);
while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {
    $datos[] = $reg;}
date_default_timezone_set('America/Mexico_City'); //Asignas la zona horaria de tu país.
setlocale(LC_TIME, 'spanish'); //Fijamos el tiempo local
$nombre                    = $datos[0]["nombreempleado"];
$estadoentidad             = $datos[0]["nombreEntidadFederativa"];
$puesto                    = $datos[0]["descripcionPuesto"];
$sueldodiario              = $datos[0]["salarioDiario"];
$fechaingresosinformat     = $datos[0]["fechaAlta"];
$fechaingreso              = date('d-m-Y', strtotime($fechaingresosinformat));
$fechabajasinformat        = $datos[0]["fechaBaja"];
$fechabaja                 = date('d-m-Y', strtotime($fechabajasinformat));
$aniodefechabaja           = date('Y', strtotime($fechabajasinformat));
$antiguedadtotal           = $datos[0]["antiguedadTotal"];
$diasdevacaciones1         = $datos[0]["diasDeVacaciones"];
$VacacionesPendientes      = $datos[0]["VacacionesPendientes"];
$ProporcionVacPorAntig      = $datos[0]["ProporcionVacPorAntig"];
/*if($VacacionesPendientes=="" || $VacacionesPendientes==NULL || $VacacionesPendientes==null || $VacacionesPendientes=="null" || $VacacionesPendientes=="NULL"){
  $VacacionesPendientes="0";}
$diasdevacaciones          = $diasdevacaciones1 + $VacacionesPendientes; */
$diasparappdevacaciones    = $datos[0]["diasParaPPVacaciones"];
$factorpropvacaciones      = $datos[0]["factorPropVacaciones"];
$propvacacionesSA          = $datos[0]["propVacacionesSA"];
$primavacacionalSA         = $datos[0]["primaVacacionalSA"];
$dias                      = 15; //valor fijo
$calculodiasaguinaldo      = $datos[0]["calculoDiasAguinaldo"];
$factordiasaguinaldo       = $datos[0]["factorDiasAguinaldo"];
$propaginaldoSA            = $datos[0]["propAginaldoSA"];
$diastrabajados            = $datos[0]["diasTrabajados"];
$diaspagoSA                = $datos[0]["diasPagoSA"];
$diferenciagratificacionSA = $datos[0]["diferenciaGratificacionSA"];
$calculobruto              = $datos[0]["calculoBruto"];
$isr                       = $datos[0]["isr"];
$prestamofiniquito         = $datos[0]["prestamoFiniquito"];
//$uniformesfiniquito         = $datos[0]["uniformesFiniquito"];
//$TotalPrestamo = $prestamofiniquito+$uniformesfiniquito;
$infonavitfiniquito        = $datos[0]["infonavitFiniquito"];
$fonacotfiniquito          = $datos[0]["fonacotFiniquito"];
$pension                   = $datos[0]["pensionFiniquito"]; //valor fijo preguntar que procede
$netoalPago1               = $datos[0]["netoAlPago"];
$netoalPago                = round($netoalPago1);
$puesto                    = $datos[0]["descripcionPuesto"];
$idFiniquito                    = $datos[0]["idFiniquito"];
$pdf                       = new FPDI();
$numletras                 = new NumeroALetras();
$letras                    = $numletras->convertir($netoalPago, 'PESOS', 'CENTAVOS');
$pageCount                 = $pdf->setSourceFile("../../archivos/nominasandfiniquitos/FormatoFiniquito.pdf");
$tplIdx                    = $pdf->importPage(1);
$pdf->addPage('P', 'Letter');
$pdf->useTemplate($tplIdx, null, null, null, null, true);
$pdf->SetFont("Arial", 'B', 9);
$pdf->SetXY(50, 47);
$pdf->Cell(140, 6, utf8_decode($numempleado), 0, 0, 'L');
$pdf->Text(51, 57, utf8_decode($nombre));
$pdf->Text(51, 63, utf8_decode(strtoupper($estadoentidad)));
$pdf->Text(51, 69, utf8_decode($puesto));
$pdf->Text(51, 75, utf8_decode(number_format($sueldodiario, 2, '.', ',')));
$pdf->Text(51, 81, utf8_decode($fechaingreso));
$pdf->Text(51, 87, utf8_decode($fechabaja));
$pdf->Text(51, 93, utf8_decode($antiguedadtotal));
$pdf->SetFont("Arial", 'B', 7);
$pdf->setTextColor(49, 84, 150);
$pdf->Text(50, 99.2, utf8_decode($aniodefechabaja . ":"));
$pdf->SetFont("Arial", 'B', 9);
$pdf->setTextColor(0, 0, 0);
$pdf->Text(58, 99.2, utf8_decode($calculodiasaguinaldo));
$pdf->SetXY(60.5, 107);
$pdf->Cell(23.5, 12, utf8_decode($ProporcionVacPorAntig), 0, 0, 'C');
$pdf->SetXY(96, 107);
$pdf->Cell(25, 12, utf8_decode($diasparappdevacaciones), 0, 0, 'C');
$pdf->SetXY(133, 107);
$pdf->Cell(24.5, 12, utf8_decode(number_format($factorpropvacaciones, 2, '.', ',')), 0, 0, 'C');
$pdf->SetXY(157.5, 107);
$pdf->Cell(33, 12, utf8_decode(number_format($propvacacionesSA, 2, '.', ',')), 0, 0, 'R');
$pdf->SetXY(157.5, 119);
$pdf->Cell(33, 6, utf8_decode(number_format($primavacacionalSA, 2, '.', ',')), 0, 0, 'R');
$pdf->SetXY(60.5, 125);
$pdf->Cell(23.5, 12, utf8_decode($dias), 0, 0, 'C');
$pdf->SetXY(96, 125);
$pdf->Cell(25, 12, utf8_decode($calculodiasaguinaldo), 0, 0, 'C');
$pdf->SetXY(133, 125);
$pdf->Cell(24.5, 12, utf8_decode(number_format($factordiasaguinaldo, 2, '.', ',')), 0, 0, 'C');
$pdf->SetXY(157.5, 125);
$pdf->Cell(33, 12, utf8_decode(number_format($propaginaldoSA, 2, '.', ',')), 0, 0, 'R');
$pdf->SetXY(133, 137);
$pdf->Cell(24.5, 6, utf8_decode($diastrabajados), 0, 0, 'C');
$pdf->SetXY(157.5, 137);
$pdf->Cell(33, 6, utf8_decode(number_format($diaspagoSA, 2, '.', ',')), 0, 0, 'R');
$pdf->SetXY(157.5, 143);
$pdf->Cell(33, 6, utf8_decode(number_format($diferenciagratificacionSA, 2, '.', ',')), 0, 0, 'R');
$pdf->SetXY(157.5, 149);
$pdf->Cell(33, 6, utf8_decode(number_format($calculobruto, 2, '.', ',')), 0, 0, 'R');
$pdf->SetXY(157.5, 155);
$pdf->Cell(33, 6, utf8_decode(number_format($isr, 2, '.', ',')), 0, 0, 'R');
$pdf->SetXY(157.5, 161);
$pdf->Cell(33, 6, utf8_decode(number_format($prestamofiniquito, 2, '.', ',')), 0, 0, 'R');
$pdf->SetXY(157.5, 167);
$pdf->Cell(33, 6, utf8_decode(number_format($infonavitfiniquito, 2, '.', ',')), 0, 0, 'R');
//$pdf->Text(168, 163.5, utf8_decode(number_format($infonavitfiniquito, 2, '.', ',')));
$pdf->SetXY(157.5, 172.5);
$pdf->Cell(33, 6, utf8_decode(number_format($fonacotfiniquito, 2, '.', ',')), 0, 0, 'R');
//$pdf->Text(158, 169.5, utf8_decode(number_format($fonacotfiniquito, 2, '.', ',')));
$pdf->SetXY(157.5, 178.5);
$pdf->Cell(33, 6, utf8_decode(number_format($pension, 2, '.', ',')), 0, 0, 'R');
//$pdf->Text(158, 175.5, utf8_decode(number_format($pension, 2, '.', ',')));
$pdf->SetXY(157.5, 185);
$pdf->Cell(33, 6, utf8_decode("$" . number_format($netoalPago, 2, '.', ',')), 0, 0, 'R');
$pdf->SetXY(58, 202);
$pdf->MultiCell(132.5, 6, utf8_decode($letras . " 00/100 MXN"), 0, 'C');
$pdf->SetXY(69, 225.5);
$pdf->MultiCell(98, 5, utf8_decode($puesto), 0, 'C');
$pdf->SetXY(17.3, 254.8);
$pdf->MultiCell(100, 3, utf8_decode($nombre), 0, 'C');
$pdf->Text(182, 270, utf8_decode($idFiniquito));

//$pdf->SetXY(69, 225.5);
//$pdf->MultiCell(98, 5, utf8_decode("DIRECCION DE COMUNICACION E IMAGEN CORPORATIVA"), 0, 'L');
$pdf->Output();
$response = array("status" => "success");
