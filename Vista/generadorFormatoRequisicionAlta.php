<?php
session_start();
use setasign\Fpdi\Fpdi;
require_once('../libs/fpdi/src/autoload.php');
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
require('../libs/fpdf/fpdf.php');
// require('../libs/fpdi/fpdi.php');

// $log = new KLogger ( "generarFormatoRequisicionAlta.log" , KLogger::DEBUG );

$negocio = new Negocio();
$response = array ();



date_default_timezone_set('America/Mexico_City'); //Asignas la zona horaria de tu país.
setlocale(LC_TIME, 'spanish'); //Fijamos el tiempo local

verificarInicioSesion ($negocio);

$idPuntoServicio=$_GET["idPuntoServicio"];
$folio=$_GET["folio"];

if (empty($idPuntoServicio))
{

    $response = array (
        "status" => "error",
        "message" => "No se puede generar Formato de requisición."
    );  
    echo json_encode ($response);
    exit;
}

$usuarioCapturaNombre=$_SESSION ["userLog"]["nombre"];
$usuarioCapturApellidoMaterno=$_SESSION ["userLog"]["apellidoMaterno"];
$usuarioCapturaApellidoPaterno=$_SESSION ["userLog"]["apellidoPaterno"];


// $log -> LogInfo ("idPuntoServicio ".var_export ($idPuntoServicio, true));

$pdf = new FPDI();
$pageCount = $pdf->setSourceFile("../archivos/formularioRequisicionV8.pdf");
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


$datosPuntoServicio= $negocio->selectDatosPuntoServicio($idPuntoServicio);
$responseDatosPuntoServicio["datosPuntoServicio"]= $datosPuntoServicio;

// $log->LogInfo("Valor de la variable \$datosPuntoServicio Datos: " . var_export ($datosPuntoServicio, true));

$cliente=$datosPuntoServicio[0]["razonSocial"];
$direccionFiscal=$datosPuntoServicio[0]["direccionFiscalCliente"];
$nombreComercial=$datosPuntoServicio[0]["nombreComercial"];
$rfcCliente=$datosPuntoServicio[0]["rfcCliente"];
$direccionPuntoServicio=$datosPuntoServicio[0]["direccionPuntoServicio"];
$fechaInicioServicio=$datosPuntoServicio[0]["fechaInicioServicio"];

$contactoOperativo=$datosPuntoServicio[0]["contactoOperativo"];
$telefonoFijoOperativo=$datosPuntoServicio[0]["telefonoFijoOperativo"];
$telefonoMovilOperativo=$datosPuntoServicio[0]["telefonoMovilOperativo"];
$correoOperativo=$datosPuntoServicio[0]["correoOperativo"];
$terminoFacturacion=$datosPuntoServicio[0]["terminoFacturacion"];



//$log->LogInfo("Valor de la variable \$razonSocial Datos: " . var_export ($cliente, true));

$pdf->SetFont("Arial", 'B',10);

$pdf->SetXY(41, 19);
$pdf->MultiCell(165, 3.5, utf8_decode(strtoupper($usuarioCapturaNombre." ".$usuarioCapturaApellidoPaterno." ".$usuarioCapturApellidoMaterno)), 0, 'C');



$pdf->SetXY(41, 27);
$pdf->MultiCell(165, 3.5, utf8_decode(strtoupper($cliente)), 0, 'C');
$pdf->SetXY(41, 31);
$pdf->MultiCell(165, 3.5, utf8_decode(strtoupper($cliente)), 0, 'C');

$pdf->SetXY(41, 35);
$pdf->MultiCell(165, 3.5, utf8_decode(strtoupper($direccionFiscal)), 0, 'C');

$pdf->SetXY(41, 39);
$pdf->MultiCell(165, 3.5, utf8_decode(strtoupper($nombreComercial)), 0, 'C');

$pdf->SetXY(41, 43);
$pdf->MultiCell(165, 3.5, utf8_decode(strtoupper($rfcCliente)), 0, 'C');

$pdf->SetXY(41, 50);
$pdf->MultiCell(132, 10, utf8_decode(strtoupper($direccionPuntoServicio)), 0, 'C');



$pdf->SetFont("Arial", 'B',7);
$pdf->Text(173.5, 58,"FECHA INICIO  ".$fechaInicioServicio);

