<?php
session_start();
use setasign\Fpdi\Fpdi;
require_once('../libs/fpdi/src/autoload.php');
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
require('../libs/fpdf/fpdf.php');
// require('../libs/fpdi/fpdi.php');
// $log = new KLogger ( "generarCartaPatronal.log" , KLogger::DEBUG );
$negocio = new Negocio();
$response = array ();
verificarInicioSesion ($negocio);
$empleadoEntidad=$_GET["entidadEmpleado"];
$empleadoConsecutivo=$_GET["consecutivoEmpleado"];
$empleadoTipo=$_GET["tipoEmpleado"];
$usuario=$_SESSION ["userLog"];
if (empty($empleadoEntidad)
    || empty ($empleadoConsecutivo)
    || empty ($empleadoTipo))
{

    $response = array (
        "status" => "error",
        "message" => "No se puede generar Contrato S.A por que no se proporcionó un número de empleado válido."
    );
    
    echo json_encode ($response);
    
    exit;
}
//$log -> LogInfo ("entidadEmpleado ".var_export ($empleadoEntidad, true));
//$log -> LogInfo ("consecutivoEmpleado ".var_export ($empleadoConsecutivo, true));
//$log -> LogInfo ("empleadoTipo ".var_export ($empleadoTipo, true));
$empleado= $negocio -> negocio_obtenerEmpleadoPorId($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo,$usuario);
$response["empleado"]= $empleado;

// $log -> LogInfo ("empleado ".var_export ($empleado, true));

