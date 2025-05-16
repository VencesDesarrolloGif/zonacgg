<?php
session_start();
require "conexion.php";
use setasign\Fpdi\Fpdi;
require_once('../libs/fpdi/src/autoload.php');
require_once("../libs/logger/KLogger.php");
// require_once("../../libs/logger/KLogger.php");
// require "../conexion.php";
// $log = new KLogger ( "generarCredencial.log" , KLogger::DEBUG );
require('../libs/fpdf/fpdf.php');
// require('../libs/fpdi/fpdi.php');
require('../libs/barcode/barcode.inc.php');
//enviar el usuario para que pueda traer la consulta negocio_obtenerEmpleadoPorId

$usuario=$_SESSION ["userLog"];
$response = array ();

$empleadoEntidad=$_GET["entidadEmpleado"];
$empleadoConsecutivo=$_GET["consecutivoEmpleado"];
$empleadoTipo=$_GET["tipoEmpleado"];

if(empty($empleadoEntidad) || empty ($empleadoConsecutivo) || empty ($empleadoTipo)){

    $response = array (
        "status" => "error",
        "message" => "No se puede generar credencial por que no se proporcionó un número de empleado válido."
    );
    echo json_encode ($response);
    exit;
}

$sql = "SELECT NumAcuerdo,NumFolioIngreso 
        FROM catalogorepse
        WHERE idRepse=(SELECT max(idRepse) FROM catalogorepse)";

    $res = mysqli_query($conexion, $sql);
        
    while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {
           $repse[] = $reg;
    }
$NumAcuerdo = $repse[0]["NumAcuerdo"];
$NumFolioIngreso = $repse[0]["NumFolioIngreso"];

$empleado= $negocio -> negocio_obtenerEmpleadoPorId($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo,$usuario);

$sql1 = "SELECT e.apellidoPaterno,e.apellidoMaterno,e.nombreEmpleado,e.empleadoNumeroSeguroSocial,dp.rfcEmpleado,dir.calle,dir.numeroExterior,dir.numeroInterior,e.fechaIngresoEmpleado,dp.curpEmpleado,cp.descripcionPuesto,e.fotoEmpleado,e.fotoFirma,cta.nombreTipoAsentamiento,a.nombreAsentamiento,cma.nombreMunicipio,ef.nombreEntidadFederativa
        FROM empleados e
        LEFT JOIN datospersonales dp on ( e.entidadFederativaId= dp.empleadoEntidadPersonal AND e.empleadoConsecutivoId=dp.empleadoConsecutivoPersonal AND
        e.empleadoCategoriaId=dp.empleadoCategoriaPersonal)
        LEFT JOIN directorio dir on ( e.entidadFederativaId= dir.entidadEmpleadoDirectorio AND e.empleadoConsecutivoId=dir.consecutivoEmpleadoDirectorio AND
        e.empleadoCategoriaId=dir.categoriaEmpleadoDirectorio)
        LEFT JOIN catalogopuestos cp on (cp.idPuesto=e.empleadoIdPuesto)
        LEFT  JOIN catalogotiposasentamientos cta on (cta.idTipoAsentamiento=a.asentamientoTipo)
        LEFT JOIN asentamientos a on (dir.idAsentamientoDireccion=a.idAsentamiento)
        LEFT JOIN catalogomunicipios cma on (cma.idMunicipio=a.municipioAsentamiento)
        LEFT JOIN entidadesfederativas ef on (ef.idEntidadFederativa=cma.idEstado)
        WHERE (e.entidadFederativaId = '$empleadoEntidad') AND (e.empleadoConsecutivoId = '$empleadoConsecutivo') AND (e.empleadoCategoriaId = '$empleadoTipo')";

    $res1 = mysqli_query($conexion, $sql1);
        
    while(($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))) {
           $empleado[] = $reg1;
    }

    $response["empleado"]= $empleado;

if(empty($empleado)){
    $response = array (
        "status" => "error",
        "message" => "El número de empleado proporcionado no se encuentra registrado en el sistema."
    );
    echo json_encode ($response);
    exit;
}

date_default_timezone_set('America/Mexico_City'); //Asignas la zona horaria de tu país.
setlocale(LC_TIME, 'spanish'); //Fijamos el tiempo local
$apellidoPaterno=$response["empleado"][0]["apellidoPaterno"];
$apellidoMaterno=$response["empleado"][0]["apellidoMaterno"];
$nombreEmpleado=$response["empleado"][0]["nombreEmpleado"];
$empleadoNumeroSeguroSocial=$response["empleado"][0]["empleadoNumeroSeguroSocial"];
$rfcEmpleado=$response["empleado"][0]["rfcEmpleado"];
$calle = $response["empleado"][0]["calle"];
$numeroExterior = $response["empleado"][0]["numeroExterior"];
$numeroInterior = $response["empleado"][0]["numeroInterior"];
$fechaIngreso= $response["empleado"][0]["fechaIngresoEmpleado"];
$curp= $response["empleado"][0]["curpEmpleado"];
$puesto=$response["empleado"][0]["descripcionPuesto"];
$fotoEmpleado=$response["empleado"][0]["fotoEmpleado"];
$fotoFirma=$response["empleado"][0]["fotoFirma"];