$pdf->SetFont("Arial", 'U',10);

$pdf->Text(180, 13, "FOLIO ".$folio);

//datos contacto operativo
$pdf->SetFont("Arial", 'B',10);
$pdf->Text(32, 74, utf8_decode(strtoupper($contactoOperativo)));
$pdf->Text(145, 74, $telefonoFijoOperativo);
$pdf->Text(145, 79, $telefonoMovilOperativo);
$pdf->SetFont("Arial", 'B',10);
$pdf->Text(32, 79, $correoOperativo);

//datos contacto facturacion

$contactoFacturacion=$datosPuntoServicio[0]["contactoFacturacion"];
$telefonoFijoFacturacion=$datosPuntoServicio[0]["telefonoFijoFacturacion"];
$telefonoMovilFacturacion=$datosPuntoServicio[0]["telefonoMovilFacturacion"];
$correoFacturacion=$datosPuntoServicio[0]["correoFacturacion"];

$pdf->Text(38, 94, utf8_decode(strtoupper($contactoFacturacion))." (".$correoFacturacion.")");
$pdf->Text(145, 94, $telefonoFijoFacturacion." / ". $telefonoMovilFacturacion);

//datos contacto tesoreria

$contactoTesoreria=$datosPuntoServicio[0]["contactoTesoreria"];
$telefonoFijoTesoreria=$datosPuntoServicio[0]["telefonoFijoTesoreria"];
$telefonoMovilTesoreria=$datosPuntoServicio[0]["telefonoMovilTesoreria"];
$correoTesoreria=$datosPuntoServicio[0]["correoTesoreria"];

$pdf->Text(41, 100, utf8_decode(strtoupper($contactoTesoreria))." (".$correoTesoreria.")");
$pdf->Text(145, 100, $telefonoFijoTesoreria." / ". $telefonoMovilTesoreria);


//Consultar plantilla

$requisicion= $negocio -> selectPlantillaRequisicion($idPuntoServicio);
$response["requisicion"]= $requisicion;

//echo $responseEmpleadoDocumento;

if (empty ($requisicion))
{
    $response = array (
        "status" => "error",
        "message" => "No se puede generar requisicion (No hay registro)."
    );
    
    echo json_encode ($response);
    
    exit;
}

//$log->LogInfo("Valor de la variable \$response documentos: " . var_export ($response, true));
    $totalFacturar=0;
  $y=109.5;

  $recursosMateriales="RECURSOS MATERIALES:";
  $perfiles="PERFIL:";


