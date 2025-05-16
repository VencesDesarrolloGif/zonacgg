<?php
session_start();
use setasign\Fpdi\Fpdi;
require_once('../libs/fpdi/src/autoload.php');
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
require('../libs/fpdf/fpdf.php');
//$log = new KLogger ( "generarCartaPatronal.log" , KLogger::DEBUG );
$negocio = new Negocio();
$response = array ();
verificarInicioSesion ($negocio);
$empleadoEntidad=$_GET["entidadEmpleado"];
$empleadoConsecutivo=$_GET["consecutivoEmpleado"];
$empleadoTipo=$_GET["tipoEmpleado"];
$usuario=$_SESSION ["userLog"];

if(empty($empleadoEntidad) || empty ($empleadoConsecutivo) || empty ($empleadoTipo)){

    $response = array(
        "status" => "error",
        "message" => "No se puede generar Contrato S.A por que no se proporcionó un número de empleado válido."
    );
    echo json_encode ($response);
    exit;
}
$empleado= $negocio -> negocio_obtenerEmpleadoPorId($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo,$usuario);
$beneficiarios= $negocio -> consultarBeneficiarios($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo);
$response["empleado"]= $empleado;
$response["beneficiarios"]= $beneficiarios;

if (empty ($empleado)){
    $response = array (
        "status" => "error",
        "message" => "El número de empleado proporcionado no se encuentra registrado en el sistema."
    );
    echo json_encode ($response);
    exit;
}
date_default_timezone_set('America/Mexico_City'); //Asignas la zona horaria de tu país.
setlocale(LC_TIME, 'spanish'); //Fijamos el tiempo local
$salarioActual=$response["empleado"][0]["salarioDiario"];
$apellidoPaterno=$response["empleado"][0]["apellidoPaterno"];
$apellidoMaterno=$response["empleado"][0]["apellidoMaterno"];
$nombreEmpleado=$response["empleado"][0]["nombreEmpleado"];
$empleadoNumeroSeguroSocial=$response["empleado"][0]["empleadoNumeroSeguroSocial"];
$rfcEmpleado=$response["empleado"][0]["rfcEmpleado"];
$calle = $response["empleado"][0]["calle"];
$numeroExterior = $response["empleado"][0]["numeroExterior"];
$numeroInterior = $response["empleado"][0]["numeroInterior"];
$fechaIngreso= $response["empleado"][0]["fechaIngresoEmpleado"];
$genero= $response["empleado"][0]["descripcionGenero"];
$estadoCivil= $response["empleado"][0]["descripcionEstadoCivil"];
$fechaNacimiento= $response["empleado"][0]["fechaNacimiento"];
$curp= $response["empleado"][0]["curpEmpleado"];
$edad=$response["empleado"][0]["edadEmp"];
$idTipoPuesto= $response["empleado"][0]["idTipoPuesto"];
$colonia= $response["empleado"][0]["nombreAsentamiento"];
$municipio=$response["empleado"][0]["nombreMunicipio"];
$cp=$response["empleado"][0]["codigoPostalAsentamiento"];
$asentamiento =$response["empleado"][0]["calle"]." ".$response["empleado"][0]["numeroExterior"]." ".$response["empleado"][0]["numeroInterior"] ;
$fechaNac=date('d-m-Y', strtotime($fechaNacimiento));
$nombreMesNac=utf8_decode(strtoupper(strftime("%B", strtotime($fechaNac)) )); // Guardamos el Nombre del día de la semana.
$diaNac=strftime("%d", strtotime($fechaNac));
$anioNac=strftime("%Y", strtotime($fechaNac));
$fechaContratacion=date('d-m-Y', strtotime($fechaIngreso));
$mesContratacion=utf8_decode(strtoupper(strftime("%B", strtotime($fechaContratacion)) )); // Guardamos el Nombre del día de la semana.
$diaContratacion=strftime("%d", strtotime($fechaContratacion));
$anioContratacion=strftime("%Y", strtotime($fechaContratacion));
$puesto=$response["empleado"][0]["descripcionPuesto"];
$municipioNac=$response["empleado"][0]["municipioNacimiento"];
$nombreEntidadFederativa=$response["empleado"][0]["nombreEntidadFederativa"];
$numeroCta=$response["empleado"][0]["numeroCta"];
$numeroCtaClabe=$response["empleado"][0]["numeroCtaClabe"];

