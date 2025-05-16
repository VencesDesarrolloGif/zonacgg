<?php
session_start();
use setasign\Fpdi\Fpdi;
require_once('../libs/fpdi/src/autoload.php');
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
require('../libs/fpdf/fpdf.php');
// require('../libs/fpdi/fpdi.php');


// $log = new KLogger ( "generarEntregaDocumentos.log" , KLogger::DEBUG );

$negocio = new Negocio();
$response = array ();



date_default_timezone_set('America/Mexico_City'); //Asignas la zona horaria de tu país.
setlocale(LC_TIME, 'spanish'); //Fijamos el tiempo local

verificarInicioSesion ($negocio);

$empleadoEntidad=$_GET["entidadEmpleado"];
$empleadoConsecutivo=$_GET["consecutivoEmpleado"];
$empleadoTipo=$_GET["tipoEmpleado"];
$nombreCompleto=strtoupper($_GET["nombreCompleto"]);

if (empty($empleadoEntidad)
    || empty ($empleadoConsecutivo)
    || empty ($empleadoTipo))
{

    $response = array (
        "status" => "error",
        "message" => "No se puede generar Formato de documentos recibidos por que no se proporcionó un número de empleado válido."
    );  
    echo json_encode ($response);
    exit;
}

// $log -> LogInfo ("entidadEmpleado ".var_export ($empleadoEntidad, true));
// $log -> LogInfo ("consecutivoEmpleado ".var_export ($empleadoConsecutivo, true));
// $log -> LogInfo ("empleadoTipo ".var_export ($empleadoTipo, true));


$pdf = new FPDI();
$pageCount = $pdf->setSourceFile("../archivos/reciboDocumentosBlanco1.pdf");
$tplIdx = $pdf->importPage(1);


$pdf->addPage();
// $pdf->useTemplate($tplIdx, 5, 0, 200);
$pdf->useTemplate($tplIdx, 5, null, 200);

$pdf->SetFont("Arial", 'B',14);
 // $pdf->Text(65, 20, "FORMATO ENTRAGA DE DOCUMENTOS" );

$fecha=date('d-m-Y');
$fecha1 = explode('-', $fecha);
$dia = $fecha1[0];
$mes = $fecha1[1];
$anio = $fecha1[2];
$ultimosDos = substr($anio, -2);
$pdf->SetFont("Arial", 'B',10);
 $pdf->Text(35, 86, utf8_decode($nombreCompleto) );
 $pdf->Text(140, 48, $dia);
 $pdf->Text(162, 48, $mes);
 $pdf->Text(185, 48, $ultimosDos);


$pdf->SetFont("Arial", 'B',9);



$documentos= $negocio -> negocio_traerListaDocumentos();
$response["documentos"]= $documentos;



//echo $responseEmpleadoDocumento;


if (empty ($documentos))
{
    $response = array (
        "status" => "error",
        "message" => "El número de empleado proporcionado no se encuentra registrado en el sistema."
    );
    
    echo json_encode ($response);
    
    exit;
}

//$log->LogInfo("Valor de la variable \$response documentos: " . var_export ($response, true));

  $y=114.2; // se aumento 15 el original era 99.2
for ($i=0; $i< count($response["documentos"]); $i++)
{
   //echo $response["documentos"][$i]["nombreDocumento"]."</br>";
   $documentoId=$response["documentos"][$i]["idDocumento"];
    $estatusDocumento=1;
    $tipoDocumento=1;



    $verificar= $negocio -> negocio_consultarDocumentoEntregado($empleadoEntidad,$empleadoConsecutivo, $empleadoTipo, $documentoId,$tipoDocumento,$estatusDocumento);
    $responseEmpleadoDocumento["est"]= $verificar;
    $empleadoDocumento=$responseEmpleadoDocumento["est"]["status"];
    //$log->LogInfo("Valor de la variable \$responseEmpleadoDocumento: " . var_export ($responseEmpleadoDocumento["est"]["status"], true));
    //$log->LogInfo("Valor de la variable \$responseEmpleadoDocumento: " . var_export ($verificar, true));
    //$log->LogInfo("Valor de la variable \$responseEmpleadoDocumento Datos: " . var_export ($responseEmpleadoDocumento["est"]["datos"], true));

    $y=$y+4.15;

    if ($empleadoDocumento=="existe")
    {
       // echo "DOCUMENTO ENTREGADO" . $response["documentos"][$i]["nombreDocumento"]. "</br>";

        $pdf->Text(112, $y, "ENTREGO" );
        $pdf->Text(162, $y, $fecha);

    }

    

}

$z=116;
for ($i=0; $i< count($response["documentos"]); $i++)
{
   //echo $response["documentos"][$i]["nombreDocumento"]."</br>";
   $documentoId=$response["documentos"][$i]["idDocumento"];
    $estatusDocumento=1;
    $tipoDocumento=2;



    $verificar1= $negocio -> negocio_consultarDocumentoEntregado($empleadoEntidad,$empleadoConsecutivo, $empleadoTipo, $documentoId,$tipoDocumento,$estatusDocumento);
    $responseEmpleadoDocumento1["est"]= $verificar1;
    $empleadoDocumento1=$responseEmpleadoDocumento1["est"]["status"];
    // $log->LogInfo("Valor de la variable \$responseEmpleadoDocumento1: " . var_export ($responseEmpleadoDocumento1["est"]["status"], true));
    // $log->LogInfo("Valor de la variable \$responseEmpleadoDocumento1: " . var_export ($verificar1, true));
    // $log->LogInfo("Valor de la variable \$responseEmpleadoDocumento Datos1: " . var_export ($responseEmpleadoDocumento1["est"]["datos"], true));

    $z=$z+4.19;

    if ($empleadoDocumento1=="existe")
    {
       // echo "DOCUMENTO ENTREGADO" . $response["documentos"][$i]["nombreDocumento"]. "</br>";

        $pdf->Text(138, $z, "ENTREGO" );
       // $pdf->Text(170, $y, $fecha);

    }

    

}


$pdf->Output();

?>