for ($i=0; $i< count($response["requisicion"]); $i++)
{
   //echo $response["documentos"][$i]["nombreDocumento"]."</br>";
    $servicioPlantillaId=$response["requisicion"][$i]["servicioPlantillaId"];
    //$descripcionTurno=$response["contactoOperativo"][$i]["contactoOperativo"];

    $descripcionPuesto=$response["requisicion"][$i]["descripcionPuesto"];
    $descripcionTurno=$response["requisicion"][$i]["descripcionTurno"];    
    $numeroElementos=$response["requisicion"][$i]["numeroElementos"];
    $turnosPorDia=$response["requisicion"][$i]["turnosPorDia"];
    $costoPorTurno=$response["requisicion"][$i]["costoPorTurno"];
    $costoPorElemento=$costoPorTurno*30;
    $costoPorMes=($costoPorTurno*30)*$numeroElementos;

    $cobraDescanso=$response["requisicion"][$i]["cobraDescanso"];
    $cobraFestivos=$response["requisicion"][$i]["cobraFestivos"];
    $cobraDia31=$response["requisicion"][$i]["cobraDia31"];
    $costoNetoFactura=$response["requisicion"][$i]["costoNetoFactura"];

    $subtotal=$costoNetoFactura/1.16;
    

    $iva=$subtotal*0.16;

    $total=$subtotal+$iva;

    $totalFacturar=$totalFacturar+$total;
   

    if($cobraDescanso==1){
        $cobraDescanso="SE COBRA";
    }else{
        $cobraDescanso="NO SE COBRA";
    }

    if($cobraFestivos==1){
        $cobraFestivos="SE COBRA";
    }else{
        $cobraFestivos="NO SE COBRA";
    }

    if($cobraDia31==1){
        $cobraDia31="SE COBRA";
    }else{
        $cobraDia31="NO SE COBRA";
    }

    $comentarioRequisicion=$response["requisicion"][$i]["comentarioRequisicion"];

    $recursosMateriales=$recursosMateriales." ".$response["requisicion"][$i]["recursosMateriales"].",";

    $perfiles=$perfiles." ".$response["requisicion"][$i]["comentarioRequisicion"].",";
    //$estatusDocumento=0;
    //$tipoDocumento=1;
    //$log->LogInfo("Valor de la variable \$responseEmpleadoDocumento: " . var_export ($responseEmpleadoDocumento["est"]["status"], true));
    //$log->LogInfo("Valor de la variable \$responseEmpleadoDocumento: " . var_export ($verificar, true));
    //$log->LogInfo("Valor de la variable \$responseEmpleadoDocumento Datos: " . var_export ($responseEmpleadoDocumento["est"]["datos"], true));

    $y=$y+7;

// echo "DOCUMENTO ENTREGADO" . $response["documentos"][$i]["nombreDocumento"]. "</br>";

        //$pdf->Text(50, $y, $descripcionPuesto." DE ".$descripcionTurno);
        //$pdf->Text(85, $y, $servicioPlantillaId);
        $pdf->SetFont("Arial", '',7);
        $pdf->SetXY(15.2, $y);
        $pdf->MultiCell(69.9, 7, utf8_decode(strtoupper($descripcionPuesto." DE". $descripcionTurno)), 1, 1);

        $pdf->SetXY(85, $y);
        $pdf->MultiCell(9.5, 7, $numeroElementos, 1, 1);

        $pdf->SetXY(94.5, $y);
        $pdf->MultiCell(10, 7, $turnosPorDia, 1, 1);

        $pdf->SetXY(104.5, $y);
        $pdf->MultiCell(12.5, 7, "$".number_format($costoPorTurno, 2, '.', ''), 1, 1);

        $pdf->SetXY(117, $y);
        $pdf->MultiCell(14.5, 7, "$".number_format((float)$costoPorElemento, 2, '.', ','), 1, 1);

        $pdf->SetFont("Arial", '',4);
        $pdf->SetXY(131.5, $y);
        $pdf->MultiCell(12, 7, $cobraDescanso, 1, 1);

        $pdf->SetXY(143.5, $y);
        $pdf->MultiCell(12.4, 7, $cobraFestivos, 1, 1);
        $pdf->SetFont("Arial", '',3);
        $pdf->SetXY(155.9, $y);
        $pdf->MultiCell(9.5, 7, $cobraDia31, 1, 1);

        $pdf->SetFont("Arial", '',6);
        $pdf->SetXY(165.4, $y);
        $pdf->MultiCell(14.6, 7, "$".number_format((float)$costoPorMes, 2, '.', ','), 1, 1);

        $pdf->SetXY(180, $y);
        $pdf->MultiCell(12, 7, "$".number_format((float)$iva, 2, '.', ','), 1, 1);

        $pdf->SetXY(192.2, $y);
        $pdf->MultiCell(15.8, 7, "$".number_format((float)$total, 2, '.', ','), 1, 1);


        if($i==count($response["requisicion"])-1){

        $pdf->SetXY(143.5, $y+7);
        $pdf->MultiCell(64.5, 7, "TOTAL PRESUPUESTADO A FACTURAR $".number_format((float)$totalFacturar, 2, '.', ','), 1, 1);


        $pdf->SetXY(15.2, 200);
        $pdf->MultiCell(193, 10, utf8_decode($recursosMateriales), 1, 1);

        $pdf->SetXY(15.2, 210);
        $pdf->MultiCell(193, 10, utf8_decode($perfiles), 1, 1);

        $pdf->SetXY(15.2, 220);
        $pdf->MultiCell(193, 10, utf8_decode("TERMINO FACTURACÓN: " .$terminoFacturacion), 1, 1);

        $pdf->SetFont("Arial", 'B',12);
        $pdf->Text(14.6, 200, "*");

        


        

        }

}


 //$pdf->Text(33, 72, utf8_decode($nombreCompleto) );



$pdf->Output();

?>