$nombreEntidadFederativaMayusculas = strtoupper($nombreEntidadFederativa);
$asentamientoMayusculas = strtoupper($asentamiento);
$coloniaMayusculas = strtoupper($colonia);
$municipioMayusculas = strtoupper($municipio);
$municipioMayusculas = strtoupper($municipio);

$nombreEmpleado = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','A','A','A','A','A','E','E','E','E','E','E','E','E','I','I','I','I','I','I','I','I','O','O','O','O','O','O','O','O','U','U','U','U','U','U','U','U'),
   $nombreEmpleado);

$apellidoPaterno = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','A','A','A','A','A','E','E','E','E','E','E','E','E','I','I','I','I','I','I','I','I','O','O','O','O','O','O','O','O','U','U','U','U','U','U','U','U'),
   $apellidoPaterno);

$apellidoMaterno = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','A','A','A','A','A','E','E','E','E','E','E','E','E','I','I','I','I','I','I','I','I','O','O','O','O','O','O','O','O','U','U','U','U','U','U','U','U'),
   $apellidoMaterno);

$puesto = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','A','A','A','A','A','E','E','E','E','E','E','E','E','I','I','I','I','I','I','I','I','O','O','O','O','O','O','O','O','U','U','U','U','U','U','U','U'),
   $puesto);

$nombreEntidadFederativaMayusculas = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','A','A','A','A','A','E','E','E','E','E','E','E','E','I','I','I','I','I','I','I','I','O','O','O','O','O','O','O','O','U','U','U','U','U','U','U','U'),
   $nombreEntidadFederativaMayusculas);

$asentamientoMayusculas = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','A','A','A','A','A','E','E','E','E','E','E','E','E','I','I','I','I','I','I','I','I','O','O','O','O','O','O','O','O','U','U','U','U','U','U','U','U'),
   $asentamientoMayusculas);

$coloniaMayusculas = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','A','A','A','A','A','E','E','E','E','E','E','E','E','I','I','I','I','I','I','I','I','O','O','O','O','O','O','O','O','U','U','U','U','U','U','U','U'),
   $coloniaMayusculas);

$municipioMayusculas = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','A','A','A','A','A','E','E','E','E','E','E','E','E','I','I','I','I','I','I','I','I','O','O','O','O','O','O','O','O','U','U','U','U','U','U','U','U'),
   $municipioMayusculas);

$pdf = new FPDI();
if($idTipoPuesto=="02"){
    $pageCount = $pdf->setSourceFile("../archivos/contratoCapacitacionAdmin.pdf");
}else{
    $pageCount = $pdf->setSourceFile("../archivos/contratoCapacitacionOp.pdf");
}

$tplIdx = $pdf->importPage(1);
$pdf->addPage('P', 'Letter');
$pdf->useTemplate($tplIdx, null, null, null, null, true); 
$pdf->SetFont("Arial", 'B',9);
$pdf->Text(120, 50, utf8_decode($nombreEmpleado ." ".$apellidoPaterno." ".$apellidoMaterno));
$pdf->SetFont("Arial", 'B',8);
$pdf->Text(86, 200, utf8_decode($puesto));
$pdf->SetFont("Arial", 'B',9);
$pdf->Text(152, 216, substr($edad, 0,2));
$pdf->Text(110, 222, $diaNac." DE ".$nombreMesNac." DE ".$anioNac);
$pdf->Text(30, 228, utf8_decode($genero));
$pdf->Text(105, 228, utf8_decode($estadoCivil));
if($idTipoPuesto=="02"){
   $pdf->Text(58, 241, utf8_decode($curp));
}else{
      $pdf->Text(70, 241, utf8_decode($curp));
}
$pdf->Text(126, 241, utf8_decode($rfcEmpleado));
$pdf->Text(30, 247, utf8_decode($empleadoNumeroSeguroSocial));
$pdf->SetFont("Arial", 'B',8.4);
$pdf->Text(30, 234, utf8_decode($asentamientoMayusculas.", COL.".$coloniaMayusculas." ".$municipioMayusculas.", C.P".$cp.","));
$pdf->Text(30, 241, utf8_decode($nombreEntidadFederativaMayusculas));

