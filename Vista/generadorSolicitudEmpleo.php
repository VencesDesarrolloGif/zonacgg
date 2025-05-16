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
        "message" => "No se puede generar la solicitud de empleo porque no se recibió un folio válido."
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
$puesto=$aspirante[0]["puestoPreseleccion"];
$edad=$aspirante[0]["edadPreseleccion"];
$edoCivil=$aspirante[0]["edoCivil"];
$peso=$aspirante[0]["pesoPreseleccion"];
$estatura=$aspirante[0]["estaturaPreseleccion"];
$tallaCamisa=$aspirante[0]["tallaCamisaPreseleccion"];
$tallaPantalon=$aspirante[0]["tallaPantalonPreseleccion"];
$numCalzado=$aspirante[0]["numCalzadoPreseleccion"];
$genero=$aspirante[0]["generoPre"];
$tipoSangre=$aspirante[0]["tipoSangre"];
$fechaNacimiento=$aspirante[0]["fechaNacPreseleccion"];
$entidadNacimiento=$aspirante[0]["entidadPre"];
$codigoPostal=$aspirante[0]["cpPreseleccion"];
$calle=$aspirante[0]["callePreseleccion"];
$numeroCalle=$aspirante[0]["numeroPreseleccion"];
$colonia=$aspirante[0]["coloniaPreseleccion"];
$municipio=$aspirante[0]["municipioPreseleccion"];
$ciudad=$aspirante[0]["ciudadPreseleccion"];
$telFijo=$aspirante[0]["telFijoPreseleccion"];
$telMovil=$aspirante[0]["telMovilPreseleccion"];
$email=$aspirante[0]["emailPreseleccion"];
$infonavit=$aspirante[0]["infonavitPreseleccion"];
$fonacot=$aspirante[0]["fonacotPreseleccion"];
$cartilla=$aspirante[0]["cartillaPreseleccion"];
$licencia=$aspirante[0]["licenciaPreseleccion"];
$nImss=$aspirante[0]["nImssPreseleccion"];
$nombreE1=$aspirante[0]["nombreE1Preseleccion"];
$fecha1E1=$aspirante[0]["fecha1E1Preseleccion"];
$fecha2E1=$aspirante[0]["fecha2E1Preseleccion"];
$telefonoE1=$aspirante[0]["telefonoE1Preseleccion"];
$causaE1=$aspirante[0]["causaE1Preseleccion"];
$nombreE2=$aspirante[0]["nombreE2Preseleccion"];
$fecha1E2=$aspirante[0]["fecha1E2Preseleccion"];
$fecha2E2=$aspirante[0]["fecha2E2Preseleccion"];
$telefonoE2=$aspirante[0]["telefonoE2Preseleccion"];
$causaE2=$aspirante[0]["causaE2Preseleccion"];
$personasACargo=$aspirante[0]["personasACargoPreseleccion"];
$gradoEstudio=$aspirante[0]["gradoEstudios"];
$cursoEspecial=$aspirante[0]["cursoEspecialPreseleccion"];
$enfermedad=$aspirante[0]["enfermedadPreseleccion"];
$padre=$aspirante[0]["padrePreseleccion"];
$madre=$aspirante[0]["madrePreseleccion"];
$esposa=$aspirante[0]["esposaPreseleccion"];
$ben1=$aspirante[0]["ben1Preseleccion"];
$ben2=$aspirante[0]["ben2Preseleccion"];
$ben3=$aspirante[0]["ben3Preseleccion"];
$ben4=$aspirante[0]["ben4Preseleccion"];
$ben5=$aspirante[0]["ben5Preseleccion"];
$nombreR1=$aspirante[0]["nombreR1Preseleccion"];
$telefonoR1=$aspirante[0]["telefonoR1"];
$nombreR2=$aspirante[0]["nombreR2"];
$telefonoR2=$aspirante[0]["telefonoR2"];
$reclutador=$aspirante[0]["reclutadorPreseleccion"];
$fechaPrecontratacio=$aspirante[0]["fechapreseleccion"];

$fechaNac=date('d-m-Y', strtotime($fechaNacimiento));
$nombreMesNac=utf8_decode(strtoupper(strftime("%B", strtotime($fechaNac)) )); // Guardamos el Nombre del día de la semana.
$diaNac=strftime("%d", strtotime($fechaNac));
$anioNac=strftime("%Y", strtotime($fechaNac));



$pdf = new FPDI();

$pageCount = $pdf->setSourceFile("../archivos/expediente/solicitudEmpleo.pdf");
$tplIdx = $pdf->importPage(1);

$pdf->addPage('P', 'Letter');

$pdf->useTemplate($tplIdx, null, null, null, null, true); 


$pdf->SetFont("Arial", 'B',9);

$pdf->Text(118, 16, utf8_decode($folio));

//DATOS PERSONALES
$pdf->Text(20, 69, utf8_decode(strtoupper($puesto)));
$pdf->Text(110, 69, utf8_decode($email));
$pdf->Text(20, 81.2, utf8_decode(strtoupper($apPaterno)));
$pdf->Text(70, 81.2, utf8_decode(strtoupper($apMaterno)));
$pdf->Text(110, 81.2, utf8_decode(strtoupper($nombre)));
$pdf->Text(168, 81.2, utf8_decode($edad." AÑOS"));
$pdf->Text(20, 93, utf8_decode($peso." KG"));
$pdf->Text(49, 93, utf8_decode($estatura." M"));
$pdf->Text(70, 93, utf8_decode($tallaCamisa));
$pdf->Text(110, 93, utf8_decode($tallaPantalon));
$pdf->Text(168, 93, utf8_decode($numCalzado));
$pdf->Text(20, 105, utf8_decode(strtoupper($edoCivil)));
$pdf->Text(49, 105, utf8_decode(strtoupper($genero)));
$pdf->Text(70, 105, utf8_decode($tipoSangre));
$pdf->Text(110, 105, utf8_decode($diaNac." DE ".$nombreMesNac." DE ".$anioNac));
$pdf->Text(152, 105, utf8_decode(strtoupper($entidadNacimiento)));

