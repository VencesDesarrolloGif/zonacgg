<?php
session_start();
use setasign\Fpdi\Fpdi;
require_once('../libs/fpdi/src/autoload.php');
require "conexion.php";
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
require('../libs/fpdf/fpdf.php');
$log = new KLogger ( "generadorPolizaDeVida.log" , KLogger::DEBUG );
$response = array ();
$datos  = array();
// verificarInicioSesion ($negocio);
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

$sql = "SELECT e.fechaIngresoEmpleado, concat_ws(' ',e.nombreEmpleado,e.apellidoPaterno,e.apellidoMaterno) as nombreEmpleado,d.nombreFamiliar,d.idParentescoFamiliar as idParentesco,d.descripcionParentesco as ParentescoDirecto,cp.descripcionParentesco as ParentescoAnterior,dp.fechaNacimiento,d.porcentajeBeneficiario
    from empleados e 
    left join datosfamiliares d on (e.entidadFederativaId=d.idEntidadEmpleadoFamiliar and e.empleadoConsecutivoId=d.idConsecutivoEmpleadoFamiliar and e.empleadoCategoriaId=d.idCategoriaEmpleadoFamiliar and beneficiario='1')
    left join catalogoparentescos cp ON (cp.idParentesco=d.idParentescoFamiliar)
    left join datospersonales dp on (e.entidadFederativaId=dp.empleadoEntidadPersonal and e.empleadoConsecutivoId=dp.empleadoConsecutivoPersonal and e.empleadoCategoriaId=dp.empleadoCategoriaPersonal)
    where concat_ws('-',e.entidadFederativaId,e.empleadoConsecutivoId,e.empleadoCategoriaId) = '$folio'";
    $res = mysqli_query($conexion, $sql);
     while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }
    if (empty ($datos))
    {
        $response = array (
        "status" => "error",
        "message" => "El folio del aspirante no se encuentra registrado en el sistema."
        );
        echo json_encode ($response);
        exit;
    }
date_default_timezone_set('America/Mexico_City'); //Asignas la zona horaria de tu país.
setlocale(LC_TIME, 'spanish'); //Fijamos el tiempo local




$fechaIngresoEmpleado1=$datos[0]["fechaIngresoEmpleado"];
$a = explode('-',$fechaIngresoEmpleado1);
$fechaIngresoEmpleado = $a[2]."-".$a[1]."-".$a[0];
$nombreEmpleado=$datos[0]["nombreEmpleado"];
$fechaNacimiento1=$datos[0]["fechaNacimiento"];
$b = explode('-',$fechaNacimiento1);
$fechaNacimiento = $b[2]."-".$b[1]."-".$b[0];

// $fechaNac=date('d-m-Y', strtotime($fechaNacimiento));
// $nombreMesNac=utf8_decode(strtoupper(strftime("%B", strtotime($fechaNac)) )); // Guardamos el Nombre del día de la semana.
// $diaNac=strftime("%d", strtotime($fechaNac));
// $anioNac=strftime("%Y", strtotime($fechaNac));

$pdf = new FPDI();

$pageCount = $pdf->setSourceFile("../archivos/expediente/seguroDeVida.pdf");
$tplIdx = $pdf->importPage(1);

$pdf->addPage('P', 'Letter');
$pdf->useTemplate($tplIdx, null, null, null, null, true); 
$pdf->SetFont("Arial", 'B',15);


// $pdf->Text(110, 105, utf8_decode($diaNac." DE ".$nombreMesNac." DE ".$anioNac));
$pdf->Text(55, 157, utf8_decode(strtoupper($fechaIngresoEmpleado)));
$pdf->Text(140, 157, utf8_decode(strtoupper($fechaNacimiento)));
$pdf->Text(30, 173, utf8_decode(strtoupper($nombreEmpleado)));
$largoDatos = count($datos);
                                                                    $log -> LogInfo ("largoDatos ".var_export ($largoDatos, true));