$tplIdx = $pdf->importPage(2);
$pdf->addPage('P', 'Letter');
$pdf->useTemplate($tplIdx, null, null, null, null, true); 
$pdf->SetFont("Arial", 'B',9);

for($i=0; $i < count($beneficiarios); $i++) { 
      $nombreFamiliar=$response["beneficiarios"][$i]["nombreFamiliar"];
      $porcentajeBeneficiario=$response["beneficiarios"][$i]["porcentajeBeneficiario"];

      $nombreFamiliar = str_replace(
       array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
       array('A','A','A','A','A','A','A','A','A','E','E','E','E','E','E','E','E','I','I','I','I','I','I','I','I','O','O','O','O','O','O','O','O','U','U','U','U','U','U','U','U'),
      $nombreFamiliar);

   if($i==0) {
        $pdf->Text(32, 40, utf8_decode($nombreFamiliar));
        $pdf->Text(167, 40, utf8_decode($porcentajeBeneficiario));
   }if($i==1) {
        $pdf->Text(32, 50, utf8_decode($nombreFamiliar));
        $pdf->Text(167, 50, utf8_decode($porcentajeBeneficiario));
   }if($i==2) {
        $pdf->Text(32, 60, utf8_decode($nombreFamiliar));
        $pdf->Text(167, 60, utf8_decode($porcentajeBeneficiario));
   }
}
$pdf->SetFont("Arial", 'B',8);
$pdf->Text(84, 91, utf8_decode($puesto));
$pdf->Text(30, 179, utf8_decode($puesto));


$tplIdx = $pdf->importPage(3);
$pdf->addPage('P', 'Letter');
$pdf->useTemplate($tplIdx, null, null, null, null, true); 
$pdf->SetFont("Arial", 'B',9);
$pdf->Text(97, 114, utf8_decode($salarioActual));
$pdf->Text(132, 167, utf8_decode($numeroCta));
$pdf->Text(80, 173, utf8_decode($numeroCtaClabe));
$pdf->Text(30, 179, utf8_decode($nombreEmpleado ." ".$apellidoPaterno." ".$apellidoMaterno));


$tplIdx = $pdf->importPage(4);
$pdf->addPage('P', 'Letter');
$pdf->useTemplate($tplIdx, null, null, null, null, true); 
$pdf->SetFont("Arial", 'B',9);
$pdf->Text(34.4, 226, utf8_decode($nombreEmpleado ." ".$apellidoPaterno." ".$apellidoMaterno));

$tplIdx = $pdf->importPage(5);
$pdf->addPage('P', 'Letter');
$pdf->useTemplate($tplIdx, null, null, null, null, true); 


$tplIdx = $pdf->importPage(6);
$pdf->addPage('P', 'Letter');
$pdf->useTemplate($tplIdx, null, null, null, null, true); 

$tplIdx = $pdf->importPage(7);
$pdf->addPage('P', 'Letter');
$pdf->useTemplate($tplIdx, null, null, null, null, true); 
$pdf->SetFont("Arial", 'B',8);
$pdf->Text(115, 45, $diaContratacion." DE ".$mesContratacion." DE ".$anioContratacion);
$pdf->SetFont("Arial", 'B',9);
$pdf->Text(118, 90, utf8_decode($nombreEmpleado ." ".$apellidoPaterno." ".$apellidoMaterno));
$pdf->Output();
$response = array("status" => "success");

?>