//DATOS DE DOMICILIO
$pdf->Text(20, 131, utf8_decode(strtoupper($calle)));
$pdf->Text(57, 131, utf8_decode($numeroCalle));
$pdf->Text(74, 131, utf8_decode($codigoPostal));
$pdf->Text(92, 131, utf8_decode(strtoupper($colonia)));
$pdf->Text(145, 131, utf8_decode(strtoupper($municipio)));
$pdf->Text(20, 141, utf8_decode(strtoupper($ciudad)));
$pdf->Text(57, 141, utf8_decode($telFijo));
$pdf->Text(92, 141, utf8_decode($telMovil));

//DATOS DE AFILIACIONES
if($infonavit==0)
    $pdf->Text(44.5, 165.5, utf8_decode("X"));
else
    $pdf->Text(25.5, 165.5, utf8_decode("X"));

if($fonacot==0)
    $pdf->Text(81, 165.5, utf8_decode("X"));
else
    $pdf->Text(61.8, 165.5, utf8_decode("X"));

if($cartilla==0)
    $pdf->Text(118.8, 165.5, utf8_decode("X"));
else
    $pdf->Text(99.8, 165.5, utf8_decode("X"));

if($licencia==0)
    $pdf->Text(154.5, 165.5, utf8_decode("X"));
else
    $pdf->Text(135.3, 165.5, utf8_decode("X"));

$pdf->Text(168, 166, utf8_decode($nImss));


//DATOS LABORALES Y ACADEMICOS
$pdf->Text(20, 190, utf8_decode(strtoupper($nombreE1)));
$pdf->Text(62, 190, utf8_decode($fecha1E1));
$pdf->Text(97, 190, utf8_decode($fecha2E1));
$pdf->Text(130, 190, utf8_decode($telefonoE1));
$pdf->Text(157, 190, utf8_decode(strtoupper($causaE1)));
$pdf->Text(20, 199, utf8_decode(strtoupper($nombreE2)));
$pdf->Text(62, 199, utf8_decode($fecha1E2));
$pdf->Text(97, 199, utf8_decode($fecha2E2));
$pdf->Text(130, 199, utf8_decode($telefonoE2));
$pdf->Text(157, 199, utf8_decode(strtoupper($causaE2)));

if($personasACargo==0)
    $pdf->Text(49.3, 209, utf8_decode("X"));
else
    $pdf->Text(24.3, 209, utf8_decode("X"));

$pdf->Text(62, 209, utf8_decode(strtoupper($gradoEstudio)));
$pdf->Text(130, 209, utf8_decode(strtoupper($cursoEspecial)));


//DATOS FAMILIARES Y REFERENCIAS
$pdf->Text(20, 231.5, utf8_decode(strtoupper($padre)));
$pdf->Text(81, 231.5, utf8_decode(strtoupper($madre)));
$pdf->Text(142, 231.5, utf8_decode(strtoupper($esposa)));
$pdf->Text(20, 240.5, utf8_decode(strtoupper($ben1)));
$pdf->Text(81, 240.5, utf8_decode(strtoupper($ben2)));
$pdf->Text(142, 240.5, utf8_decode(strtoupper($ben3)));
$pdf->Text(20, 249, utf8_decode(strtoupper($ben4)));
$pdf->Text(112, 249, utf8_decode(strtoupper($ben5)));


$tplIdx = $pdf->importPage(2);
$pdf->addPage('P', 'Letter');
//$pdf->useTemplate($tplIdx, 5, 0, 200); ya estaba
$pdf->useTemplate($tplIdx, null, null, null, null, true); 

$pdf->SetFont("Arial", 'B',9);

$pdf->Text(20, 50, utf8_decode(strtoupper($enfermedad)));


$entidadCod = $_SESSION ["userLog"]["entidadFederativaUsuario"];
$entidad = $_SESSION ["userLog"]["nombreEntidad"];

$fecha=date("Y")."-".date("m")."-".date("d");

$nombreMes=utf8_decode(strtoupper(strftime("%B", strtotime($fecha)) )); // Guardamos el Nombre del día de la semana.
$dia=strftime("%d", strtotime($fecha));
$anio=strftime("%Y", strtotime($fecha));

if($entidadCod=='09'){
    $entidad="MEXICO, CDMX";
}

$pdf->SetFont("Arial", 'B',11);

$pdf->Text(20, 98, utf8_decode($entidad));

$pdf->Text(114,98, utf8_decode($dia."               ".$nombreMes."                     ".$anio));

$pdf->SetFont("Arial", 'B', 10);
$pdf->SetTextColor(188, 183, 182  );
$pdf->Text(113, 266.5, utf8_decode($reclutador));
$pdf->Text(11, 266.5, utf8_decode($fechaPrecontratacio));



$pdf->Output();
$response = array("status" => "success");



?>