if (empty ($empleado))
{
    $response = array (
        "status" => "error",
        "message" => "El número de empleado proporcionado no se encuentra registrado en el sistema."
    );
    
    echo json_encode ($response);
    
    exit;
}
//primer empleo
$foliopreseleccion=$response["empleado"][0]["foliopreseleccion"];
// $log -> LogInfo ("foliopreseleccion ".var_export ($foliopreseleccion, true));
if($foliopreseleccion!=NULL){
$datospreseleccion= $negocio ->negocio_obtenerAspirante($foliopreseleccion);
$nombreempleo1=$datospreseleccion[0]["nombreE1Preseleccion"];
$fechaempleo1desdesinformato=$datospreseleccion[0]["fecha1E1Preseleccion"];
$date = new DateTime($fechaempleo1desdesinformato);
$fechaempleo1desde= $date->format('d-m-Y');
$fechaempleo1hastasinformato=$datospreseleccion[0]["fecha2E1Preseleccion"];
$date1 = new DateTime($fechaempleo1hastasinformato);
$fechaempleo1hasta= $date1->format('d-m-Y');
$telempleo1=$datospreseleccion[0]["telefonoE1Preseleccion"];
$causaseparacionempleo1=$datospreseleccion[0]["causaE1Preseleccion"];
////////segundoempleo
$nombreempleo2=$datospreseleccion[0]["nombreE2Preseleccion"];
$fechaempleo2desdesinformato=$datospreseleccion[0]["fecha1E2Preseleccion"];
$date2 = new DateTime($fechaempleo2desdesinformato);
$fechaempleo2desde= $date2->format('d-m-Y');
$fechaempleo2hastasinformato=$datospreseleccion[0]["fecha2E2Preseleccion"];
$date3 = new DateTime($fechaempleo2hastasinformato);
$fechaempleo2hasta= $date3->format('d-m-Y');
$telempleo2=$datospreseleccion[0]["telefonoE2Preseleccion"];
$causaseparacionempleo2=$datospreseleccion[0]["causaE2Preseleccion"];
}
//$log->LogInfo("Valor de la variable \$responseprese: " . var_export ($nombreempleo1, true));
//$log->LogInfo("Valor de la variable \$response empleado: " . var_export ($response, true));
//$log->LogInfo("Valor de la variable \$empleado empleado: " . var_export ($response["empleado"][0]["apellidoPaterno"], true));
//$log->LogInfo("Valor de la variable \$apellido paterno empleado: " . var_export ($response["empleado"]["apellidoPaterno"], true));
date_default_timezone_set('America/Mexico_City'); //Asignas la zona horaria de tu país.
setlocale(LC_TIME, 'spanish'); //Fijamos el tiempo local
//echo “Hoy es:”.$diaSemana; //Imprimimos El día.
$apellidoPaterno=$response["empleado"][0]["apellidoPaterno"];
$apellidoMaterno=$response["empleado"][0]["apellidoMaterno"];
$nombreEmpleado=$response["empleado"][0]["nombreEmpleado"];
$empleadoNumeroSeguroSocial=$response["empleado"][0]["empleadoNumeroSeguroSocial"];
$rfcEmpleado=$response["empleado"][0]["rfcEmpleado"];
$calle = $response["empleado"][0]["calle"];
$numeroExterior = $response["empleado"][0]["numeroExterior"];
$numeroInterior = $response["empleado"][0]["numeroInterior"];
$fechaIngreso= $response["empleado"][0]["fechaIngresoEmpleado"];
$fechaNacimiento= $response["empleado"][0]["fechaNacimiento"];
$curp= $response["empleado"][0]["curpEmpleado"];
$telefono1= $response["empleado"][0]["telefonoFijoEmpleado"];
$telefono2= $response["empleado"][0]["telefonoMovilEmpleado"];
$genero= $response["empleado"][0]["descripcionGenero"];
$gradoEstudios= $response["empleado"][0]["descripcionGradoEstudios"];
$estadoCivil= $response["empleado"][0]["descripcionEstadoCivil"];
$numeroCartilla= $response["empleado"][0]["numeroCartilla"];
$oficio= $response["empleado"][0]["descripcionOficio"];
$tipoSangre= $response["empleado"][0]["tipoSangre"];
$entidadNacimiento= $response["empleado"][0]["entidadNacimiento"];
$municipioNacimiento= $response["empleado"][0]["municipioNacimiento"];
$diasEdad= $response["empleado"][0]["diasEdad"];
$fotoEmpleado=$response["empleado"][0]["fotoEmpleado"];
$estatura=$response["empleado"][0]["estaturaEmpleado"];
$tallaCamisa=$response["empleado"][0]["tallaCEmpleado"];
$tallaPantalon=$response["empleado"][0]["tallaPEmpleado"];
$pesoEmpleado=$response["empleado"][0]["pesoEmpleado"];
$puntoServicio=$response["empleado"][0]["puntoServicio"];
$edad=$diasEdad/365;
$fecha2=date("m-d-Y",strtotime($fechaIngreso));
$asentamiento =$response["empleado"][0]["calle"]." ".$response["empleado"][0]["numeroExterior"]." ".$response["empleado"][0]["numeroInterior"]." ". $response["empleado"][0]["nombreTipoAsentamiento"]." ". $response["empleado"][0]["nombreAsentamiento"];
$asentamiento2=$asentamiento." ".$response["empleado"][0]["nombreMunicipio"].", ".$response["empleado"][0]["nombreEntidadFederativa"].", C.P. ".$response["empleado"][0]["codigoPostalAsentamiento"];
//$nombreMunicipio =  $response["empleado"][0]["nombreMunicipio"].",".$response["empleado"][0]["nombreEntidadFederativa"];
$fecha3=date('d-m-Y', strtotime($fechaIngreso));
$diaSemana=utf8_decode(strtoupper(strftime("%A", strtotime($fecha3)) )); 
$nombreMes=utf8_decode(strtoupper(strftime("%B", strtotime($fecha3)) )); // Guardamos el Nombre del día de la semana.
$dia=strftime("%d", strtotime($fecha3));
$anio=strftime("%Y", strtotime($fecha3));
$fechaNac=date('d-m-Y', strtotime($fechaNacimiento));
$nombreMesNac=utf8_decode(strtoupper(strftime("%B", strtotime($fechaNac)) )); // Guardamos el Nombre del día de la semana.
$diaNac=strftime("%d", strtotime($fechaNac));
$anioNac=strftime("%Y", strtotime($fechaNac));
$pdf = new FPDI();
$pageCount = $pdf->setSourceFile("../archivos/hojaDatos.pdf");
$tplIdx = $pdf->importPage(1);
$pdf->addPage();
$pdf->useTemplate($tplIdx, 5, null, 200);
$pdf->SetFont("Arial", 'B',11);
//inserto la cabecera poniendo una imagen dentro de una celda
//$pdf->Cell(50,50,$pdf->Image('img/09516003.jpg',10,20,20),1,1,'C');
$rutaImagen="thumbs/".$fotoEmpleado;
if(file_exists($rutaImagen)){
    $rutaImagen="thumbs/".$fotoEmpleado;
}else{
    $rutaImagen="uploads/fotosempleados/".$fotoEmpleado;
}
$pdf->Image($rutaImagen,17,27,26);
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(49, 28);
$pdf->Cell(52,5,utf8_decode($nombreEmpleado),0,1,'L');
$pdf->SetXY(101, 28);
$pdf->Cell(51,5,utf8_decode($apellidoPaterno),0,1,'L');
$pdf->SetXY(152, 28);
$pdf->Cell(45,5,utf8_decode($apellidoMaterno),0,1,'L');
$pdf->Text(75, 45, utf8_decode($rfcEmpleado));
$pdf->Text(150, 45, $empleadoNumeroSeguroSocial);
$pdf->Text(75, 55, $curp);
$pdf->SetFont('Arial','B',8);
$pdf->Text(162,55, $dia."/".$nombreMes."/".$anio);
$pdf->Text(176, 87, utf8_decode($genero));
$pdf->SetXY(14, 125);
$pdf->Cell(26, 6, utf8_decode($tipoSangre), 0, 0, 'C');
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(40, 60);
$pdf->MultiCell(110, 5, utf8_decode(strtoupper($asentamiento2)), 0, 1);
$pdf->Text(35, 80, utf8_decode($telefono1));
$pdf->Text(35, 85, utf8_decode($telefono2));
$pdf->Text(120, 79, utf8_decode($diaNac."/".$nombreMesNac."/".$anioNac));
$pdf->Text(177, 78, substr($edad, 0,2));
$pdf->Text(120, 83, utf8_decode($entidadNacimiento));
$pdf->Text(120, 87, utf8_decode(strtoupper($municipioNacimiento)));
$pdf->Text(35, 96, utf8_decode($estadoCivil));
$pdf->Text(115, 96, utf8_decode($gradoEstudios));
$pdf->Text(50, 106, utf8_decode($numeroCartilla));
$pdf->Text(100,106, utf8_decode($oficio));
$pdf->SetFont('Arial','B',11);
$pdf->Text(163, 16, $empleadoEntidad."-".$empleadoConsecutivo."-".$empleadoTipo);
//NUEVOS CAMPOS DE FISICO Y PUNTO DE SERVICIOPARA EMPLEADOS
$pdf->SetFont('Arial','B',10);
$pdf->Text(56, 116, utf8_decode(strtoupper($puntoServicio)));
$pdf->Text(57, 129.5, utf8_decode($pesoEmpleado."  KG"));
$pdf->Text(95, 129.5, utf8_decode($tallaCamisa));
$pdf->Text(130, 129.5, utf8_decode($tallaPantalon));
$pdf->Text(164, 129.5, utf8_decode($estatura));
$pdf->SetFont('Arial','B',8);
//$pdf->Text(12, 249, utf8_decode(strtoupper($nombreempleo1."HSGSGFHASFGHG")));
if($foliopreseleccion!=NULL){
$pdf->SetXY(11.5, 245);
$pdf->Cell(30.5,6,utf8_decode($nombreempleo1),0,1,'C');
$pdf->SetXY(41.5, 245);
$pdf->Cell(15,6,utf8_decode($fechaempleo1desde),0,1,'C');
$pdf->SetXY(57, 245);
$pdf->Cell(15,6,utf8_decode($fechaempleo1hasta),0,1,'C');
$pdf->SetXY(71.5, 245);
$pdf->Cell(19,6,utf8_decode($telempleo1),0,1,'C');
$pdf->SetXY(90, 245);
$pdf->Cell(33,6,utf8_decode($causaseparacionempleo1),0,1,'C');
$pdf->SetXY(11.5, 252);
$pdf->Cell(30.5,6,utf8_decode($nombreempleo2), 0,1,'C');
$pdf->SetXY(41.5, 252);
$pdf->Cell(15,6,utf8_decode($fechaempleo2desde), 0,1,'C');
$pdf->SetXY(57, 252);
$pdf->Cell(15,6,utf8_decode($fechaempleo2hasta), 0,1,'C');
$pdf->SetXY(71.5, 252);
$pdf->Cell(19,6,utf8_decode($telempleo2), 0,1,'C');
$pdf->SetXY(90, 252);
$pdf->Cell(33,6,utf8_decode($causaseparacionempleo2), 0,1,'C');
$pdf->SetFont('Arial','B',11);
$pdf->SetXY(159, 250);
$pdf->Cell(38,7.5,utf8_decode($foliopreseleccion), 0,1,'C');
}
$pdf->Output();
$response = array("status" => "success");
?>

