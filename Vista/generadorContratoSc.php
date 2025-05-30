<?php
session_start();
use setasign\Fpdi\Fpdi;
require_once('../libs/fpdi/src/autoload.php');
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
require('../libs/fpdf/fpdf.php');
// $log = new KLogger ( "Ajax_contratoTiempoIndeterminado.log" , KLogger::DEBUG );
$negocio = new Negocio();
$response = array ();
verificarInicioSesion ($negocio);
$empleadoEntidad=$_GET["entidadEmpleado"];
$empleadoConsecutivo=$_GET["consecutivoEmpleado"];
$empleadoTipo=$_GET["tipoEmpleado"];
$usuario=$_SESSION ["userLog"];
if (empty($empleadoEntidad) || empty ($empleadoConsecutivo) || empty ($empleadoTipo)){
    $response = array (
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
if(empty ($empleado)){
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
// $diasEdad= $response["empleado"][0]["diasEdad"];//pendiente d equitar
$edad=$response["empleado"][0]["edadEmp"];
$idTipoPuesto= $response["empleado"][0]["idTipoPuesto"];
$colonia= $response["empleado"][0]["nombreAsentamiento"];
$municipio=$response["empleado"][0]["nombreMunicipio"];
$cp=$response["empleado"][0]["codigoPostalAsentamiento"];
$nombreBanco=$response["empleado"][0]["nombreBanco"];
$asentamiento =$response["empleado"][0]["calle"]." ".$response["empleado"][0]["numeroExterior"]." ".$response["empleado"][0]["numeroInterior"] ;
$fechaNac=date('d-m-Y', strtotime($fechaNacimiento));
$nombreMesNac=utf8_decode(strtoupper(strftime("%B", strtotime($fechaNac)) )); // Guardamos el Nombre del día de la semana.
$diaNac=strftime("%d", strtotime($fechaNac));
$anioNac=strftime("%Y", strtotime($fechaNac));

$fechaContratacion=date('d-m-Y', strtotime($fechaIngreso));
$fechaPrueba= date("d-m-Y",strtotime($fechaContratacion."+ 30 days"));
$anioPrueba=strftime("%Y", strtotime($fechaPrueba));
$mesPrueba=utf8_decode(strtoupper(strftime("%B", strtotime($fechaPrueba)) )); // Guardamos el Nombre del día de la semana.
$diaPrueba=strftime("%d", strtotime($fechaPrueba));

$fechaContratacionDiagonal = str_replace(
   array('-'),
   array('/'),
   $fechaContratacion);


$mesContratacion=utf8_decode(strtoupper(strftime("%B", strtotime($fechaContratacion)) )); // Guardamos el Nombre del día de la semana.
$diaContratacion=strftime("%d", strtotime($fechaContratacion));
$anioContratacion=strftime("%Y", strtotime($fechaContratacion));

$puesto=$response["empleado"][0]["descripcionPuesto"];
$municipioNac=$response["empleado"][0]["municipioNacimiento"];
$nombreEntidadFederativa=$response["empleado"][0]["nombreEntidadFederativa"];
$numeroCta=$response["empleado"][0]["numeroCta"];
$numeroCtaClabe=$response["empleado"][0]["numeroCtaClabe"];
$entidadContratacion=$response["empleado"][0]["entidadContratacion"];

$nombreEntidadFederativaMayusculas = strtoupper($nombreEntidadFederativa);
$asentamientoMayusculas = strtoupper($asentamiento);
$coloniaMayusculas = strtoupper($colonia);
$municipioMayusculas = strtoupper($municipio);
$municipioMayusculas = strtoupper($municipio);
$entidadContratacionMayusculas = strtoupper($entidadContratacion);

$entidadContratacionMayusculas = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('Á','A','A','A','Á','A','A','A','A','É','E','E','E','É','E','E','E','Í','I','I','I','Í','I','I','I','Ó','O','O','O','Ó','O','O','O','Ú','U','U','U','Ú','U','U','U'),
   $entidadContratacionMayusculas);

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
    $pageCount = $pdf->setSourceFile("../archivos/contratoTiempoIndeterminadoAdministrativos.pdf");
}else{
    $pageCount = $pdf->setSourceFile("../archivos/contratoTiempoIndeterminadoOp.pdf");
}

//////(X,Y)
$tplIdx = $pdf->importPage(1);
$pdf->addPage('P', 'Letter');
$pdf->useTemplate($tplIdx, null, null, null, null, true); 
$pdf->SetFont("Arial", 'B',9);
$pdf->Text(130, 41, utf8_decode($nombreEmpleado ." ".$apellidoPaterno." ".$apellidoMaterno));
$pdf->SetFont("Arial", 'B',8);

if($idTipoPuesto=="02"){
    $pdf->Text(114, 178, utf8_decode($puesto));
}else{
      $pdf->Text(112, 177.5, utf8_decode($puesto));
}

$tplIdx = $pdf->importPage(2);
$pdf->addPage('P', 'Letter');
$pdf->useTemplate($tplIdx, null, null, null, null, true); 
$pdf->SetFont("Arial", 'B',9);


if($idTipoPuesto=="02"){
    $pdf->Text(155, 35, substr($edad, 0,2));
    $pdf->Text(70, 35, $diaNac." DE ".$nombreMesNac." DE ".$anioNac);
    $pdf->Text(155, 35, utf8_decode($genero));
    $pdf->Text(75, 41, utf8_decode($estadoCivil));
    $pdf->Text(47, 53, utf8_decode($curp));
    $pdf->Text(117, 53, utf8_decode($rfcEmpleado));
    $pdf->Text(30, 59, utf8_decode($empleadoNumeroSeguroSocial));
    $pdf->Text(157, 238, utf8_decode($fechaContratacionDiagonal));
    $pdf->Text(107, 243.5, utf8_decode($puesto));

    $pdf->SetFont("Arial", 'B',8);
    $pdf->Text(30,47, utf8_decode($asentamientoMayusculas.", COL.".$coloniaMayusculas." ".$municipioMayusculas.", C.P".$cp.",".$nombreEntidadFederativaMayusculas));
    // $pdf->Text(30, 53, utf8_decode($nombreEntidadFederativaMayusculas));
}else{
      $pdf->Text(152, 29, substr($edad, 0,2));
      $pdf->Text(87, 35, $diaNac." DE ".$nombreMesNac." DE ".$anioNac);
      $pdf->Text(30, 41, utf8_decode($genero));
      $pdf->Text(105, 41, utf8_decode($estadoCivil));

      $pdf->Text(138, 54, utf8_decode($curp));
      $pdf->Text(43, 60, utf8_decode($rfcEmpleado));
      $pdf->Text(115, 60, utf8_decode($empleadoNumeroSeguroSocial));
      $pdf->Text(40, 243, utf8_decode($fechaContratacionDiagonal));
      $pdf->Text(31, 249, utf8_decode($puesto));

      $pdf->SetFont("Arial", 'B',8);
      $pdf->Text(30,47, utf8_decode($asentamientoMayusculas.", COL.".$coloniaMayusculas." ".$municipioMayusculas.", C.P".$cp.","));
      $pdf->Text(30, 53, utf8_decode($nombreEntidadFederativaMayusculas));
}

for($i=0; $i < count($beneficiarios); $i++) { 
      $nombreFamiliar=$response["beneficiarios"][$i]["nombreFamiliar"];
      $porcentajeBeneficiario=$response["beneficiarios"][$i]["porcentajeBeneficiario"];

      $nombreFamiliar = str_replace(
       array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
       array('A','A','A','A','A','A','A','A','A','E','E','E','E','E','E','E','E','I','I','I','I','I','I','I','I','O','O','O','O','O','O','O','O','U','U','U','U','U','U','U','U'),
      $nombreFamiliar);

      if($idTipoPuesto=="02"){
      
      
         if($i==0) {
              $pdf->Text(32, 83, utf8_decode($nombreFamiliar));
              $pdf->Text(167, 83, utf8_decode($porcentajeBeneficiario));
         }if($i==1) {
              $pdf->Text(32, 93, utf8_decode($nombreFamiliar));
              $pdf->Text(167, 93, utf8_decode($porcentajeBeneficiario));
         }if($i==2) {
              $pdf->Text(32, 103, utf8_decode($nombreFamiliar));
              $pdf->Text(167, 103, utf8_decode($porcentajeBeneficiario));
         }
      }else{
        if($i==0) {
              $pdf->Text(32, 90, utf8_decode($nombreFamiliar));
              $pdf->Text(167, 90, utf8_decode($porcentajeBeneficiario));
         }if($i==1) {
              $pdf->Text(32, 100, utf8_decode($nombreFamiliar));
              $pdf->Text(167, 100, utf8_decode($porcentajeBeneficiario));
         }if($i==2) {
              $pdf->Text(32, 110, utf8_decode($nombreFamiliar));
              $pdf->Text(167, 110, utf8_decode($porcentajeBeneficiario));
         }
      }//else
}

$tplIdx = $pdf->importPage(3);
$pdf->addPage('P', 'Letter');
$pdf->useTemplate($tplIdx, null, null, null, null, true); 
$pdf->SetFont("Arial", 'B',9);
if($idTipoPuesto=="02"){
   $pdf->Text(97, 196.5, utf8_decode($salarioActual));
   $pdf->Text(92, 250, utf8_decode($nombreEmpleado ." ".$apellidoPaterno." ".$apellidoMaterno));
   $pdf->Text(148, 250, utf8_decode($numeroCta));
}else{
   $pdf->Text(100, 220, utf8_decode($salarioActual));
}

$tplIdx = $pdf->importPage(4);
$pdf->addPage('P', 'Letter');
$pdf->useTemplate($tplIdx, null, null, null, null, true); 
$pdf->SetFont("Arial", 'B',9);
if($idTipoPuesto=="02"){
   $pdf->Text(72, 29, utf8_decode($numeroCtaClabe));
   $pdf->Text(124, 29, utf8_decode($nombreBanco));
}else{
   $pdf->Text(130, 47, utf8_decode($numeroCta));
   $pdf->Text(80, 54, utf8_decode($numeroCtaClabe));
   $pdf->Text(30, 60, utf8_decode($nombreEmpleado ." ".$apellidoPaterno." ".$apellidoMaterno));
}
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
$pdf->SetFont("Arial", 'B',9);
if($idTipoPuesto=="02"){
   $pdf->Text(34, 204, utf8_decode($nombreEmpleado ." ".$apellidoPaterno." ".$apellidoMaterno));
}else{
   $pdf->Text(34, 236, utf8_decode($nombreEmpleado ." ".$apellidoPaterno." ".$apellidoMaterno));
}
      
    $tplIdx = $pdf->importPage(8);
    $pdf->addPage('P', 'Letter');
    $pdf->useTemplate($tplIdx, null, null, null, null, true);
    if($idTipoPuesto=="03"){
        $pdf->Text(36, 196, $fechaContratacionDiagonal);
        $pdf->Text(122, 247, utf8_decode($nombreEmpleado ." ".$apellidoPaterno." ".$apellidoMaterno));
        // $pdf->Text(30, 196, utf8_decode($entidadContratacionMayusculas));
    }

if($idTipoPuesto=="02"){
    $tplIdx = $pdf->importPage(9);
    $pdf->addPage('P', 'Letter');
    $pdf->useTemplate($tplIdx, null, null, null, null, true);
    
    $tplIdx = $pdf->importPage(10);
    $pdf->addPage('P', 'Letter');
    $pdf->useTemplate($tplIdx, null, null, null, null, true);
    
    $tplIdx = $pdf->importPage(11);
    $pdf->addPage('P', 'Letter');
    $pdf->useTemplate($tplIdx, null, null, null, null, true);

    if($idTipoPuesto=="02"){
       $pdf->Text(144, 67, $fechaContratacionDiagonal);
       $pdf->Text(136, 117, utf8_decode($nombreEmpleado ." ".$apellidoPaterno." ".$apellidoMaterno));
    }else{
          $pdf->Text(124, 67, $diaContratacion." DE ".$mesContratacion." DE ".$anioContratacion);
          $pdf->Text(136, 112, utf8_decode($nombreEmpleado ." ".$apellidoPaterno." ".$apellidoMaterno));
    }
}

$pdf->Output();
$response = array("status" => "success");
?>