<?php
session_start();
use setasign\Fpdi\Fpdi;
require_once('../libs/fpdi/src/autoload.php');
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
require('../libs/fpdf/fpdf.php');
// require('../libs/fpdi/fpdi.php');

// $log = new KLogger ( "generarResponsiva.log" , KLogger::DEBUG );

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

$fecha =date('d-m-Y');
 
$fecha30diasdespues = date('Y-m-d',strtotime('+30 days', strtotime($fecha)));

$dia=strftime("%d", strtotime($fecha30diasdespues));
$nombreMes=utf8_decode(strtoupper(strftime("%B", strtotime($fecha30diasdespues)) ));
$anio=strftime("%Y", strtotime($fecha30diasdespues));

$pdf = new FPDI();
$pageCount = $pdf->setSourceFile("../archivos/cartaResponsivaBlanco1.pdf");
$tplIdx = $pdf->importPage(1);

$pdf->addPage();
$pdf->useTemplate($tplIdx, 5, null, 200);

 $pdf->SetFont("Arial", 'B',14);
 $pdf->Text(80, 20, "CARTA RESPONSIVA" );

 $pdf->SetFont("Arial", 'B',10);
 $pdf->Text(70, 45, utf8_decode($nombreCompleto) );
 //$pdf->Text(165, 37, $empleadoEntidad."-".$empleadoConsecutivo."-". $empleadoTipo );
 $pdf->Text(125, 52, $dia);
 $pdf->Text(140, 52, $nombreMes);
 $pdf->Text(173, 52, $anio);

$pdf->SetFont("Arial", 'B',9);
//$fecha=date('d-m-Y');

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

// $log->LogInfo("Valor de la variable \$response documentos: " . var_export ($response, true));

  $y=78;
for ($i=0; $i< count($response["documentos"]); $i++)
{
   //echo $response["documentos"][$i]["nombreDocumento"]."</br>";
    $documentoId=$response["documentos"][$i]["idDocumento"];
    $estatusDocumento=0;
    $tipoDocumento=1;

    $verificar= $negocio -> consultarDocumentoPendientePorEntregar($empleadoEntidad,$empleadoConsecutivo, $empleadoTipo, $documentoId,$tipoDocumento);
    $responseEmpleadoDocumento["est"]= $verificar;
    $empleadoDocumento=$responseEmpleadoDocumento["est"]["status"];
    // $log->LogInfo("Valor de la variable \$responseEmpleadoDocumento: " . var_export ($responseEmpleadoDocumento["est"]["status"], true));
    // $log->LogInfo("Valor de la variable \$responseEmpleadoDocumento: " . var_export ($verificar, true));
    // $log->LogInfo("Valor de la variable \$responseEmpleadoDocumento Datos: " . var_export ($responseEmpleadoDocumento["est"]["datos"], true));

    $y=$y+4;

    if ($empleadoDocumento=="noExiste")
    {
       // echo "DOCUMENTO ENTREGADO" . .$response["documentos"][$i]["nombreDocumento"]. "</br>";

        $pdf->Text(140, $y, "X" );
        $pdf->Text(160, $y, $fecha30diasdespues);

    }
}

$pdf->Output();

?>