$fecha2=date("m-d-Y",strtotime($fechaIngreso));

$asentamiento =$response["empleado"][0]["calle"]." ".$response["empleado"][0]["numeroExterior"]." ".$response["empleado"][0]["numeroInterior"]." ". $response["empleado"][0]["nombreTipoAsentamiento"]." ". $response["empleado"][0]["nombreAsentamiento"];

$asentamiento2=$asentamiento." ".$response["empleado"][0]["nombreMunicipio"].", ".$response["empleado"][0]["nombreEntidadFederativa"].", C.P. 56606";
$fecha3=date('d-m-Y', strtotime($fechaIngreso));
$diaSemana=utf8_decode(strtoupper(strftime("%A", strtotime($fecha3)) )); 
$nombreMes=utf8_decode(strtoupper(strftime("%B", strtotime($fecha3)) )); // Guardamos el Nombre del día de la semana.
$dia=strftime("%d", strtotime($fecha3));
$anio=strftime("%Y", strtotime($fecha3));
$mes=strftime("%M", strtotime($fecha3));

$pdf = new FPDI();

$pageCount = $pdf->setSourceFile("../archivos/NC2.pdf");
$tplIdx = $pdf->importPage(1);

$pdf->addPage('P', 'Letter');

$pdf->useTemplate($tplIdx, 0.6, 2, 210);
$pdf->SetMargins(0, 0 , 0); 

$pdf->SetFont("Arial", 'B',7);

$pdf->SetFont("Arial", '',7);

$rutaImagen="uploads/fotosempleados/".$fotoEmpleado;

$pdf->SetFont("Arial", '',7);

$pdf->SetFont("Arial", 'B',8);
$pdf->SetTextColor(29,96,131);

$pdf->SetXY(0.3, 61.5);
$pdf->MultiCell(54, 2, utf8_decode(strtoupper($nombreEmpleado)),0,'C',0);

$pdf->SetXY(0.3, 66);
$pdf->MultiCell(54,2,utf8_decode($apellidoPaterno)." ".utf8_decode($apellidoMaterno),0,'C',0);

$pdf->SetXY(0.3, 70);
$pdf->MultiCell(54,2,utf8_decode($puesto),0,'C',0);

$pdf->Image($rutaImagen,13,28.6,28.2,32);

$tplIdx = $pdf->importPage(2);
$pdf->addPage('P', 'Letter');
$pdf->useTemplate($tplIdx, null, null, null, null, true);

$pdf->SetFont("Arial", 'B',6);
$pdf->SetTextColor(255,255,255);
$pdf->Text(44, 84.1, date("Y"));

$pdf->SetFont("Arial", 'B',5);
$pdf->SetTextColor(0,0,0);
$pdf->Text(1, 4.8, "No. de acuerdo:");
$pdf->SetFont("Arial", '',3.7);
$pdf->SetTextColor(0,0,0);
$pdf->Text(0.5, 7.5, $NumAcuerdo);

$pdf->SetFont("Arial", 'B',4.5);
$pdf->SetTextColor(0,0,0);
$pdf->Text(38, 4.8, "No. de folio Ingreso:");
$pdf->SetFont("Arial", '',6);
$pdf->SetTextColor(0,0,0);
$pdf->Text(39, 7.5, $NumFolioIngreso);

$pdf->SetFont("Arial", '',11);
$pdf->SetTextColor(0,0,0);
$pdf->Text(20, 12.5, $empleadoEntidad."-".$empleadoConsecutivo."-".$empleadoTipo);

$pdf->SetFont("Arial", '',5.5);
$pdf->SetTextColor(0,0,0);
$pdf->Text(11.3, 16, "DGSP/188-12/2082");
$pdf->Text(41,16,$fecha3);
$pdf->Text(11.3, 20.5, "0439-16");
$pdf->Text(42, 20.5, "4094-16");
$pdf->Text(7, 24.5, $empleadoNumeroSeguroSocial);
$pdf->Text(30, 24.5, $curp);

$pdf->Image('../archivos/supervisor2.jpg',28,26.5,23);

$code='img/barcode/barcode_'.$empleadoEntidad."-".$empleadoConsecutivo."-".$empleadoTipo.'.gif';

$A=new barCodeGenrator('*'.$empleadoEntidad."-".$empleadoConsecutivo."-".$empleadoTipo.'*',1,$code, 120, 100, true);

$log -> LogInfo ("sessiok ".var_export ($A, true));
$pdf->Image($code,10,39,33.5,20);

if($fotoFirma!=""){
   $rutaFirma="uploads/firmas/".$fotoFirma;
   $pdf->Image($rutaFirma,3,24.5,22);
}

$pdf->Output();
$response = array("status" => "success");

?>