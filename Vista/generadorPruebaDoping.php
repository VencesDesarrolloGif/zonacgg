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

$folio=$_GET["folioAspirante"];


if (empty($folio))
{

    $response = array (
        "status" => "error",
        "message" => "No se puede generar la cadena de custodia porque no se recibió un folio válido."
    );
    
    echo json_encode ($response);
    
    exit;
}

//$log -> LogInfo ("entidadEmpleado ".var_export ($empleadoEntidad, true));
//$log -> LogInfo ("consecutivoEmpleado ".var_export ($empleadoConsecutivo, true));
//$log -> LogInfo ("empleadoTipo ".var_export ($empleadoTipo, true));


$aspirante= $negocio -> negocio_obtenerAspirante($folio);

if (empty ($aspirante))
{
    $response = array (
        "status" => "error",
        "message" => "El folio del aspirante no se encuentra registrado en el sistema."
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

$apPaterno=$aspirante[0]["apPaternoPreseleccion"];
$apMaterno=$aspirante[0]["apMaternoPreseleccion"];
$nombre=$aspirante[0]["nombrePreseleccion"];
$edad=$aspirante[0]["edadPreseleccion"];
$genero=$aspirante[0]["generoPreseleccion"];



$pdf = new FPDI();

$pageCount = $pdf->setSourceFile("../archivos/expediente/cadenaCustodia.pdf");
$tplIdx = $pdf->importPage(1);

$pdf->addPage('P', 'Letter');

$pdf->useTemplate($tplIdx, null, null, null, null, true); 


$pdf->SetFont("Arial", 'B',9);
//$pdf->SetTextColor(188, 183, 182  );


$entidadCod = $_SESSION ["userLog"]["entidadFederativaUsuario"];
$entidad = $_SESSION ["userLog"]["nombreEntidad"];

$pdf->Text(30, 72.5, utf8_decode(strtoupper($nombre)));

$pdf->Text(132, 72.5, utf8_decode(strtoupper($apPaterno)." ".strtoupper($apMaterno)));

$pdf->Text(20, 77.5, utf8_decode($edad." AÑOS"));

if($genero==1)
    $pdf->Text(100, 77.5, utf8_decode("X"));
else
    $pdf->Text(82, 77.5, utf8_decode("X"));

$pdf->Text(68, 83, utf8_decode("X"));





$pdf->Output();
$response = array("status" => "success");



?>