$pdf->SetFont("Arial", 'B',12);
if($largoDatos>= "3"){
    $log -> LogInfo ("largoDatos33333 ".var_export ($largoDatos, true));
    for ($i=0; $i < 3; $i++) { 
        $nombreFamiliar=$datos[$i]["nombreFamiliar"];
        $idParentesco=$datos[$i]["idParentesco"];
        $porcentajeBeneficiario=$datos[$i]["porcentajeBeneficiario"];
        if($idParentesco<="13"){
            $Parentesco=$datos[$i]["ParentescoAnterior"];
        }else{
            $Parentesco=$datos[$i]["ParentescoDirecto"];
        }
        if($i=="0"){
            $pdf->Text(22, 190, utf8_decode(strtoupper($nombreFamiliar)));
            $pdf->Text(125, 190, utf8_decode(strtoupper($Parentesco)));
            $pdf->Text(175, 190, utf8_decode(strtoupper($porcentajeBeneficiario)));

        }else if($i=="1"){
            $pdf->Text(22, 200, utf8_decode(strtoupper($nombreFamiliar)));
            $pdf->Text(125, 200, utf8_decode(strtoupper($Parentesco)));
            $pdf->Text(175, 200, utf8_decode(strtoupper($porcentajeBeneficiario)));

        }else{
            $pdf->Text(22, 210, utf8_decode(strtoupper($nombreFamiliar)));
            $pdf->Text(125, 210, utf8_decode(strtoupper($Parentesco)));
            $pdf->Text(175, 210, utf8_decode(strtoupper($porcentajeBeneficiario)));

        }
    }
}else if($largoDatos== "2"){
    $log -> LogInfo ("largoDatos222 ".var_export ($largoDatos, true));
        for ($i=0; $i < 2; $i++) { 
            $nombreFamiliar=$datos[$i]["nombreFamiliar"];
            $idParentesco=$datos[$i]["idParentesco"];
            $porcentajeBeneficiario=$datos[$i]["porcentajeBeneficiario"];
            if($idParentesco<="13"){
                $Parentesco=$datos[$i]["ParentescoAnterior"];
            }else{
                $Parentesco=$datos[$i]["ParentescoDirecto"];
            }
        if($i=="0"){
            $pdf->Text(22, 190, utf8_decode(strtoupper($nombreFamiliar)));
            $pdf->Text(125, 190, utf8_decode(strtoupper($Parentesco)));
            $pdf->Text(175, 190, utf8_decode(strtoupper($porcentajeBeneficiario))."%");

        }else{
            $pdf->Text(22, 200, utf8_decode(strtoupper($nombreFamiliar)));
            $pdf->Text(125, 200, utf8_decode(strtoupper($Parentesco)));
            $pdf->Text(175, 200, utf8_decode(strtoupper($porcentajeBeneficiario))."%");

        }
    }
}else{
    $log -> LogInfo ("largoDatos11111 ".var_export ($largoDatos, true));
    $Verificacion = $datos[0]["idParentesco"];
    if($Verificacion !="" && $Verificacion !="null" && $Verificacion !="NULL" && $Verificacion != null && $Verificacion != NULL && $Verificacion !="0" ){
        $nombreFamiliar=$datos[0]["nombreFamiliar"];
        $idParentesco=$datos[0]["idParentesco"];
        $porcentajeBeneficiario=$datos[0]["porcentajeBeneficiario"];
        if($idParentesco<="13"){
            $Parentesco=$datos[0]["ParentescoAnterior"];
        }else{
            $Parentesco=$datos[0]["ParentescoDirecto"];
        }
        $pdf->Text(22, 190, utf8_decode(strtoupper($nombreFamiliar)));
        $pdf->Text(125, 190, utf8_decode(strtoupper($Parentesco)));
        $pdf->Text(175, 190, utf8_decode(strtoupper($porcentajeBeneficiario)));

    }
}

$pdf->Output();
$response = array("status" => "success");



?>

