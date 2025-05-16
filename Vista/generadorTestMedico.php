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
        "message" => "No se puede generar el test médico porque no se recibió un folio válido."
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
$edoCivil=$aspirante[0]["edoCivil"];
$genero=$aspirante[0]["generoPreseleccion"];
$email=$aspirante[0]["emailPreseleccion"];
$fechaNacimiento=$aspirante[0]["fechaNacPreseleccion"];

$reclutador=$aspirante[0]["reclutadorPreseleccion"];

$fechaNac=date('d-m-Y', strtotime($fechaNacimiento));
$nombreMesNac=utf8_decode(strtoupper(strftime("%B", strtotime($fechaNac)) )); // Guardamos el Nombre del día de la semana.
$diaNac=strftime("%d", strtotime($fechaNac));
$anioNac=strftime("%Y", strtotime($fechaNac));



$pdf = new FPDI();

$pageCount = $pdf->setSourceFile("../archivos/expediente/testMedico.pdf");
$tplIdx = $pdf->importPage(1);

$pdf->addPage('P', 'Letter');

$pdf->useTemplate($tplIdx, null, null, null, null, true); 


$pdf->SetFont("Arial", 'B',9);

$pdf->Text(52, 93.5, utf8_decode(strtoupper($nombre)." ".strtoupper($apPaterno)." ".strtoupper($apMaterno)));
$pdf->Text(165, 93.5, utf8_decode($edad." AÑOS"));
$pdf->Text(69, 98, utf8_decode($fechaNacimiento));

if($genero==2)
    $pdf->Text(129.5, 98, utf8_decode("__"));
else
    $pdf->Text(117, 98, utf8_decode("__"));

$pdf->Text(163, 98, utf8_decode(strtoupper($edoCivil)));





$tplIdx = $pdf->importPage(2);
$pdf->addPage('P', 'Letter');
//$pdf->useTemplate($tplIdx, 5, 0, 200);
$pdf->useTemplate($tplIdx, null, null, null, null, true); 

$pdf->SetFont("Arial", 'B',9);



$entidadCod = $_SESSION ["userLog"]["entidadFederativaUsuario"];
$entidad = $_SESSION ["userLog"]["nombreEntidad"];


if($entidadCod=='09'){
    $entidad="MEXICO, CDMX";
}


$pdf->Text(58, 232, utf8_decode(strtoupper($nombre)." ".strtoupper($apPaterno)." ".strtoupper($apMaterno)));


$pdf->Output();
$response = array("status" => "success");



?>

